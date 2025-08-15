<template>
  <svg :viewBox="`0 0 ${boxW} ${boxH}`" class="w-full h-full" role="img" aria-label="Speakers honeycomb">
    <defs>
      <clipPath v-for="(g, i) in gridToShow" :key="i" :id="clipId(i)">
        <polygon :points="hexPointsPointy(g.x, g.y, R)" />
      </clipPath>
    </defs>

    <g v-for="(g, i) in gridToShow" :key="i">
      <g :clip-path="`url(#${clipId(i)})`" :style="{ '--fade-ms': fadeMs + 'ms', '--overlay-opacity': overlayOpacity }">
        <image v-if="state[i]" class="hex-img" :class="{ hidden: state[i].showNext }"
               :href="pool[state[i].currIdx].src" :x="g.x - R" :y="g.y - R" :width="2 * R" :height="2 * R"
               preserveAspectRatio="xMidYMid slice"/>
        <image v-if="state[i] && state[i].nextIdx !== null" class="hex-img next" :class="{ visible: state[i].showNext }"
               :href="pool[state[i].nextIdx].src" :x="g.x - R" :y="g.y - R" :width="2 * R" :height="2 * R"
               preserveAspectRatio="xMidYMid slice"/>
        <rect class="overlay" :class="{ show: state[i]?.overlay }" :x="g.x - R" :y="g.y - R" :width="2 * R" :height="2 * R"/>
      </g>

      <polygon :points="hexPointsPointy(g.x, g.y, R)" fill="none" :stroke="strokeColor" :stroke-width="strokeWidth" stroke-linejoin="round"/>
    </g>
  </svg>
</template>

<script setup>
import { ref, computed, watch, onMounted, onBeforeUnmount } from 'vue'

const props = defineProps({
  images: { type: Array, required: true },
  radius: { type: Number, default: 100 },
  strokeColor: { type: String, default: '#ffffff' },
  strokeWidth: { type: Number, default: 2 },
  uid: { type: String, default: () => Math.random().toString(36).slice(2) },
  shuffle: { type: Boolean, default: true },
  intervalMs: { type: Number, default: 2400 },
  fadeMs: { type: Number, default: 1200 },
  overlayOpacity: { type: Number, default: 0.45 },
  batchSize: { type: Number, default: 1 },
  avoidDuplicates: { type: Boolean, default: true },
  dedupeKey: { type: String, default: 'filename' }, // 'filename' | 'path' | 'exact'
})


const R = props.radius
const HEX_W = 5 * R
const HEX_H = Math.sqrt(2) * R
const STEP_X = Math.sqrt(3) * R
const STEP_Y = 1.5 * R


const rowCountsBase = [4, 5, 6, 2, 5, 6, 5, 4, 3]

const padX = 500, padY = 50
const widest = Math.max(...rowCountsBase)
const widestRowWidth = HEX_W + (widest - 2) * STEP_X
const boxW = padX * 0.4 + widestRowWidth
const boxH = padY * 0.5 + HEX_H + (rowCountsBase.length - 6) * STEP_Y


const grid = computed(() => {
  const out = []
  rowCountsBase.forEach((count, row) => {
    const y = padY + HEX_H / 3 + row * STEP_Y
    const rowWidth = HEX_W + (count - 1) * STEP_X
    const startX = (boxW - rowWidth) / 2 + HEX_W / 2
    for (let col = 0; col < count; col++) out.push({ x: startX + col * STEP_X, y, row, col })
  })
  return out
})

/* ---------- canonicalize + dedupe ---------- */
function canonicalKey(url, mode = 'filename') {
  let original = String(url || '').trim()
  if (!original) return ''
  let path = original
  try { if (path.startsWith('http')) path = new URL(path).pathname } catch {}
  path = path.split('#')[0].split('?')[0]
  try { path = decodeURIComponent(path) } catch {}
  path = path.toLowerCase()
  if (mode === 'exact') return original.toLowerCase()
  if (mode === 'path') return path
  const seg = path.split('/').filter(Boolean).pop() || path
  return seg.replace(/\.[a-z0-9]+$/i,'').replace(/-\d+x\d+$/,'').replace(/@2x|@3x|_2x|_3x/gi,'')
            .replace(/\((\d+)\)$/,'').replace(/[-_ ]copy(\s*\d+)?/i,'').trim()
}

/** pool = [{src,key}] */
const pool = computed(() => {
  const seen = new Set(), out = []
  for (const src of props.images || []) {
    const key = canonicalKey(src, props.dedupeKey)
    if (!key || seen.has(key)) continue
    seen.add(key); out.push({ src, key })
  }
  return out
})
const POOL_LEN = computed(() => pool.value.length)

/** only render as many hexes as unique images */
const visibleCount = computed(() => Math.min(grid.value.length, POOL_LEN.value))
const gridToShow   = computed(() => grid.value.slice(0, visibleCount.value))

/* ---------- helpers ---------- */
function hexPointsPointy(cx, cy, r) {
  const pts = []
  for (let i = 0; i < 6; i++) {
    const ang = ((60 * i - 30) * Math.PI) / 180
    pts.push(`${cx + r * Math.cos(ang)},${cy + r * Math.sin(ang)}`)
  }
  return pts.join(' ')
}
function clipId(i){ return `hexclip-${props.uid}-${i}` }
function randInt(max){ return Math.floor(Math.random() * max) }
function shuffleInPlace(a){ for (let i=a.length-1;i>0;i--){const j=Math.floor(Math.random()*(i+1));[a[i],a[j]]=[a[j],a[i]]} return a }

/** neighbor indices: same row OR (row±1 & col diff ≤1) */
function neighborIndices(i){
  const gi = gridToShow.value[i]; const out=[]
  for (let j=0;j<gridToShow.value.length;j++){
    if (j===i) continue
    const gj = gridToShow.value[j]
    if (gj.row === gi.row) out.push(j)
    else if (Math.abs(gj.row - gi.row) === 1 && Math.abs(gj.col - gi.col) <= 1) out.push(j)
  }
  return out
}
function canPlaceKeyAtIndex(key, index, keyByIndex){
  for (const j of neighborIndices(index)){
    if (keyByIndex[j] === key) return false
  }
  return true
}
function canSwap(i, j, keyByIndex){
  const keyI = keyByIndex[i], keyJ = keyByIndex[j]
  if (keyI === keyJ) return false
  // simulate swap
  return canPlaceKeyAtIndex(keyJ, i, {...keyByIndex, [i]: keyJ, [j]: keyI}) &&
         canPlaceKeyAtIndex(keyI, j, {...keyByIndex, [i]: keyJ, [j]: keyI})
}

/* ---------- rotation queue (for pool > visible) ---------- */
let rotationQueue = []
function refillQueueExcluding(excludeKeys){
  const all = [...Array(POOL_LEN.value).keys()]
  const candidates = all.filter(i => !excludeKeys.has(pool.value[i].key))
  shuffleInPlace(candidates); rotationQueue = candidates
}
function takeFromQueue(excludeKeys){
  let tries = rotationQueue.length
  while (tries-- > 0){
    const idx = rotationQueue.shift()
    if (!excludeKeys.has(pool.value[idx].key)) return idx
    rotationQueue.push(idx)
  }
  return null
}

const state = ref([]) 
let timer = null
const t1 = new Map(), t2 = new Map()

function initState(){
  const n = visibleCount.value
  const allIdx = [...Array(POOL_LEN.value).keys()]
  shuffleInPlace(allIdx)

  let initial = [], queue=[]
  if (POOL_LEN.value >= n && props.avoidDuplicates){
    initial = allIdx.slice(0,n); queue = allIdx.slice(n)
  } else {
    initial = allIdx.slice(0,n)
  }
  rotationQueue = queue

  state.value = Array.from({length:n},(_,i)=>({
    currIdx: initial[i] ?? 0, nextIdx:null, prevIdx:null, overlay:false, showNext:false, busy:false
  }))
}

function animateTo(i, nextIdx){
  const s = state.value[i]; if (!s || s.busy) return
  s.busy = true; s.prevIdx = s.currIdx; s.nextIdx = nextIdx; s.overlay = true; s.showNext = false
  const half = Math.max(1, Math.floor(props.fadeMs/2))
  const mid = setTimeout(()=>{ s.showNext = true }, half); t1.set(i, mid)
  const end = setTimeout(()=>{
    s.currIdx = s.nextIdx; s.nextIdx = null; s.overlay = false; s.showNext = false; s.busy = false
    // put the leaving image back into queue if unused
    if (POOL_LEN.value > state.value.length && props.avoidDuplicates){
      const inUse = new Set(state.value.map(x=>pool.value[x.currIdx].key))
      const prevKey = pool.value[s.prevIdx].key
      if (!inUse.has(prevKey)){
        const prevIdx = s.prevIdx
        if (!rotationQueue.includes(prevIdx)) rotationQueue.push(prevIdx)
      }
    }
    s.prevIdx = null; t1.delete(i); t2.delete(i)
  }, props.fadeMs); t2.set(i, end)
}

/* ---------- tick: rotate mode OR swap mode ---------- */
function tick(){
  const n = state.value.length; if (!n || POOL_LEN.value < 1) return

  // IDs of cells we can touch now
  const free = []; for (let i=0;i<n;i++) if (!state.value[i].busy) free.push(i)
  if (!free.length) return

  // ROTATE mode: more images than cells
  if (POOL_LEN.value > n){
    const count = Math.min(props.batchSize, free.length)
    const picks = []; for (let k=0;k<count;k++){ const p = free.splice(randInt(free.length),1)[0]; picks.push(p) }

    const visibleKeys = new Set(state.value.map(s=>pool.value[s.currIdx].key))
    const reservedKeys = new Set()

    for (const i of picks){
      const currKey = pool.value[state.value[i].currIdx].key
      // also exclude row/near-row neighbors
      const neighborKeys = new Set(neighborIndices(i).map(j => pool.value[state.value[j].currIdx].key))
      const exclude = new Set([...visibleKeys, ...reservedKeys, currKey, ...neighborKeys])

      let chosen = null
      if (props.avoidDuplicates){
        if (!rotationQueue.length) refillQueueExcluding(exclude)
        chosen = takeFromQueue(exclude)
        if (chosen == null){ refillQueueExcluding(exclude); chosen = takeFromQueue(exclude) }
        if (chosen == null) continue
      } else {
        const choices=[]
        for (let idx=0; idx<POOL_LEN.value; idx++){
          const key = pool.value[idx].key
          if (exclude.has(key)) continue
          choices.push(idx)
        }
        if (!choices.length) continue
        chosen = choices[randInt(choices.length)]
      }
      reservedKeys.add(pool.value[chosen].key)
      animateTo(i, chosen)
    }
    return
  }

  // SWAP mode: pool size == number of cells (or fewer)
  // Build current key mapping
  const keyByIndex = {}; for (let i=0;i<n;i++) keyByIndex[i] = pool.value[state.value[i].currIdx].key

  // we can do up to floor(batchSize/1) swaps (each swap uses 2 cells)
  let attempts = 0, swapsDone = 0
  while (swapsDone < Math.min(props.batchSize, Math.floor(free.length/2)) && attempts < 20){
    attempts++
    // pick a first cell
    const i = free.splice(randInt(free.length), 1)[0]
    if (i == null) break
    // find a partner j among remaining that satisfies constraints after swap
    let partnerIndex = -1
    for (let t = 0; t < free.length; t++){
      const j = free[t]
      if (canSwap(i, j, keyByIndex)){ partnerIndex = t; break }
    }
    if (partnerIndex === -1){ // put back i and continue trying
      free.push(i); continue
    }
    const j = free.splice(partnerIndex, 1)[0]

    // commit swap in projection map (so additional swaps see updated placement)
    const keyI = keyByIndex[i], keyJ = keyByIndex[j]
    keyByIndex[i] = keyJ; keyByIndex[j] = keyI

    // animate both
    const idxI = state.value[i].currIdx
    const idxJ = state.value[j].currIdx
    animateTo(i, idxJ)
    animateTo(j, idxI)

    swapsDone++
  }
}

function startShuffler(){ stopShuffler(); timer = setInterval(tick, props.intervalMs) }
function stopShuffler(){
  if (timer){ clearInterval(timer); timer = null }
  t1.forEach(clearTimeout); t2.forEach(clearTimeout)
  t1.clear(); t2.clear()
}

watch([pool, gridToShow], () => { initState(); if (props.shuffle) startShuffler() }, { immediate:true })
onMounted(()=>{ if (props.shuffle) startShuffler() })
onBeforeUnmount(()=> stopShuffler())
</script>

<style scoped>
.hex-img { opacity: 1; transition: opacity var(--fade-ms) ease; pointer-events: none; }
.hex-img.hidden { opacity: 0; }
.hex-img.next { opacity: 0; }
.hex-img.next.visible { opacity: 1; }
.overlay { fill: #000; opacity: 0; transition: opacity var(--fade-ms) ease; }
.overlay.show { opacity: var(--overlay-opacity); }
</style>

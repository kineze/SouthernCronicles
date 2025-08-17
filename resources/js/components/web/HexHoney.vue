<!-- HexHoney.vue -->
<template>
  <svg
    :viewBox="`0 0 ${boxW} ${boxH}`"
    class="w-full -mt-[650px] lg:-mt-60 -mb-36 lg:mb-0 lg:h-[900px] h-[180vh]"
    role="img"
    aria-label="Speakers honeycomb"
  >
    <defs>
      <clipPath v-for="(g, i) in gridToShow" :key="i" :id="clipId(i)">
        <polygon :points="hexPointsPointy(g.x, g.y, R)" />
      </clipPath>
    </defs>

    <g v-for="(g, i) in gridToShow" :key="i">
      <g
        :clip-path="`url(#${clipId(i)})`"
        :style="{ '--fade-ms': fadeMs + 'ms', '--overlay-opacity': overlayOpacity }"
      >
        <!-- current -->
        <image
          v-if="state[i]"
          class="hex-img"
          :class="{ hidden: state[i].showNext }"
          :href="pool[state[i].currIdx].src"
          :x="g.x - R" :y="g.y - R"
          :width="2 * R" :height="2 * R"
          preserveAspectRatio="xMidYMid slice"
        />
        <!-- next -->
        <image
          v-if="state[i] && state[i].nextIdx !== null"
          class="hex-img next"
          :class="{ visible: state[i].showNext }"
          :href="pool[state[i].nextIdx].src"
          :x="g.x - R" :y="g.y - R"
          :width="2 * R" :height="2 * R"
          preserveAspectRatio="xMidYMid slice"
        />
        <!-- dark overlay -->
        <rect
          class="overlay"
          :class="{ show: state[i]?.overlay }"
          :x="g.x - R" :y="g.y - R"
          :width="2 * R" :height="2 * R"
        />
      </g>

      <!-- stroke on top -->
      <polygon
        :points="hexPointsPointy(g.x, g.y, R)"
        fill="none"
        :stroke="strokeColor"
        :stroke-width="strokeWidth"
        stroke-linejoin="round"
      />
    </g>
  </svg>
</template>

<script setup>
import { ref, computed, watch, onMounted, onBeforeUnmount } from 'vue'

/* ---- Props ---- */
const props = defineProps({
  images: { type: Array, required: true },

  radius: { type: Number, default: 100 },
  strokeColor: { type: String, default: '#ffffff' },
  strokeWidth: { type: Number, default: 2 },
  uid: { type: String, default: () => Math.random().toString(36).slice(2) },

  // animation
  shuffle: { type: Boolean, default: true },
  intervalMs: { type: Number, default: 2400 },
  fadeMs: { type: Number, default: 1200 },
  overlayOpacity: { type: Number, default: 0.45 },
  batchSize: { type: Number, default: 1 },

  // uniqueness
  avoidDuplicates: { type: Boolean, default: true },
  dedupeKey: { type: String, default: 'filename' }, // 'filename'|'path'|'exact'

  // responsive
  mobileBreakpoint: { type: Number, default: 768 }, // px
})

/* ---- Mobile detection FIRST (so geometry can read it) ---- */
const isMobile = ref(false)
let mql = null
let mqlHandler = null
onMounted(() => {
  if (typeof window !== 'undefined') {
    mql = window.matchMedia(`(max-width: ${props.mobileBreakpoint}px)`)
    mqlHandler = e => { isMobile.value = e.matches }
    isMobile.value = mql.matches
    if (mql.addEventListener) mql.addEventListener('change', mqlHandler)
    else mql.addListener(mqlHandler)
  }
})
onBeforeUnmount(() => {
  if (mql) {
    if (mql.removeEventListener) mql.removeEventListener('change', mqlHandler)
    else mql.removeListener(mqlHandler)
  }
})

/* ---- Geometry (pointy-top). Desktop vs Mobile switch ---- */
const R = props.radius

// your request: use these ONLY on mobile
//   HEX_W = 0.5 * R
//   HEX_H = sqrt(2) * R
//   STEP_X = sqrt(3) * R
//   STEP_Y = 1.5 * R
//   padX = 500, padY = 50
// keep your existing desktop values (HEX_W = 5*R, etc.)
const HEX_W = computed(() => isMobile.value ? 0.5 * R : 5 * R)
const HEX_H = computed(() => Math.sqrt(2) * R)                 // same both
const STEP_X = computed(() => Math.sqrt(3) * R)                // same both
const STEP_Y = computed(() => 1.5 * R)                         // same both
const padX   = computed(() => isMobile.value ? 500 : 0)
const padY   = computed(() => isMobile.value ? 20 : -100 )

// row counts (example; keep yours)
const rowsDesktop = [10, 9, 6, 7, 9, 10]         // <- your desktop config
const rowsMobile  = [2, 3, 2, 3, 2]                // <- your mobile config
const rows = computed(() => (isMobile.value ? rowsMobile : rowsDesktop))

const widest = computed(() => Math.max(...rows.value))
const widestRowWidth = computed(() => HEX_W.value + (widest.value - 2) * STEP_X.value)
const boxW = computed(() => padX.value * 0.4 + widestRowWidth.value)
const boxH = computed(() => padY.value * 0.5 + HEX_H.value + (rows.value.length - 6) * STEP_Y.value)

/** centers/grid */
const grid = computed(() => {
  const out = []
  rows.value.forEach((count, row) => {
    const y = padY.value + HEX_H.value / 3 + row * STEP_Y.value
    const rowWidth = HEX_W.value + (count - 1) * STEP_X.value
    const startX = (boxW.value - rowWidth) / 2 + HEX_W.value / 2
    for (let col = 0; col < count; col++) {
      out.push({ x: startX + col * STEP_X.value, y, row, col })
    }
  })
  return out
})

/* ---- Canonicalize + Dedupe ---- */
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
  return seg
    .replace(/\.[a-z0-9]+$/i,'')
    .replace(/-\d+x\d+$/,'')
    .replace(/@2x|@3x|_2x|_3x/gi,'')
    .replace(/\((\d+)\)$/,'')
    .replace(/[-_ ]copy(\s*\d+)?/i,'')
    .trim()
}

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

// only render as many hexes as unique images
const visibleCount = computed(() => Math.min(grid.value.length, POOL_LEN.value))
const gridToShow   = computed(() => grid.value.slice(0, visibleCount.value))

/* ---- Helpers ---- */
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
  for (const j of neighborIndices(index)){ if (keyByIndex[j] === key) return false }
  return true
}
function canSwap(i, j, keyByIndex){
  const keyI = keyByIndex[i], keyJ = keyByIndex[j]
  if (keyI === keyJ) return false
  return canPlaceKeyAtIndex(keyJ, i, { ...keyByIndex, [i]: keyJ, [j]: keyI }) &&
         canPlaceKeyAtIndex(keyI, j, { ...keyByIndex, [i]: keyJ, [j]: keyI })
}

/* ---- Rotation queue (when pool > visible) ---- */
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

/* ---- Animation state ---- */
const state = ref([]) // [{ currIdx, nextIdx, prevIdx, overlay, showNext, busy }]
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
    currIdx: initial[i] ?? 0,
    nextIdx: null,
    prevIdx: null,
    overlay: false,
    showNext: false,
    busy: false,
  }))
}

function animateTo(i, nextIdx){
  const s = state.value[i]; if (!s || s.busy) return
  s.busy = true; s.prevIdx = s.currIdx; s.nextIdx = nextIdx; s.overlay = true; s.showNext = false
  const half = Math.max(1, Math.floor(props.fadeMs/2))
  const mid = setTimeout(()=>{ s.showNext = true }, half); t1.set(i, mid)
  const end = setTimeout(()=>{
    s.currIdx = s.nextIdx; s.nextIdx = null; s.overlay = false; s.showNext = false; s.busy = false
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

/* ---- Tick: rotate (pool > visible) OR swap (pool == visible) ---- */
function tick(){
  const n = state.value.length; if (!n || POOL_LEN.value < 1) return
  const free = []; for (let i=0;i<n;i++) if (!state.value[i].busy) free.push(i)
  if (!free.length) return

  // ROTATE mode
  if (POOL_LEN.value > n){
    const count = Math.min(props.batchSize, free.length)
    const picks = []; for (let k=0;k<count;k++){ const p = free.splice(randInt(free.length),1)[0]; picks.push(p) }
    const visibleKeys = new Set(state.value.map(s=>pool.value[s.currIdx].key))
    const reservedKeys = new Set()

    for (const i of picks){
      const currKey = pool.value[state.value[i].currIdx].key
      const neighborKeys = new Set(neighborIndices(i).map(j => pool.value[state.value[j].currIdx].key))
      const exclude = new Set([...visibleKeys, ...reservedKeys, currKey, ...neighborKeys])

      let chosen = null
      if (props.avoidDuplicates){
        if (!rotationQueue.length) refillQueueExcluding(exclude)
        chosen = takeFromQueue(exclude)
        if (chosen == null){ refillQueueExcluding(exclude); chosen = takeFromQueue(exclude) }
        if (chosen == null) continue
      } else {
        const choices=[]; for (let idx=0; idx<POOL_LEN.value; idx++){ const key = pool.value[idx].key; if (!exclude.has(key)) choices.push(idx) }
        if (!choices.length) continue
        chosen = choices[randInt(choices.length)]
      }
      reservedKeys.add(pool.value[chosen].key)
      animateTo(i, chosen)
    }
    return
  }

  // SWAP mode (pool == visible)
  const keyByIndex = {}; for (let i=0;i<n;i++) keyByIndex[i] = pool.value[state.value[i].currIdx].key
  let attempts = 0, swapsDone = 0
  while (swapsDone < Math.min(props.batchSize, Math.floor(free.length/2)) && attempts < 20){
    attempts++
    const i = free.splice(randInt(free.length), 1)[0]
    if (i == null) break
    let partnerIndex = -1
    for (let t = 0; t < free.length; t++){
      const j = free[t]
      if (canSwap(i, j, keyByIndex)){ partnerIndex = t; break }
    }
    if (partnerIndex === -1){ free.push(i); continue }
    const j = free.splice(partnerIndex, 1)[0]

    const idxI = state.value[i].currIdx
    const idxJ = state.value[j].currIdx
    const keyI = keyByIndex[i], keyJ = keyByIndex[j]
    keyByIndex[i] = keyJ; keyByIndex[j] = keyI

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

<template>
  <svg
    :viewBox="`0 0 ${boxW} ${boxH}`"
    class="w-full h-auto block"
    role="img"
    aria-label="Speakers honeycomb"
    preserveAspectRatio="xMidYMid meet"
  >
    <defs>
      <clipPath v-for="(g, i) in gridToShow" :key="`clip-${i}`" :id="clipId(i)">
        <polygon :points="hexPointsPointy(g.x, g.y, R)" />
      </clipPath>
    </defs>

    <g v-for="(g, i) in gridToShow" :key="`hex-${i}`">
      <g
        :clip-path="`url(#${clipId(i)})`"
        :style="{ '--fade-ms': fadeMs + 'ms', '--overlay-opacity': overlayOpacity }"
      >
        <!-- current -->
        <image
          v-if="state[i]"
          class="hex-img"
          :class="{ hidden: state[i].showNext }"
          :href="pool[state[i].currIdx]?.src"
          :x="g.x - R" :y="g.y - R"
          :width="2 * R" :height="2 * R"
          preserveAspectRatio="xMidYMid slice"
        />
        <!-- next -->
        <image
          v-if="state[i] && state[i].nextIdx !== null"
          class="hex-img next"
          :class="{ visible: state[i].showNext }"
          :href="pool[state[i].nextIdx]?.src"
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

      <!-- stroke -->
      <polygon
        :points="hexPointsPointy(g.x, g.y, R)"
        fill="none"
        :stroke="strokeColor"
        :stroke-width="strokeWidth"
        stroke-linejoin="round"
      />

      <!-- hit-area for clicks -->
      <polygon
        v-if="interactive"
        class="hit"
        :points="hexPointsPointy(g.x, g.y, R)"
        @click="onHexClick(i)"
      />
    </g>
  </svg>
</template>

<script setup>
import { ref, computed, watch, onMounted, onBeforeUnmount } from 'vue'

const emit = defineEmits(['hex-click'])

/* ---- Props ---- */
const props = defineProps({
  images: { type: Array, required: true },

  // visuals
  radius: { type: Number, default: 100 },
  strokeColor: { type: String, default: '#ffffff' },
  strokeWidth: { type: Number, default: 2 },
  uid: { type: String, default: () => Math.random().toString(36).slice(2) },

  // animation
  shuffle: { type: Boolean, default: true },
  intervalMs: { type: Number, default: 2400 },
  fadeMs: { type: Number, default: 1200 },
  overlayOpacity: { type: Number, default: 0.45 },
  batchSize: { type: Number, default: 1 }, // respected

  // uniqueness
  avoidDuplicates: { type: Boolean, default: false },
  dedupeKey: { type: String, default: 'exact' }, // 'filename'|'path'|'exact'

  // responsive + layout
  mobileBreakpoint: { type: Number, default: 768 },
  rowsDesktop: { type: Array, default: () => [14, 13, 14, 13, 14, 13, 14, 13, 14, 13, 14, 13] },
  rowsMobile:  { type: Array, default: () => [3, 2, 3, 2, 3, 2, 3, 2] },
  pad: { type: Number, default: 12 },

  // interaction
  interactive: { type: Boolean, default: false }
})

/* ---- Responsive ---- */
const isMobile = ref(false)
let mql = null, mqlHandler = null
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
  if (!mql) return
  if (mql.removeEventListener) mql.removeEventListener('change', mqlHandler)
  else mql.removeListener(mqlHandler)
})

/* ---- Geometry ---- */
// const R = computed(() => props.radius)
// const STEP_X = computed(() => Math.sqrt(3) * R.value)
// const STEP_Y = computed(() => 1.5 * R.value)

const R = computed(() => props.radius)
const STEP_X = computed(() => Math.sqrt(3) * R.value)
const STEP_Y = computed(() => 1.5 * R.value)

const rows = computed(() => (isMobile.value ? props.rowsMobile : props.rowsDesktop))

const targetCount = computed(() => {
  const capacity = (rows.value || []).reduce((a, c) => a + (c || 0), 0)
  return Math.min((props.images?.length || 0), capacity)
})

const rowsUsed = computed(() => {
  const out = []
  let remaining = targetCount.value
  for (const cnt of rows.value) {
    if (remaining <= 0) break
    const take = Math.min(cnt, remaining)
    out.push(take)
    remaining -= take
  }
  return out
})



// const rows = computed(() => (isMobile.value ? props.rowsMobile : props.rowsDesktop))
const widestUsed = computed(() => Math.max(0, ...rowsUsed.value))
const innerW = computed(() => (Math.max(widestUsed.value - 1, 0)) * STEP_X.value + 2 * R.value)
const innerH = computed(() => (Math.max(rowsUsed.value.length - 1, 0)) * STEP_Y.value + 2 * R.value)
const boxW = computed(() => innerW.value + 2 * props.pad)
const boxH = computed(() => innerH.value + 2 * props.pad)

const grid = computed(() => {
  const out = []
  let placed = 0

  rowsUsed.value.forEach((count, rowIdx) => {
    const y = props.pad + R.value + rowIdx * STEP_Y.value
    const rowW = Math.max(count - 1, 0) * STEP_X.value + 2 * R.value
    const startX = props.pad + (boxW.value - 2 * props.pad - rowW) / 2 + R.value

    for (let col = 0; col < count; col++) {
      if (placed >= targetCount.value) break
      out.push({ x: startX + col * STEP_X.value, y, row: rowIdx, col })
      placed++
    }
  })
  return out
})

/* ---- Pool + Dedupe ---- */
function canonicalKey(url, mode = 'exact') {
  let original = String(url || '').trim()
  if (!original) return ''
  if (mode === 'exact') return original.toLowerCase()

  let path = original
  try { if (path.startsWith('http')) path = new URL(path).pathname } catch {}
  path = path.split('#')[0].split('?')[0]
  try { path = decodeURIComponent(path) } catch {}
  path = path.toLowerCase()

  if (mode === 'path') return path
  if (mode === 'filename') {
    const seg = path.split('/').filter(Boolean).pop() || path
    return seg
      .replace(/\.[a-z0-9]+$/i,'')
      .replace(/-\d+x\d+$/,'')
      .replace(/@2x|@3x|_2x|_3x/gi,'')
      .replace(/\((\d+)\)$/,'')
      .replace(/[-_ ]copy(\s*\d+)?/i,'')
      .trim()
  }
  return original.toLowerCase()
}

const pool = computed(() => {
  const seen = new Set(), out = []
  for (const src of props.images || []) {
    const key = canonicalKey(src, props.dedupeKey)
    if (props.avoidDuplicates && seen.has(key)) continue
    seen.add(key); out.push({ src, key })
    if (out.length >= targetCount.value) break
  }
  return out
})
const POOL_LEN = computed(() => pool.value.length)
const visibleCount = computed(() => Math.min(grid.value.length, POOL_LEN.value))
const gridToShow = computed(() => grid.value.slice(0, visibleCount.value))

/* ===========================================================
   🔀 Shuffle logic (rotation-queue + adjacency constraints)
   =========================================================== */
function hexPointsPointy(cx, cy, r) {
  const pts = []
  for (let i = 0; i < 6; i++) {
    const ang = ((60 * i - 30) * Math.PI) / 180
    pts.push(`${cx + r * Math.cos(ang)},${cy + r * Math.sin(ang)}`)
  }
  return pts.join(' ')
}
function clipId(i) { return `hexclip-${props.uid}-${i}` }
function randInt(max){ return Math.floor(Math.random() * max) }
function shuffleInPlace(a){
  for (let i = a.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [a[i], a[j]] = [a[j], a[i]];
  }
  return a
}

/* adjacency helpers for no-adjacent-duplicate keys */
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

/* ---- State + Animation ---- */
const state = ref([]) // [{ currIdx, nextIdx, prevIdx, overlay, showNext, busy }]
let timer = null
const t1 = new Map(), t2 = new Map()

function initState(){
  const n = visibleCount.value
  if (n === 0) { state.value = []; return }
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
  if (nextIdx == null || !pool.value[nextIdx]) return
  s.busy = true; s.prevIdx = s.currIdx; s.nextIdx = nextIdx; s.overlay = true; s.showNext = false
  const half = Math.max(1, Math.floor(props.fadeMs/2))
  const mid = setTimeout(()=>{ s.showNext = true }, half); t1.set(i, mid)
  const end = setTimeout(()=>{
    s.currIdx = s.nextIdx; s.nextIdx = null; s.overlay = false; s.showNext = false; s.busy = false
    if (POOL_LEN.value > state.value.length && props.avoidDuplicates){
      const inUse = new Set(state.value.map(x=>pool.value[x.currIdx].key))
      const prevKey = pool.value[s.prevIdx]?.key
      if (prevKey && !inUse.has(prevKey)){
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
    const picks = []; for (let k=0;k<count;k++){ const p = free.splice(Math.floor(Math.random()*free.length),1)[0]; picks.push(p) }
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
        chosen = choices[Math.floor(Math.random()*choices.length)]
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
    const i = free.splice(Math.floor(Math.random()*free.length), 1)[0]
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

function startShuffler(){ stopShuffler(); if (props.shuffle) timer = setInterval(tick, props.intervalMs) }
function stopShuffler(){
  if (timer){ clearInterval(timer); timer = null }
  t1.forEach(clearTimeout); t2.forEach(clearTimeout)
  t1.clear(); t2.clear()
}

watch([pool, gridToShow], () => { initState(); startShuffler() }, { immediate:true })
watch(() => [props.shuffle, props.intervalMs, props.batchSize, props.fadeMs], () => { startShuffler() })
onMounted(()=> startShuffler())
onBeforeUnmount(()=> stopShuffler())

/* ---- Click ---- */
function onHexClick(i) {
  const s = state.value[i]
  if (!s) return
  const curr = pool.value[s.currIdx]
  emit('hex-click', { index: i, poolIndex: s.currIdx, src: curr?.src })
}
</script>

<style scoped>
.hex-img { opacity: 1; transition: opacity var(--fade-ms) ease; pointer-events: none; }
.hex-img.hidden { opacity: 0; }
.hex-img.next { opacity: 0; }
.hex-img.next.visible { opacity: 1; }

.overlay { fill: #000; opacity: 0; transition: opacity var(--fade-ms) ease; }
.overlay.show { opacity: var(--overlay-opacity); }

.hit { fill: transparent; cursor: pointer; }
</style>

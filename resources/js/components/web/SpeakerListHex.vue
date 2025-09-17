<template>
  <div class="w-full" ref="root">
    <div
      class="grid"
      :style="isHorizontal
        ? { display: 'grid', gridTemplateColumns: '1fr', gridTemplateRows: `repeat(${tracksCount}, auto)`, gap: gap + 'px' }
        : { display: 'grid', gridTemplateColumns: `repeat(${tracksCount}, minmax(0, 1fr))`, gap: gap + 'px' }"
    >
      <!-- One track per grid row (horizontal) or per column (vertical) -->
      <div
        v-for="(track, tIdx) in tracksFilled"
        :key="'track-' + tIdx"
        class="relative overflow-hidden group"
        :style="{ height: isHorizontal ? cardHeight + 'px' : containerHeight + 'px' }"
      >
        <!-- Scroller: two stacks for seamless loop -->
        <div
          :class="isHorizontal ? 'marquee-stack-h' : 'marquee-stack-v'"
          :style="{
            animationDuration: durations[tIdx] + 's',
            '--gap': gap + 'px'
          }"
          :data-dir="tIdx % 2 === 0 ? 'forward' : 'reverse'"
        >
          <!-- stack #1 -->
          <div class="stack" :style="{ flexDirection: isHorizontal ? 'row' : 'column' }">
            <SpeakerCard
              v-for="(sp, i) in track"
              :key="'s1-' + tIdx + '-' + i + '-' + sp.id"
              :speaker="sp"
              :card-height="cardHeight"
              :is-horizontal="isHorizontal"
              :card-width="cardWidth"
              :border-radius-x="200"
              :border-radius-y="100"
              @click="emitClick(sp)"
            />
          </div>
          <!-- stack #2 (rotated clone) -->
          <div class="stack" :style="{ flexDirection: isHorizontal ? 'row' : 'column' }">
            <SpeakerCard
              v-for="(sp, i) in rotatedTracksFilled[tIdx]"
              :key="'s2-' + tIdx + '-' + i + '-' + sp.id"
              :speaker="sp"
              :card-height="cardHeight"
              :is-horizontal="isHorizontal"
              :card-width="cardWidth"
              :border-radius-x="200"
              :border-radius-y="100"
              @click="emitClick(sp)"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import {
  computed,
  onMounted,
  onBeforeUnmount,
  ref,
  watch,
  defineComponent,
  h,
  nextTick
} from 'vue'

/**
 * Props:
 *  - speakers: [{ id, name, image, ... }]
 *  - direction: 'horizontal' | 'vertical'  (default: 'horizontal')
 *  - columnsDesktop / columnsMobile: used for vertical mode (columns) OR horizontal mode (rows)
 *  - gap: px gap between items and tracks
 *  - cardHeight: card height (px)
 *  - cardWidth:  card width in horizontal mode (px)
 *  - durationMin / durationMax: seconds; per-track randomized duration
 *  - mobileBreakpoint: responsive switch
 */
const props = defineProps({
  speakers: { type: Array, default: () => [] },
  direction: { type: String, default: 'horizontal' },
  columnsDesktop: { type: Number, default: 6 },
  columnsMobile: { type: Number, default: 2 },
  gap: { type: Number, default: 16 },
  cardHeight: { type: Number, default: 420 },
  cardWidth: { type: Number, default: 260 },
  durationMin: { type: Number, default: 18 },
  durationMax: { type: Number, default: 28 },
  mobileBreakpoint: { type: Number, default: 1024 },
})

const emit = defineEmits(['item-click'])
const isHorizontal = computed(() => props.direction === 'horizontal')

/* responsive */
const isMobile = ref(false)
let mql
const onMatch = e => { isMobile.value = e.matches }

onMounted(() => {
  if (typeof window !== 'undefined') {
    mql = window.matchMedia(`(max-width:${props.mobileBreakpoint}px)`)
    isMobile.value = mql.matches
    if (mql.addEventListener) mql.addEventListener('change', onMatch)
    else mql.addListener(onMatch)
  }
})
onBeforeUnmount(() => {
  if (!mql) return
  if (mql.removeEventListener) mql.removeEventListener('change', onMatch)
  else mql.removeListener(onMatch)
})

/* tracks: number of rows (horizontal) or columns (vertical) */
const tracksCount = computed(() =>
  isMobile.value ? props.columnsMobile : props.columnsDesktop
)

/* base distribution (round-robin) */
const tracksBase = computed(() => {
  const list = Array.from({ length: tracksCount.value }, () => [])
  if (!props.speakers?.length) return list
  let i = 0
  for (const sp of props.speakers) {
    list[i % tracksCount.value].push(sp)
    i++
  }
  return list
})

/* measure lane width so a single stack covers > lane (prevents gaps) */
const root = ref(null)
const laneWidth = ref(0)
let resizeObs
function measure() {
  if (!root.value) return
  laneWidth.value = root.value.clientWidth || 0
}
onMounted(async () => {
  await nextTick()
  measure()
  if ('ResizeObserver' in window) {
    resizeObs = new ResizeObserver(() => measure())
    resizeObs.observe(root.value)
  } else {
    window.addEventListener('resize', measure)
  }
})
onBeforeUnmount(() => {
  if (resizeObs) resizeObs.disconnect()
  else window.removeEventListener('resize', measure)
})

/* ensure each stack is wide enough for seamless loop */
const minPerStack = computed(() => {
  if (!isHorizontal.value) return 3 // vertical not used here but keep fallback
  if (!laneWidth.value) return 6
  const w = props.cardWidth + props.gap
  return Math.max(3, Math.ceil(laneWidth.value / w) + 1)
})

/* fill and normalize tracks */
function fillTrack(base, need) {
  if (!base.length) return []
  const out = []
  while (out.length < need) out.push(...base)
  return out.slice(0, need)
}
const tracksFilled = computed(() => {
  if (!isHorizontal.value) return tracksBase.value // vertical path (not used here)
  return tracksBase.value.map((base) => fillTrack(base, minPerStack.value))
})

/* rotated copy for stack #2 to avoid "same card touching" at the seam */
const rotatedTracksFilled = computed(() =>
  tracksFilled.value.map(arr => (arr.length > 1 ? [...arr.slice(1), arr[0]] : [...arr]))
)

/* sizing */
const gap = computed(() => props.gap)
const cardHeight = computed(() => props.cardHeight)
const cardWidth = computed(() => props.cardWidth)
const containerHeight = computed(
  () => Math.round(props.cardHeight * 2.2 + props.gap * 2)
)

/* animation durations per track (randomized) */
const durations = ref([])
function randomDurations() {
  const out = []
  for (let i = 0; i < tracksCount.value; i++) {
    const d = props.durationMin + Math.random() * (props.durationMax - props.durationMin)
    out.push(Number(d.toFixed(2)))
  }
  durations.value = out
}
watch([tracksCount, () => props.speakers?.length, laneWidth], randomDurations, { immediate: true })

function emitClick(sp) {
  emit('item-click', sp)
}

/* ---- Local subcomponent: pill-shaped image card (render function) ---- */
const SpeakerCard = defineComponent({
  name: 'SpeakerCard',
  props: {
    speaker: { type: Object, required: true },
    isHorizontal: { type: Boolean, default: true },
    cardHeight: { type: Number, default: 200 },
    cardWidth: { type: Number, default: 260 },
    borderRadiusX: { type: Number, default: 200 },
    borderRadiusY: { type: Number, default: 100 },
  },
  emits: ['click'],
  setup(cardProps, { emit }) {
    const onClick = () => emit('click', cardProps.speaker)
    return () =>
      h(
        'div',
        {
          class:
            'relative overflow-hidden bg-white shadow-md flex justify-center items-center cursor-pointer',
          style: {
            height: `${cardProps.cardHeight}px`,
            width: cardProps.isHorizontal ? `${cardProps.cardWidth}px` : '100%',
            borderRadius: `${cardProps.borderRadiusX}px ${cardProps.borderRadiusX}px ${cardProps.borderRadiusX}px ${cardProps.borderRadiusX}px / ${cardProps.borderRadiusY}px ${cardProps.borderRadiusY}px ${cardProps.borderRadiusY}px ${cardProps.borderRadiusY}px`,
            /* fallback spacing for browsers without flex-gap */
            marginRight: 'var(--gap, 16px)'
          },
          title: 'View speaker',
          onClick,
        },
        [
          h('img', {
            src: `/storage/${cardProps.speaker.image}`,
            alt: cardProps.speaker.name,
            class: 'w-full h-full object-cover',
            loading: 'lazy',
          }),
        ]
      )
  },
})
</script>

<style scoped>
/* pause animation when hovering the track */
.group:hover .marquee-stack-h,
.group:hover .marquee-stack-v {
  animation-play-state: paused;
}

/* stacks are flex containers; direction set inline */
.stack {
  display: flex;
  gap: var(--gap, 8px); /* primary spacing */
}
.stack > *:last-child {
  margin-right: 0;        /* gap fallback cleanup */
}

/* ===== Horizontal marquee (left/right) ===== */
.marquee-stack-h {
  display: flex;
  flex-direction: row;
  width: max-content;           /* ensure wrapper width equals content width */
  animation-timing-function: linear;
  animation-iteration-count: infinite;
  will-change: transform;
}
.marquee-stack-h[data-dir="forward"] { animation-name: marquee-left; }
.marquee-stack-h[data-dir="reverse"] { animation-name: marquee-right; }

/* Duplicate two equal stacks; move by 50% width to loop seamlessly */
@keyframes marquee-left {
  from { transform: translateX(0); }
  to   { transform: translateX(-50%); }
}
@keyframes marquee-right {
  from { transform: translateX(-50%); }
  to   { transform: translateX(0); }
}

/* ===== Vertical marquee (kept for completeness) ===== */
.marquee-stack-v {
  display: flex;
  flex-direction: column;
  width: max-content;
  animation-timing-function: linear;
  animation-iteration-count: infinite;
  will-change: transform;
}
.marquee-stack-v[data-dir="forward"] { animation-name: marquee-up; }
.marquee-stack-v[data-dir="reverse"] { animation-name: marquee-down; }

@keyframes marquee-up {
  from { transform: translateY(0); }
  to   { transform: translateY(-50%); }
}
@keyframes marquee-down {
  from { transform: translateY(-50%); }
  to   { transform: translateY(0); }
}
</style>

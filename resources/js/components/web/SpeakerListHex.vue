<template>
  <div class="w-full">
    <div
      class="grid"
      :style="{
        display: 'grid',
        gridTemplateColumns: `repeat(${columnsCount}, minmax(0, 1fr))`,
        gap: gap + 'px'
      }"
    >
      <!-- One column per grid track -->
      <div
        v-for="(col, cIdx) in columns"
        :key="'col-' + cIdx"
        class="relative overflow-hidden group"
        :style="{ height: containerHeight + 'px' }"
      >
        <!-- Scroller: two stacks for seamless loop -->
        <div
          class="marquee-stack"
          :class="cIdx % 2 === 0 ? 'dir-up' : 'dir-down'"
          :style="{ animationDuration: durations[cIdx] + 's' }"
        >
          <!-- stack #1 -->
          <div class="stack" :style="{ gap: gap + 'px' }">
            <SpeakerCard
              v-for="(sp, i) in col"
              :key="'c1-' + cIdx + '-' + i"
              :speaker="sp"
              :card-height="cardHeight"
              :border-radius-x="200"
              :border-radius-y="100"
              @click="emitClick(sp)"
            />
          </div>
          <!-- stack #2 (clone) -->
          <div class="stack" :style="{ gap: gap + 'px' }">
            <SpeakerCard
              v-for="(sp, i) in col"
              :key="'c2-' + cIdx + '-' + i"
              :speaker="sp"
              :card-height="cardHeight"
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
  h
} from 'vue'

/**
 * Props:
 *  - speakers: [{ id, name, image, ... }]
 *  - columnsDesktop / columnsMobile: numbers
 *  - gap: px gap between items and columns
 *  - cardHeight: fixed card height for consistent marquee
 *  - durationMin / durationMax: seconds; each column gets a random duration in this range
 *  - mobileBreakpoint: for responsive column count
 */
const props = defineProps({
  speakers: { type: Array, default: () => [] },
  columnsDesktop: { type: Number, default: 6 },
  columnsMobile: { type: Number, default: 2 },
  gap: { type: Number, default: 16 },
  cardHeight: { type: Number, default: 420 },
  durationMin: { type: Number, default: 18 },
  durationMax: { type: Number, default: 28 },
  mobileBreakpoint: { type: Number, default: 1024 },
})

const emit = defineEmits(['item-click'])

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

const columnsCount = computed(() =>
  isMobile.value ? props.columnsMobile : props.columnsDesktop
)

/* distribute speakers into columns (balanced) */
const columns = computed(() => {
  const cols = Array.from({ length: columnsCount.value }, () => [])
  if (!props.speakers?.length) return cols
  let i = 0
  for (const sp of props.speakers) {
    cols[i % columnsCount.value].push(sp)
    i++
  }
  // ensure each column has at least 3 for a smoother loop
  for (let c = 0; c < cols.length; c++) {
    while (cols[c].length > 0 && cols[c].length < 3) {
      cols[c].push(cols[c][cols[c].length - 1])
    }
  }
  return cols
})

/* container height = ~2.2 cards tall for nice overlap feel */
const gap = computed(() => props.gap)
const cardHeight = computed(() => props.cardHeight)
const containerHeight = computed(
  () => Math.round(props.cardHeight * 2.2 + props.gap * 2)
)

/* animation durations per column (randomized in range) */
const durations = ref([])
function randomDurations() {
  const out = []
  for (let i = 0; i < columnsCount.value; i++) {
    const d = props.durationMin + Math.random() * (props.durationMax - props.durationMin)
    out.push(Number(d.toFixed(2)))
  }
  durations.value = out
}
watch([columnsCount, () => props.speakers?.length], randomDurations, { immediate: true })

function emitClick(sp) {
  emit('item-click', sp)
}

/* ---- Local subcomponent: pill-shaped image card (render function) ---- */
const SpeakerCard = defineComponent({
  name: 'SpeakerCard',
  props: {
    speaker: { type: Object, required: true },
    cardHeight: { type: Number, default: 420 },
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
            borderRadius: `${cardProps.borderRadiusX}px ${cardProps.borderRadiusX}px ${cardProps.borderRadiusX}px ${cardProps.borderRadiusX}px / ${cardProps.borderRadiusY}px ${cardProps.borderRadiusY}px ${cardProps.borderRadiusY}px ${cardProps.borderRadiusY}px`,
            marginBottom: '16px',
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
/* two stacks inside to create a seamless loop */
.marquee-stack {
  display: flex;
  flex-direction: column;
  animation-timing-function: linear;
  animation-iteration-count: infinite;
  will-change: transform;
}

/* pause animation when hovering the column (wrapper has .group) */
.group:hover .marquee-stack {
  animation-play-state: paused;
}

/* each stack is a vertical list with gap set inline via :style */
.stack {
  display: flex;
  flex-direction: column;
}

/* animate half distance because there are two equal stacks */
.marquee-stack.dir-up { animation-name: marquee-up; }
.marquee-stack.dir-down { animation-name: marquee-down; }

@keyframes marquee-up {
  from { transform: translateY(0); }
  to   { transform: translateY(-50%); }
}
@keyframes marquee-down {
  from { transform: translateY(-50%); }
  to   { transform: translateY(0); }
}
</style>

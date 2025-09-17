<template>
  <svg
    xmlns="http://www.w3.org/2000/svg"
    :width="size"
    :height="size"
    viewBox="0 0 100 100"
    fill="none"
  >
    <path
      :stroke="color"
      stroke-width="2"
      stroke-linecap="round"
      d="M37 7c3 2 11 11 11 18s-4 15-4 15a20 20 0 0 0 11 14l-6 11c-11 5-25 10-38 12c-5 2-8-3-8-3s4-16 11-23c7-7 13-13 13-20S29 11 29 11M33 3c4 1 11 8 11 14s-3 12-3 12a17 17 0 0 0 10 12l-6 10c-9 4-22 9-34 11c-4 1-7-2-7-2s3-14 9-20c6-6 12-11 12-17S27 8 27 8M30 1a32 32 0 0 1 13 6c2 4 4 10 4 15s-2 13-2 13a15 15 0 0 0 9 10L42 50c-8 3-20 7-31 9c-4 1-6-2-6-2s3-12 8-18c5-6 11-10 11-16S24 6 24 6"
    />
    <path
      :stroke="color"
      stroke-width="2"
      stroke-linecap="round"
      d="M48 23c-1 4-10 13-10 20s5 15 5 15a15 15 0 0 0 8 10l-4 8c-7 3-17 7-26 9c-3 1-5-1-5-1s2-8 7-13c5-5 9-9 9-14S39 27 39 27"
    />
    <path
      :stroke="color"
      stroke-width="2"
      stroke-linecap="round"
      d="M58 8c-2 2-11 10-11 18s4 15 4 15a18 18 0 0 0 11 14l-6 11c-11 5-25 10-38 12c-5 2-8-3-8-3s4-16 11-23c7-7 13-13 13-20S50 11 50 11"
    />
    <path
      :stroke="color"
      stroke-width="2"
      stroke-linecap="round"
      d="M49 14a12 12 0 1 0 0 12a12 12 0 1 0 0-12z"
    />
    <path
      :stroke="color"
      stroke-width="2"
      stroke-linecap="round"
      d="M65 80c-2 2-4 5-4 8s2 6 2 6a7 7 0 0 0 2 3l-1 2c-2 1-5 2-8 2c-1 0-2-1-2-1s1-3 2-4c1-1 2-2 2-3S62 82 62 82M67 85c-2 2-4 5-4 8s2 6 2 6a7 7 0 0 0 2 3l-1 2c-2 1-5 2-8 2c-1 0-2-1-2-1s1-3 2-4c1-1 2-2 2-3S64 87 64 87"
    />
  </svg>
</template>

<script>
export default {
  props: {
    color: {
      type: String,
      default: '#224870', // Default dark blue color
    },
    size: {
      type: [Number, String],
      default: 100, // Default size in pixels
    },
  },
};
</script>
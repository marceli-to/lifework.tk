<template>
  <svg
    xmlns="http://www.w3.org/2000/svg"
    width="16"
    height="16"
    viewBox="0 0 24 24"
    fill="none"
    stroke="currentColor"
    stroke-width="1.75"
    stroke-linecap="round"
    stroke-linejoin="round"
    aria-hidden="true"
  >
    <path v-for="(d, index) in paths[name]" :key="index" :d="d" />
  </svg>
</template>
<script>

// Lucide icons (ISC license), inlined: no Vue 2 icon set has headings/superscript
const paths = {
  undo: ['M9 14 4 9l5-5', 'M4 9h10.5a5.5 5.5 0 0 1 5.5 5.5a5.5 5.5 0 0 1-5.5 5.5H11'],
  redo: ['m15 14 5-5-5-5', 'M20 9H9.5A5.5 5.5 0 0 0 4 14.5A5.5 5.5 0 0 0 9.5 20H13'],
  h1: ['M4 12h8', 'M4 18V6', 'M12 18V6', 'm17 12 3-2v8'],
  h2: ['M4 12h8', 'M4 18V6', 'M12 18V6', 'M21 18h-4c0-4 4-3 4-6 0-1.5-2-2.5-4-1'],
  h3: ['M4 12h8', 'M4 18V6', 'M12 18V6', 'M17.5 10.5c1.7-1 3.5 0 3.5 1.5a2 2 0 0 1-2 2', 'M17 17.5c2 1.5 4 .3 4-1.5a2 2 0 0 0-2-2'],
  bold: ['M6 12h9a4 4 0 0 1 0 8H7a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h7a4 4 0 0 1 0 8'],
  list: ['M3 12h.01', 'M3 18h.01', 'M3 6h.01', 'M8 12h13', 'M8 18h13', 'M8 6h13'],
  superscript: ['m4 19 8-8', 'm12 19-8-8', 'M20 12h-4c0-1.5.442-2 1.5-2.5S20 8.334 20 7.002c0-.472-.17-.93-.484-1.29a2.105 2.105 0 0 0-2.617-.436c-.42.239-.738.614-.899 1.06'],
  nowrap: ['M2 12h6', 'M22 12h-6', 'M12 2v2', 'M12 8v2', 'M12 14v2', 'M12 20v2', 'm19 9-3 3 3 3', 'm5 15 3-3-3-3'],
  link: ['M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71', 'M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71'],
  eraser: ['M4 7V4h16v3', 'M5 20h6', 'M13 4 8 20', 'm15 15 5 5', 'm20 15-5 5'],
};

export default {
  props: {
    name: { type: String, required: true },
  },

  data() {
    return { paths };
  },
};
</script>

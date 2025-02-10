<script setup>
import { computed } from 'vue';

const props = defineProps({
  text: {
    type: String,
    required: true
  },
  x: {
    type: Number,
    default: null
  },
  y: {
    type: Number,
    default: null
  }
});

const tooltipStyle = computed(() => {
  if (props.x !== null && props.y !== null) {
    return {
      left: `${props.x + 100}px`,
      top: `${props.y - 350}px`,
      transform: 'translate(-50%, -100%)',
      pointerEvents: 'none'
    };
  } else {
    return {
      left: '0px',
      top: '0px',
      transform: 'translate(0, -100%)',
      pointerEvents: 'none'
    };
  }
});
</script>

<template>
  <div 
    class="absolute z-[9999] bg-gray-900 text-white p-2 rounded shadow-lg max-w-xs text-sm"
    :style="tooltipStyle"
  >
    {{ text }}
  </div>
</template>
<style scoped>
.tooltip-arrow {
  position: absolute;
  bottom: -6px;
  left: 50%;
  transform: translateX(-50%);
  border-left: 6px solid transparent;
  border-right: 6px solid transparent;
  border-top: 6px solid #111827;
}
</style>
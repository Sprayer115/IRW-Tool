<template>
    <!-- The span’s background is set via inline style if highlightColor is set -->
    <span :style="{ backgroundColor: highlightColor }">
      {{ value }}
    </span>
  </template>
  
  <script>
  export default {
    name: "AnimatedNumber",
    props: {
      value: {
        type: [Number, String],
        required: true
      },
      // A number passed from the parent that changes whenever highlights should be cleared
      clearTrigger: {
        type: Number,
        default: 0
      }
    },
    data() {
      return {
        // If null, no highlight is visible. Otherwise it holds a CSS color.
        highlightColor: null,
        // This counter is used to select the next color in the array.
        colorCounter: 0,
        // Define a list of colors. Each change will pick the next color.
        colors: ["yellow", "lightblue", "pink", "lightgreen", "orange"]
      };
    },
    watch: {
      // Whenever the passed-in value changes…
      value(newVal, oldVal) {
        if (newVal !== oldVal) {
          // …set the highlight color from the list.
          this.highlightColor = this.colors[this.colorCounter];
          // Move to the next color (wrap around when the end is reached).
          this.colorCounter = (this.colorCounter + 1) % this.colors.length;
        }
      },
      // When the clearTrigger prop changes, remove the highlight.
      clearTrigger(newVal, oldVal) {
        this.highlightColor = null;
      }
    }
  };
  </script>
  
  <style scoped>
  /* No extra CSS needed since we use inline styles for backgroundColor */
  </style>
  
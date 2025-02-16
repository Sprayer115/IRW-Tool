<template>
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
        highlightColor: null,
        colorCounter: 0,
        colors: ["yellow", "lightblue", "pink", "lightgreen", "orange", "aqua", "Aquamarine", "DarkSeaGreen"]
      };
    },
    watch: {
      // Whenever the passed-in value changes…
      value(newVal, oldVal) {
        if (newVal !== oldVal) {
          this.highlightColor = this.colors[this.colorCounter];
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
  
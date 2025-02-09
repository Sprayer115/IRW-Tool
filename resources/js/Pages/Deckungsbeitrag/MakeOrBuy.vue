<!-- Deckungsbeitrag/MakeOrBuy.vue -->
<template>
    <div class="page">
      MakeOrBuy
      TODO: Hier nur Rechner?
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        pageData: ''
      }
    },
    methods: {
      updateData() {
        this.$emit('update:modelValue', this.pageData)
      }
    }
  }
  </script>
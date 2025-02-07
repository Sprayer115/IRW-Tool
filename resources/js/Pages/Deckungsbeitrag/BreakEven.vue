<!-- Deckungsbeitrag/BreakEven.vue -->
<template>
    <div class="page">
      <input :model="pageData" @input="updateData">
      BreakEven
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
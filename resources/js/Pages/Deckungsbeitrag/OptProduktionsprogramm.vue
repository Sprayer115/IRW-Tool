<!-- Deckungsbeitrag/OptProduktionsprogramm.vue -->
<template>
    <div class="page">
      <input :model="pageData" @input="updateData">
      Optimales Produktionsprogramm
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
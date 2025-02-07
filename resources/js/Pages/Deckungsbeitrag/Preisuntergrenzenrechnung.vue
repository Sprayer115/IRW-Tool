<!-- Deckungsbeitrag/Preisuntergrenzenrechnung.vue -->
<template>
    <div class="page">
      <input :model="pageData" @input="updateData">
      Preisuntergrenzenrechnung
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
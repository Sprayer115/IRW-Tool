<!-- Deckungsbeitrag/MakeOrBuy.vue -->
<template>
    <div class="page">
      <input :model="pageData" @input="updateData">
      MakeOrBuy
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
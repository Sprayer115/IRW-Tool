<!-- Kostenarten/3.vue -->
<template>
    <div class="page">
      <input v-model="pageData" @input="updateData">
      3
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
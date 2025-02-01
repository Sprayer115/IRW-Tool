<!-- Kostenarten/1.vue -->
<template>
    <div class="page">
      <input v-model="pageData" @input="updateData">
      1
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
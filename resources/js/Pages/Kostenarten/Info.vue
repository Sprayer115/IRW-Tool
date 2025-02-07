<!-- Kostenarten/Info.vue -->
<template>
    <div class="page">
      <input :model="pageData" @input="updateData">
      Info
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
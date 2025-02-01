<!-- Finanzbuchhaltung/1.vue -->
<template>
    <div >
      <input class="" v-model="pageData" @input="updateData">
      <h2 class="text-2xl font-bold mb-4">Page 1</h2>
        <!-- Your page content here -->
        <p>This is the content of page 1</p>
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
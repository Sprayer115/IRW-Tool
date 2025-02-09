<!-- Kostentraeger/3.vue -->
<template>
    <div class="page">
      <img src='/images/Maschinenstundensatz2.png'/>
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
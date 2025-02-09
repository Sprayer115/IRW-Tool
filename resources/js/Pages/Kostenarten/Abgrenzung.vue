<!-- Kostenarten/Abgrenzung.vue -->
<template>
    <div class="page">
      Abgrenzung
      TODO, soll hier einfach der Rechner hin?
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
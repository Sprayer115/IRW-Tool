<template>
  <div class="maschinenlaufzeit-container">
    <!-- Rote Überschrift -->
    <h2  class="red-title"><strong> Musterbeispiel Erklärung und Rechnung 3/3</strong></h2> <br>

    <div class="tabelle-overflow">
      <img src='/images/Prozesskostenrechnung5.png' style="min-width: 1200px;"/></div>
      <br>
      <br>

      <br>

      <div class="tabelle-overflow">
      <img src='/images/Prozesskostenrechnung6.png' style="min-width: 1200px;"/></div>
      <div class="tabelle-overflow">
        <img src='/images/Prozesskostenrechnung7.png' style="min-width: 700px;"/></div>
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
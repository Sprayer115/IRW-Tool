<!-- Kostenstellen/1.vue -->
<template>
    <div class="page">
      Die Kostenartenrechnung ist der erste Schritt der Kostenrechnung. Sie erfasst alle im Unternehmen anfallenden Kosten systematisch und gliedert sie nach ihrer Art. Ziel ist es, einen Überblick zu schaffen, welche Kosten entstanden sind und wofür sie angefallen sind.
    </div>
    <br>
    <br>
    <div>
      <img src='/images/Kostenarten1.png' />
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
    <style scoped>
    .finanzbuchhaltung {
      max-width: 600px;
      margin: 0 auto;
      font-family: sans-serif;
    }
    
    h1, h2, h3 {
      margin-bottom: 0.5rem;
      font-weight: bold;
    }
    
    /* Hier werden Aufzählungspunkte aktiviert bzw. sichtbar gemacht */
    ul {
      list-style: disc;
      margin-left: 1.5rem; 
    }
    
    .ergebnis p {
      font-weight: bold;
    }
    </style>
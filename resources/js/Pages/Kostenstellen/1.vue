<!-- Kostenstellen/1.vue -->
<template>
  <div class="page">
    <h1 class="title">Definition der Kostenstellenrechnung</h1> <br>
    "Die Kostenstellenrechnung ist der zweite Schritt der Kostenrechnung. Sie verteilt die Gemeinkosten aus der Kostenartenrechnung auf die Bereiche des Unternehmens (Kostenstellen), die diese Kosten verursacht haben. Ziel ist es, die Gemeinkosten verursachungsgerecht den Kostenstellen zuzuordnen und eine Basis für die spätere Verrechnung auf Kostenträger zu schaffen."  </div>
  <br>
  <br>
  <div>
    <img src='/images/Kostenstellen1.png' />
  </div>
</template>

<script>
export default {
  props: {
    preAuxiliaryCostCenters: {
      type: Array,
      default: () => []
    },
    primaryOverheadCosts: {
      type: Array,
      default: () => []
    },
    allocationMatrix: {
      type: Object,
      default: () => {}
    }
  },
  emits: ['calculate'],
  data() {
    return {
      pageData: ''
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
<template>
    <div class="py-12 bg-white dark:bg-white">
    <div class="zuschlagssatzberechnung-container">  
      <!-- Überschrift -->
      <h1 class="title">Kostenträgerrechnung – Zuschlagssatzberechnung</h1>
  
      <!-- Einleitender Text -->
      <p>
        Die Zuschlagssätze dienen dazu, die Gemeinkosten aus Verwaltung und
        Vertrieb anteilig auf die Kostenträger umzulegen:
      </p>
  
      

      <img src='/images/Zuschlag1.png' />
    </div>
    </div>
  </template>
  
  <script>
  export default {
    name: "ZuschlagssatzBerechnung"
  };
  </script>
  
  <style scoped>
  .title {
  font-size: 1.4rem;
}
  .zuschlagssatzberechnung-container {
    max-width: 700px;
    margin: 1rem auto;
    font-family: sans-serif;
    line-height: 1.4;
  }
  
  h1 {
    margin-bottom: 1rem;
    font-size: 1.2rem;
  }
  
  /* Formel-Block-Stil */
  .formula-block {
    margin-top: 0.5rem;
    margin-bottom: 1rem;
  }
  
  .formula {
    margin-left: 1.5rem;
    font-style: italic;
  }
  
  /* Für einen einfachen Bruch-Look */
  .fraction {
    display: inline-block;
    text-align: center;
    line-height: 1.2;
  }
  
  .numerator {
    display: block;
  }
  
  .separator {
    display: block;
    border-bottom: 1px solid #000;
    margin: -2px 0; /* Etwas vertikales Tuning */
  }
  
  .denominator {
    display: block;
    margin-top: -2px; /* Minimale Korrektur */
  }
  </style>
  
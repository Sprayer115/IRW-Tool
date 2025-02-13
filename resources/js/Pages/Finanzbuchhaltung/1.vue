<!-- Finanzbuchhaltung/1.vue -->
<template>
        <div class="py-12 bg-white dark:bg-white p-4">

        <!-- Your page content here -->
        <p>"Die Finanzbuchhaltung erfasst alle Aufwendungen und Erträge eines Unternehmens und bildet die Grundlage für die Kostenrechnung. Sie dokumentiert alle Geschäftsvorfälle und dient der Erstellung von Jahresabschlüssen (Bilanz und Gewinn- und Verlustrechnung)."</p>
        <br>

          <p>Einfaches Beispiel für die Finanzbuchhaltung: Ein Unternehmen erfasst die Kosten und Einnahmen einer Periode:</p><br>
            <div class="aufwendungen">
      <h3>1. Aufwendungen</h3>
      <ul>
        <li>Materialkosten: 5.000 €</li>
        <li>Mietkosten: 2.000 €</li>
        <li>Personalkosten: 3.000 €</li>
        <li>Sonstige Kosten: 500 €</li>
      </ul>
      <br>
    </div>

    <!-- Erträge -->
    <div class="ertraege">
      <h3>2. Erträge</h3>
      <ul>
        <li>Produktverkäufe: 12.000 €</li>
      </ul>
    </div>

    <!-- Ergebnis -->
    <div class="ergebnis">
      <br>
      <h3>Ergebnis:</h3>
      <p>
        Gewinn = 12.000 €−(5.000 €+2.000 €+3.000 €+500 €)=1.500 €Gewinn
      </p>
    </div>
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
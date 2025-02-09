<!-- Kostenstellen/2.vue -->
<!-- Finanzbuchhaltung/1.vue -->
<template>
  <div >
      <!-- Your page content here -->
          <div class="aufwendungen">
    <h3>Typische Kostenarten:</h3>
    <ul>
      <li>Personalkosten: Löhne, Gehälter, Sozialabgaben</li>
      <li>Materialkosten: Rohstoffe, Hilfsstoffe</li>
      <li>Mietkosten: Miete für Gebäude</li>
      <li>Abschreibungen: Maschinen, Fahrzeuge</li>
      <li>IT-Kosten: Software-Lizenzen, Wartung</li>
    </ul>
    <br>
  </div>

  <!-- Erträge -->
  <div class="ertraege">
    <h3>Zeitliche und sachliche Abgrenzung:</h3>
    <ul>
      <li>Zeitliche Abgrenzung: Kosten werden dem Zeitraum zugeordnet, in dem sie angefallen sind.Beispiel: Eine Miete von 20.000 € wird für 3 Monate gezahlt, aber nur 6.667 € gehören in den aktuellen Monat.</li>
      <li>Sachliche Abgrenzung: Unterscheidet zwischen Aufwendungen und Kosten.Beispiel: Kalkulatorische Abschreibungen (Anderskosten) oder kalkulatorischer Unternehmerlohn (Zusatzkosten).</li>
    </ul>
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
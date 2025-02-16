<template>
  <div class="maschinenlaufzeit-container">
    <!-- Rote Überschrift -->
    <h2  class="red-title"><strong> Musterbeispiel Erklärung und Rechnung 2/3</strong></h2> <br>

    <div class="tabelle-overflow">
      <img src='/images/Prozesskostenrechnung4.png' style="min-width: 700px;"/></div>
      <br>
      <br>

      <br>

      <div class="tabelle-overflow">
      <img src='/images/Prozesskostenrechnung5.png' style="min-width: 1200px;"/></div>
  </div>
</template>

<script>
export default {
  name: "MaschinenstundensatzBerechnung"
};
</script>

<style scoped>
.maschinenstundensatz-container {
  max-width: 700px;
  margin: 1rem auto;
  font-family: sans-serif;
  line-height: 1.4;
}

/* Rote Überschriften */
.red-heading {
  color: red;
  margin: 1.5rem 0 1rem;
  font-size: 1.1rem;
}

/* Block für Formel-Darstellung */
.formula-block {
  margin-left: 1rem;
  margin-bottom: 1rem;
}
.formula-title {
  font-weight: bold;
  display: inline-block;
  margin-bottom: 0.25rem;
}
.formula {
  margin-left: 1rem;
  font-style: italic;
}

/* Beispiel-Zeilen */
.example-heading {
  color: red;
  font-weight: bold;
  margin-bottom: 0.25rem;
}
.example-result {
  margin-left: 1rem;
  font-weight: 600;
}
</style>

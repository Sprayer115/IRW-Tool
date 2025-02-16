<template>
  <div class="maschinenlaufzeit-container">
    <!-- Rote Überschrift -->
    <h2  class="red-title"><strong> Musterbeispiel Erklärung und Rechnung 1/3</strong></h2> <br>

    <div class="tabelle-overflow">
      <img src='/images/Prozesskostenrechnung2.png' style="min-width: 1200px;"/></div>
      <br>
      <br>

      <br>

      <div class="tabelle-overflow">
      <img src='/images/Prozesskostenrechnung3.png' style="min-width: 700px;"/></div>
  </div>
</template>

<script>
export default {
  name: "MaschinenlaufzeitBerechnung"
};
</script>

<style>
.tabelle-overflow{
  overflow: auto;
}
.maschinenlaufzeit-container {
  max-width: 800px;
  margin: 1rem auto;
  font-family: sans-serif;
  line-height: 1.5;
}

/* Rote Überschrift */
.red-title {
  color: red;
  font-size: 1.2rem;
}

/* Diagrammzeile */
.diagram-row {
  display: flex;
  align-items: center;
  justify-content: flex-start;
  gap: 1rem;
  margin-top: 1rem;
  margin-bottom: 2rem;
}

/* Graue Kreise */
.circle {
  width: 80px;
  height: 80px;
  background-color: #ccc;
  border-radius: 50%;
  font-size: 0.9rem;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-align: center;
}

/* Zwischen-Elemente ( = oder – ) */
.diagram-equal,
.diagram-minus {
  font-size: 2rem;
  font-weight: bold;
}

/* Beispielrechnung */
.calculation p {
  margin: 0.5rem 0;
}
.calculation .result {
  margin-top: 0.5rem;
  font-weight: bold;
}
</style>

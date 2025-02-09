<template>
  <div class="maschinenlaufzeit-container">
    <!-- Rote Überschrift -->
    <h2  class="red-title"><strong> Berechnung der Maschinenlaufzeit </strong></h2>

    <!-- Diagramm: 4 graue Kreise in einer Zeile -->
    <div class="diagram-row">
      <div class="circle">Nutzungs-<br />zeit</div>
      <div class="diagram-equal">
        =
      </div>
      <div class="circle">Maschinen-<br />zeit</div>
      <div class="diagram-minus">
        –
      </div>
      <div class="circle">Instand-<br />haltungs-<br />zeit</div>
      <div class="diagram-minus">
        –
      </div>
      <div class="circle">Ruhezeit</div>
    </div>

    <!-- Beispielberechnung -->
    <div class="calculation">
      <p>
        <strong>Nutzungszeit im Beispiel</strong> = Maschinenzeit (220 * 8h = 1.760)
      </p>
      <p>
        ./. Ruhe und Instandhaltung (25% von 1.760h)
      </p>
      <p class="result">= 1.320 h p.a.</p>
    </div>
  </div>
</template>

<script>
export default {
  name: "MaschinenlaufzeitBerechnung"
};
</script>

<style scoped>
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

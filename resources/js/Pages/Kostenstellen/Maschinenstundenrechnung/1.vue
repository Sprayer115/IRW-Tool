<template>
  <div class="maschinenstundensatz-page">
    <!-- Hauptüberschrift -->
    <h1>Erweiterung der Kostenstellenrechnung – Maschinenstundensatzrechnung</h1>

    <!-- Einleitender Text -->
    <p class="intro-text">
      Die <strong>Maschinenstundensatzrechnung</strong> kommt <strong>direkt nach
      der Kostenstellenrechnung</strong> und bildet eine Brücke zur
      <strong>Kostenträgerrechnung</strong>, indem sie die Maschinenkosten
      verursachungsgerecht pro Maschinenstunde verteilt. Dadurch werden die
      Produktionskosten präziser auf die Kostenträger (Produkte) umgelegt.
    </p>

    <img src='/images/Maschinenstundensatz1.png'/>
  </div>
</template>

<script>
export default {
  name: "MaschinenstundensatzErweiterung"
};
</script>

<style scoped>
.maschinenstundensatz-page {
  max-width: 900px;
  margin: 1rem auto;
  font-family: sans-serif;
  line-height: 1.5;
}

/* Einleitender Text, etwas größerer Abstand */
.intro-text {
  margin-bottom: 1.5rem;
}

/* Diagramm-Zeilen */
.diagram-row {
  display: flex;
  align-items: center;
  gap: 1rem;
  margin-bottom: 2rem;
  flex-wrap: wrap; /* Damit es bei schmalen Bildschirmen umbricht */
}

/* Beispiel: Obere Diagrammreihe leicht kleiner als die untere */
.top-diagram .circle {
  width: 90px;
  height: 90px;
}
.bottom-diagram .circle {
  width: 80px;
  height: 80px;
}

/* Kreise */
.circle {
  background-color: #ccc;
  border-radius: 50%;
  text-align: center;
  font-size: 0.9rem;
  padding: 0.5rem;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

/* Zeichen zwischen den Kreisen */
.diagram-plus,
.diagram-equal,
.diagram-arrow {
  font-size: 1.5rem;
  font-weight: bold;
  flex-shrink: 0;
}

/* Blaues Rechteck für Maschinenstundensatz */
.stundensatz-box {
  background-color: #cce0ff;
  padding: 1rem;
  text-align: center;
  margin-bottom: 2rem;
  border-radius: 4px;
  max-width: 420px;
}

/* Horizontales Liniensymbol für Bruchdarstellung */
.fraction-divider {
  display: inline-block;
  font-size: 0.75rem;
  text-decoration: underline;
  line-height: 1;
}

/* Gleichheitszeichen größer darstellen */
.equals {
  font-size: 1.3rem;
}
</style>

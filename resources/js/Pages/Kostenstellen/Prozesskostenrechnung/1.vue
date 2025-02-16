<template>
  <div class="prozesskostenrechnung-page">
    <!-- Hauptüberschrift -->
    <h1>Erweiterung der Kostenstellenrechnung – Prozesskostenrechnung</h1>

    <br>
    <!-- Einleitender Text -->
    <p class="intro-text">
      Die <strong>Prozesskostenrechnung</strong> im internen Rechnungswesen erfasst nicht nur systematisch die anfallenden Gemeinkosten, sondern 
      verteilt sie auch verursachungsgerecht auf einzelne Geschäftsprozesse. <br>Es wird ein Verständnis der <strong>Kostenstrukturen</strong> geschaffen, 
      insbesondere werden so die <strong>Kostentreiber</strong> sichtbar, was es dem Management ermöglicht, gezielt Abläufe zu optimieren und 
      strategische Entscheidungen zu treffen. <br>Diese Methode trägt dazu bei, ineffiziente Prozesse zu identifizieren und die Wirtschaftlichkeit 
      des Unternehmens nachhaltig zu verbessern.
    </p>

    <div>
      <span class="tooltip-container">
            <sup class="info-button">i</sup>
            <span class="tooltip-text">Mit Hilfe der Prozesskostenrechnung <br>soll eine Verbesserung des Kostenmanagements <br>in folgenden Bereichen erreicht werden:<br>
              •	Kostentransparenz <br>
              •	Personalkostenmanagement <br>
              •	Verhaltensbeeinflussung <br>
              •	Kostenbewusste Entwicklung <br>
              •	Benchmarking <br>
            </span>
      </span>
    </div>
    <br>

    <div class="tabelle-overflow">
      <img src='/images/Prozesskostenrechnung1.png' style="min-width: 400px;"/></div>

      <div class="button-group">
      <button @click="downloadScript" class="btnShowScript clear-button ml-2">Skript</button>
    </div>
  </div>
</template>

<script>
export default {
  name: "MaschinenstundensatzErweiterung",
  methods: {
    downloadScript() {
      const link = document.createElement('a');
      link.href = '/storage/Prozesskostenrechnung.pdf';
      link.setAttribute('download', 'Prozesskostenrechnung.pdf');
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    }
  }
};
</script>

<style>
.prozesskostenrechnung-page {
  max-width: 900px;
  margin: 1rem auto;
  font-family: sans-serif;
  line-height: 1.5;
}

.tabelle-overflow{
  overflow: auto;
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

/* Style for the Skript button, angelehnt an 2.vue */
.btnShowScript {
  background-color: #475569; /* bg-slate-600 */
  border-radius: 12px;
  padding: 14px 28px;
  font-weight: 500;
  color: rgb(226, 232, 240);
  /* Damit der Button in der Flex-Box mit dem Clear-Button mitskalieren kann */
  border: none;
  cursor: pointer;
}

/* Container für die beiden Buttons */
.button-group {
  display: table;
  gap: 350px;
  margin-bottom: 1rem;
}

/* Style for the clear button */
.clear-button {
  background-color: #475569; /* bg-slate-600 */
  border-radius: 12px;
  padding: 14px 28px;
  font-weight: 500;
  color: rgb(226, 232, 240);
  /* Damit der Button in der Flex-Box mit dem Clear-Button mitskalieren kann */
  border: none;
  cursor: pointer;
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

/* Optional: Hover-Effekt */
.info-button:hover {
  opacity: 0.85;
}
.tooltip-container:hover .tooltip-text {
    visibility: visible;
    opacity: 1;
    transition-delay: 0.1s; /* Delay before showing the tooltip */
    overflow: visible;
    left: 2rem;
    display: table;
}
.tooltip-container {
    position: relative;
    display: block;
    cursor: pointer;
    top: 50%;
    right: -1rem;  /*Falls du mehr Platz willst, anpassen */
   transform: translateY(-50%);
   width: fit-content;
}
.tooltip-text {
    visibility: hidden;
    background-color: black;
    color: #fff;
    text-align: left;
    /*border-radius: 5px;*/
    padding: 5px;
    position: absolute;
    z-index: 1;
    bottom: 150%;  /*Adjust to position above the element */
    width: fit-content;
    overflow: auto;
}
.table-scroller{
  overflow: scroll;
}
.info-button {
  position: absolute;
  top: 0;
  right: 0;
  transform: translate(50%, -50%);
  width: 28px;
  height: 28px;
  background-color: #000;
  color: #fff;
  font-weight: bold;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
}
</style>

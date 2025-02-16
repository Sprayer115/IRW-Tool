<template>
  <div class="stufenleiter-container">
    <!-- Infobutton rechts oben -->

    <h1 class="title">Kostenstellenrechnung – innerbetriebliche Leistungsverrechnung</h1>
    <br>
    <h2><strong> A) Stufenleiterverfahren </strong></h2>

    <!-- Manuelle Numerierung für Haupt- und Unterpunkte -->
    <ol class="custom-list">
      <li>
        <strong>1. Verwaltung wird zuerst verteilt:</strong>
        <ol class="sub-list">
          <li>1.&nbsp;Verwaltung → Produktion: 76.200 × 0,6 = 45.720</li>
          <li>2.&nbsp;Verwaltung → Vertrieb: 76.200 × 0,4 = 30.480</li>
        </ol>
      </li>
      <li>
        <strong>2. Produktion wird auf Vertrieb verteilt:</strong>
        <ol class="sub-list">
          <li>1.&nbsp;Produktion → Vertrieb: (193.500 + 45.720) × 0,3 = 71.664</li>
        </ol>
      </li>
    </ol>

    <!-- Verrechnungsschlüssel rechts -->
    <div class="verrechnungsschluessel">
      <h3>Verrechnungsschlüssel für die innerbetriebliche Leistungsverrechnung:</h3>
      <ul>
        <li>• Verwaltung → Produktion: 60 %</li>
        <li>• Verwaltung → Vertrieb: 40 %</li>
        <li>• Produktion → Vertrieb: 30 %</li>
      </ul>
    </div>

    <!-- Beispielhafte Tabelle -->
    <h3><strong>Gesamtkosten nach Stufenleiterverfahren:</strong></h3>
    <div class="table-scroller">
    <table class="kosten-tabelle">
      <thead>
        <tr>
          <th>Kostenstelle</th>
          <th>Primäre (€)</th>
          <th>Zugerechnet (€)</th>
          <th>Gesamtkosten (€)</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Verwaltung</td>
          <td>76.200</td>
          <td>–</td>
          <td>76.200</td>
        </tr>
        <tr>
          <td>Produktion</td>
          <td>193.500</td>
          <td>45.720</td>
          <td>239.220</td>
        </tr>
        <tr>
          <td>Vertrieb</td>
          <td>48.000</td>
          <td>30.480 + 71.664</td>
          <td>150.144</td>
        </tr>
      </tbody>
    </table>
  </div>
    <div>
      <span id="tooltip-aufwand" class="tooltip-container">
            <sup class="info-button">i</sup>
            <span class="tooltip-text">Die innerbetriebliche Leistungsverrechnung dient dazu, Kosten, die <br>durch die Nutzung von <br>Leistungen innerhalb des Unternehmens entstehen, korrekt zuzuordnen.<br> Es gibt verschiedene Verfahren dafür:<br><br>
   1.	Stufenleiterverfahren: <br>Kosten werden schrittweise auf <br>die nachfolgenden Kostenstellen verteilt.<br> Vorherige Kostenstellen werden dabei nicht erneut berücksichtigt.<br><br>
   2.	Anbauverfahren: <br>Verteilt nur auf die Endkostenstellen, ohne gegenseitige <br>Verrechnung zwischen den Hauptkostenstellen.<br><br>
   3.	Gleichungsverfahren: <br>Nutzt ein mathematisches System von Gleichungen, um <br>alle innerbetrieblichen Leistungen vollständig zu berücksichtigen.<br><br>
Jedes Verfahren hat unterschiedliche <br>Genauigkeitsgrade und Anforderungen in der Anwendung.

            </span>
      </span>
    </div>
  </div>
</template>

<script>
export default {
  name: "StufenleiterVerfahren",
  methods: {
    onInfoClick() {
      alert("Hier könntest du eine Erläuterung oder ein Tooltip anzeigen.");
    }
  }
};
</script>

<style scoped>
.title {
  font-size: 1.4rem;
}
.stufenleiter-container {
  position: relative; /* Für den Info-Button */
  max-width: 900px;
  margin: 1rem auto;
  font-family: sans-serif;
}

/* Infobutton rechts oben */
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

/* Manuelles Listen-Layout */
.custom-list {
  list-style: none;   /* Verhindert Standard-Nummerierung (1., 2. usw.) */
  padding-left: 0;    /* Entfernt linken Einzug */
  margin-bottom: 1rem;
}

.custom-list > li {
  margin: 0.5rem 0;
}

.sub-list {
  list-style: none;   /* Keine eigene Buchstaben/Aufzählung */
  padding-left: 1.5rem;
  margin-top: 0.25rem;
}

/* Verrechnungsschlüssel rechts kannst du per float oder flex layouten,
   hier belassen wir es einfach unterhalb der Liste. */
.verrechnungsschluessel {
  margin: 1rem 0;
}

.kosten-tabelle {
  width: 100%;
  border-collapse: collapse;
  margin-top: 0.5rem;
  text-align: left;
}

.kosten-tabelle th,
.kosten-tabelle td {
  padding: 8px 12px;
  border: 1px solid #ccc;
}

.kosten-tabelle thead tr {
  background-color: #f5f5f5;
}

.kosten-tabelle th {
  font-weight: 600;
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
    left: -20rem;
    display: table;
}
.tooltip-container {
    position: absolute;
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
    bottom: 50%;  /*Adjust to position above the element */
    width: fit-content;
    top: -15rem;
}
.table-scroller{
  overflow: auto;
}
</style>

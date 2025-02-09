<template>
  <div class="stufenleiter-container">
    <!-- Infobutton rechts oben -->
    <div class="info-button" @click="onInfoClick" title="Mehr Informationen">
      i
    </div>

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

.info-button:hover {
  opacity: 0.8;
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
</style>

<template>
  <div class="anbauverfahren-container">
    <h1 class="title">Kostenstellenrechnung – innerbetriebliche Leistungsverrechnung</h1>

    <h2><strong> B) Anbauverfahren </strong></h2>
    <br>
    <p>
      • Verwaltung und Produktion verteilen nur auf die nachgelagerten
      Kostenstellen, ohne gegenseitige Verrechnung.
    </p>

    <ol class="custom-list">
      <li>
        <strong>1. Verwaltung:</strong>
        <ol class="sub-list">
          <li>
            1.&nbsp;Verwaltung → Produktion: 76.200 × 0,6 = 45.720
          </li>
          <li>
            2.&nbsp;Verwaltung → Vertrieb: 76.200 × 0,4 = 30.480
          </li>
        </ol>
      </li>
      <li>
        <strong>2. Produktion:</strong>
        <ol class="sub-list">
          <li>
            1.&nbsp;Produktion → Vertrieb: 193.500 × 0,3 = 58.050
          </li>
        </ol>
      </li>
    </ol>

    <h3><strong> Gesamtkosten nach Anbauverfahren:</strong></h3>
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
          <td>30.480 + 58.050</td>
          <td>136.530</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: "AnbauverfahrenExample"
};
</script>

<style scoped>
.title {
  font-size: 1.4rem;
}
.anbauverfahren-container {
  max-width: 800px;
  margin: 1rem auto;
  font-family: sans-serif;
}

h1 {
  margin-bottom: 1rem;
}

.custom-list {
  list-style: none;  /* Keine automatische Nummerierung */
  padding-left: 0;
  margin: 1rem 0;
}
.custom-list > li {
  margin-bottom: 0.5rem;
}
.sub-list {
  list-style: none;  /* Unterpunkte manuell nummerieren */
  padding-left: 1.5rem;
}

/* Tabelle */
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

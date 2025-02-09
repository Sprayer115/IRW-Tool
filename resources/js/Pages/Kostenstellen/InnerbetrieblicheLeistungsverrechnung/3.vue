<template>
  <div class="gleichungsverfahren-container">
    <h1 class="title">Kostenstellenrechnung – innerbetriebliche Leistungsverrechnung</h1>
    <br>
    <h2><strong>C) Gleichungsverfahren </strong></h2>
    <br>
    <p>Verrechnung der Kosten wird durch Gleichungen vollständig berücksichtigt.</p>

    <ol class="custom-list">
      <li>
        <strong>1. Gleichungen aufstellen:</strong>
        <ol class="sub-list">
          <li>
            1.&nbsp;Verwaltung:
            V = 76.200 + 0,6P + 0,4V<br />
          </li>
          <li>
            2.&nbsp;Produktion:
            P = 193.500 + 0,3P + 0,6V<br />
          </li>
          <li>
            3.&nbsp;Vertrieb:
            Vertrieb = 48.000 + 0,4V + 0,3P
          </li>
        </ol>
      </li>
      <li>
        <strong>2. Gleichungen lösen:</strong>
        <ol class="sub-list">
          <li>1.&nbsp;Verwaltung (VV): 127.000</li>
          <li>2.&nbsp;Produktion (PP): 230.000</li>
          <li>3.&nbsp;Vertrieb (Vertrieb): 152.000</li>
        </ol>
      </li>
    </ol>

    <h3>Gesamtkosten nach Gleichungsverfahren:</h3>
    <table class="kosten-tabelle">
      <thead>
        <tr>
          <th>Kostenstelle</th>
          <th>Primäre (€)</th>
          <th>Gesamtkosten (€)</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Verwaltung</td>
          <td>76.200</td>
          <td>127.000</td>
        </tr>
        <tr>
          <td>Produktion</td>
          <td>193.500</td>
          <td>230.000</td>
        </tr>
        <tr>
          <td>Vertrieb</td>
          <td>48.000</td>
          <td>152.000</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: "GleichungsverfahrenExample"
};
</script>

<style scoped>
.title {
  font-size: 1.4rem;
}
.gleichungsverfahren-container {
  max-width: 800px;
  margin: 1rem auto;
  font-family: sans-serif;
}

/* Listen formatieren */
.custom-list {
  list-style: none;   /* Keine Standardnummerierung */
  padding-left: 0;
  margin-bottom: 1rem;
}
.custom-list > li {
  margin: 0.5rem 0;
}
.sub-list {
  list-style: none;   /* Auch bei den Unterlisten manuell nummeriert */
  padding-left: 1.5rem;
  margin-top: 0.25rem;
}

/* Tabelle */
.kosten-tabelle {
  width: 100%;
  border-collapse: collapse;
  margin-top: 0.75rem;
  text-align: left;
}
.kosten-tabelle th,
.kosten-tabelle td {
  border: 1px solid #ccc;
  padding: 8px 12px;
}
.kosten-tabelle thead tr {
  background-color: #f5f5f5;
}
.kosten-tabelle th {
  font-weight: 600;
}
</style>

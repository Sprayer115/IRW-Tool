<template>
  <div class="db4-page">
    <!-- Titel -->
    <h1 class="title">Deckungsbeitrag (mehrstufig) – <br>Deckungsbeitrag IV (Gewinn nach Unternehmensfixkosten)</h1>
    <br>
    <!-- Einleitender Text -->
    <p>
      Nach Abzug der Unternehmensfixkosten ergibt sich der endgültige Gewinn oder
      Verlust pro Produkt
    </p>

    <!-- Roter Hinweis "Formel:" -->
    <p class="red-hint">Formel:</p>

    <!-- Formel-Beispiel -->
    <img src='/images/DBmehr2.png' />

    <!-- Erste (kleine) Tabelle: DB III, Unternehmensfixkosten -->
    <table class="mini-scheme">
      <thead>
        <tr>
          <th></th>
          <th>Produkt A</th>
          <th>Produkt B</th>
          <th>Gesamt</th>
        </tr>
      </thead>
      <tbody>
        <!-- DB III (grau) -->
        <tr class="gray-row top-border bottom-border">
          <td>DB III</td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <!-- Unternehmensfixkosten (weiß) -->
        <tr class="bottom-border">
          <td>Unternehmensfixkosten</td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      </tbody>
    </table>

    <!-- Zweite (große) Tabelle mit DB III, Unternehmensfixkosten, DB IV -->
    <table class="db4-tabelle">
      <thead>
        <tr>
          <th>Produkt</th>
          <th>DB III (€)</th>
          <th>Unternehmensfixkosten (€)</th>
          <th>DB IV (€)</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Produkt A</td>
          <td>9.832,5</td>
          <td>31.571</td>
          <td>-21.738,5</td>
        </tr>
        <tr>
          <td>Produkt B</td>
          <td>5.867,5</td>
          <td>18.429</td>
          <td>-12.561,5</td>
        </tr>
        <tr class="total-row">
          <td>Gesamt</td>
          <td>15.700</td>
          <td>50.000</td>
          <td>-34.300</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: "DeckungsbeitragMehrstufigDBIV"
};
</script>

<style scoped>
.title {
  font-size: 1.4rem;
}
.db4-page {
  max-width: 900px;
  margin: 1rem auto;
  font-family: sans-serif;
  line-height: 1.4;
}

h1 {
  margin-bottom: 1rem;
}

/* Roter Text-Hinweis */
.red-hint {
  color: red;
  font-weight: bold;
  margin: 1rem 0 0.5rem;
}

/* Formel */
.formula-block {
  margin: 1rem 0;
}
.formula {
  font-size: 1.1rem;
  line-height: 1.6;
}
/* Kleine Hilfs-Klasse für den Bruch (DB III/Gesamt-DB III) */
.fraction {
  display: inline-block;
  text-align: center;
  vertical-align: middle;
  margin-left: 0.5rem;
}
.numerator,
.denominator {
  display: block;
}
.sep {
  display: block;
  border-bottom: 1px solid #000;
}

/* ===== Erste Tabelle (Mini-Scheme) ===== */
.mini-scheme {
  border-collapse: collapse;
  width: 100%;
  text-align: left;
  margin: 2rem 0;
}
.mini-scheme thead tr th {
  border-bottom: 2px solid #000;
  padding: 4px 8px;
}
.gray-row {
  background-color: #ccc;
}
.top-border {
  border-top: 2px solid #000;
}
.bottom-border {
  border-bottom: 2px solid #000;
}
.mini-scheme td {
  padding: 8px;
}

/* ===== Zweite Tabelle (Ergebnisse) ===== */
.db4-tabelle {
  width: 100%;
  border-collapse: collapse;
  text-align: left;
  margin-bottom: 2rem;
}
.db4-tabelle th,
.db4-tabelle td {
  border: 1px solid #ccc;
  padding: 8px 12px;
}
.db4-tabelle thead tr {
  background-color: #f5f5f5;
}
.total-row td {
  font-weight: bold;
}
</style>

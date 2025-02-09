<template>
  <div class="db3-page">
    <!-- Titel -->
    <h1 class="title">Deckungsbeitrag (mehrstufig) – <br>Deckungsbeitrag III (nach Bereichsfixkosten)</h1>
    <br>
    <!-- Einleitender Text -->
    <p>
      DB III berücksichtigt die Fixkosten, die einem <strong>Bereich</strong>
      (z. B. Verwaltung oder Vertrieb) zuzuordnen sind.
    </p>

    <!-- Roter Hinweis für Formelbeispiel -->
    <p class="red-hint">
      Formelbeispiel für Verwaltungskostenanteil je Produkt:
    </p>

    <!-- Formel-Beispiel -->
    <img src='/images/DBmehr1.png' />

    <!-- Flex-Layout: links Mini-Tabelle, rechts Ergebnis-Tabelle -->
    <div class="layout-row">
      <!-- Linke Mini-Tabelle -->
      <div class="mini-table-section">
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
            <!-- DB II (grau) -->
            <tr class="gray-row top-border bottom-border">
              <td>DB II</td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <!-- Verwaltungskosten (weiß) -->
            <tr class="bottom-border">
              <td>Verwaltungskosten</td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <!-- Vertriebskosten (grau) -->
            <tr class="gray-row bottom-border">
              <td>Vertriebskosten</td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Rechte Ergebnis-Tabelle -->
      <div class="summary-section">
        <table class="db3-tabelle">
          <thead>
            <tr>
              <th>Produkt</th>
              <th>DB II (€)</th>
              <th>Verwaltung (€)</th>
              <th>Vertrieb (€)</th>
              <th>DB III (€)</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Produkt A</td>
              <td>186.076,5</td>
              <td>80.257</td>
              <td>95.987</td>
              <td>9.832,5</td>
            </tr>
            <tr>
              <td>Produkt B</td>
              <td>108.623,5</td>
              <td>46.743</td>
              <td>56.013</td>
              <td>5.867,5</td>
            </tr>
            <tr class="total-row">
              <td>Gesamt</td>
              <td>294.700</td>
              <td>127.000</td>
              <td>152.000</td>
              <td>15.700</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "DeckungsbeitragMehrstufigDBIII"
};
</script>

<style scoped>
.title {
  font-size: 1.4rem;
}
.db3-page {
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

/* Zwei-Spalten-Layout */
.layout-row {
  display: flex;
  gap: 2rem;
  margin-top: 2rem;
}
.mini-table-section {
  flex: 0.6;
}
.summary-section {
  flex: 1;
}

/* ===== Mini-Scheme links ===== */
.mini-scheme {
  border-collapse: collapse;
  width: 100%;
  text-align: left;
  margin-bottom: 1rem;
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

/* ===== Tabelle DB III rechts ===== */
.db3-tabelle {
  width: 100%;
  border-collapse: collapse;
  text-align: left;
}
.db3-tabelle th,
.db3-tabelle td {
  border: 1px solid #ccc;
  padding: 8px 12px;
}
.db3-tabelle thead tr {
  background-color: #f5f5f5;
}
.total-row td {
  font-weight: bold;
}
</style>

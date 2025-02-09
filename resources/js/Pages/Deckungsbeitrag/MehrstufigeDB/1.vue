<template>
  <div class="db2-page">
    <!-- Titel -->
    <h1 class="title">Deckungsbeitrag (mehrstufig) – <br>Deckungsbeitrag II (nach Produktfixkosten)</h1>
    <br>
    <!-- Einleitender Text -->
    <p>
      DB II zeigt, wie viel nach Abzug der <strong>produktbezogenen Fixkosten</strong>
      (z. B. Maschinenkosten, produktbezogene Werbung) übrig bleibt.
    </p>

    <!-- Formel -->
    <div class="formula-block">
      <p class="formula">
        <strong>DB II = DB I – Produktfixkosten</strong>
      </p>
    </div>

    <!-- Flex-Layout: links die kleine Skizzen-Tabelle, rechts die Zusammenfassung -->
    <div class="layout-row">
      <!-- Mini-Tabelle (linke Seite) -->
      <div class="mini-table-section">
        <table class="mini-scheme">
          <thead>
            <tr>
              <th></th>
              <th>Produkt A</th>
              <th>Produkt B</th>
            </tr>
          </thead>
          <tbody>
            <!-- DB I (grau) -->
            <tr class="gray-row top-border bottom-border">
              <td>DB I</td>
              <td></td>
              <td></td>
            </tr>
            <!-- Produktfixkosten (weiß) -->
            <tr class="bottom-border">
              <td>Produktfixkosten</td>
              <td></td>
              <td></td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Rechte Seite: Tabelle mit DB I, Produktfixkosten, DB II -->
      <div class="summary-section">
        <table class="db2-tabelle">
          <thead>
            <tr>
              <th>Produkt</th>
              <th>DB I (€)</th>
              <th>Produktfixkosten (€)</th>
              <th>DB II (€)</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Produkt A</td>
              <td>216.076,5</td>
              <td>30.000</td>
              <td>186.076,5</td>
            </tr>
            <tr>
              <td>Produkt B</td>
              <td>128.623,5</td>
              <td>20.000</td>
              <td>108.623,5</td>
            </tr>
            <tr class="total-row">
              <td>Gesamt</td>
              <td>344.700</td>
              <td>50.000</td>
              <td>294.700</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "DeckungsbeitragMehrstufigDBII"
};
</script>

<style scoped>
.title {
  font-size: 1.4rem;
}
.db2-page {
  max-width: 900px;
  margin: 1rem auto;
  font-family: sans-serif;
  line-height: 1.4;
}

h1 {
  margin-bottom: 1rem;
}

/* Formel */
.formula-block {
  margin: 2rem 0 1.5rem;
  text-align: center;
}
.formula {
  font-size: 1.4rem;
  font-style: italic;
}

/* Layout: zwei Spalten nebeneinander */
.layout-row {
  display: flex;
  gap: 2rem;
  margin-top: 1rem;
}

.mini-table-section {
  flex: 0.5;
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

/* ===== Tabelle DB II rechts ===== */
.db2-tabelle {
  width: 100%;
  border-collapse: collapse;
  text-align: left;
}

.db2-tabelle th,
.db2-tabelle td {
  border: 1px solid #ccc;
  padding: 8px 12px;
}

.db2-tabelle thead tr {
  background-color: #f5f5f5;
}

.total-row td {
  font-weight: bold;
}
</style>

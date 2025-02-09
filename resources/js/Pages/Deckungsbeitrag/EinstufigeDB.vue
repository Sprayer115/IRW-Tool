<template>
      <div class="py-12 bg-white dark:bg-white">
  <div class="deckungsbeitrag-page">
    <!-- Titel -->
    <h2>Deckungsbeitrag (einstufig) – DB I</h2>

    <!-- Einleitender Text -->
    <p>
      Die einstufige Deckungsbeitragsrechnung betrachtet den Deckungsbeitrag als
      Differenz zwischen <strong>Umsatzerlösen</strong> und
      <strong>variablen Kosten</strong>.
    </p>
    <p>
      Der <strong>einstufige Deckungsbeitrag (DB I)</strong> zeigt, wie viel
      jedes Produkt zur Deckung der Fixkosten und zur Erzielung eines Gewinns
      beiträgt.
    </p>

    <!-- Formel -->
    <h3>Formel:</h3>
    <div class="formula-block">
      <p class="formula">
        <strong>DB I = Umsatzerlöse – Variable Kosten</strong>
      </p>
    </div>

    <!-- Flex-Layout: links die kleine Skizzen-Tabelle, rechts die Zusammenfassung -->
    <div class="layout-row">
      <!-- Mini-Tabelle (linke Seite, wie im Screenshot) -->
      <div class="mini-table-section">
        <table class="mini-scheme">
          <!-- Kopfzeile mit 2 Spalten (Produkt A, Produkt B) -->
          <thead>
            <tr>
              <th></th>
              <th>Produkt A</th>
              <th>Produkt B</th>
            </tr>
          </thead>
          <tbody>
            <!-- Obere graue Zeile (Umsatzerlöse) -->
            <tr class="gray-row top-border bottom-border">
              <td>Umsatzerlöse</td>
              <td></td>
              <td></td>
            </tr>
            <!-- Weiße Zeile (Variable Kosten) -->
            <tr class="bottom-border">
              <td>Variable Kosten</td>
              <td></td>
              <td></td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Zusammenfassung (rechte Seite) -->
      <div class="summary-section">
        <h3><strong>Zusammenfassung der Ergebnisse </strong></h3>
        <table class="dbi-tabelle">
          <thead>
            <tr>
              <th>Produkt</th>
              <th>Umsatzerlöse (€)</th>
              <th>Variable Kosten (€)</th>
              <th>Deckungsbeitrag (€)</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Produkt A</td>
              <td>500.000</td>
              <td>283.923,5</td>
              <td>216.076,5</td>
            </tr>
            <tr>
              <td>Produkt B</td>
              <td>320.000</td>
              <td>191.376,5</td>
              <td>128.623,5</td>
            </tr>
            <tr class="total-row">
              <td>Gesamt</td>
              <td>820.000</td>
              <td>475.300</td>
              <td>344.700</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</template>

<script>
export default {
  name: "DeckungsbeitragEinstufigDBI"
};
</script>

<style scoped>
.deckungsbeitrag-page {
  max-width: 900px;
  margin: 1rem auto;
  font-family: sans-serif;
  line-height: 1.4;
}

h1 {
  margin-bottom: 1rem;
}

/* Formel-Block */
.formula-block {
  margin: 1rem 0;
}

.formula {
  font-size: 1.2rem;
  font-style: italic;
}

/* Layout-Container für die zwei Tabellen nebeneinander */
.layout-row {
  display: flex;
  gap: 2rem;
  margin-top: 2rem;
}

/* Kleinere (linke) Tabelle */
.mini-table-section {
  flex: 0.5;
}

/* Größere (rechte) Tabelle */
.summary-section {
  flex: 1;
}

/* 
   ============= Mini-Scheme =============
*/
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

/* Graue Zeile für Umsatzerlöse */
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

/*
   ============= DBI-Tabelle (rechte Seite) =============
*/
.dbi-tabelle {
  width: 100%;
  border-collapse: collapse;
  margin-top: 0.5rem;
  text-align: left;
}
.dbi-tabelle th,
.dbi-tabelle td {
  border: 1px solid #ccc;
  padding: 8px 12px;
}
.dbi-tabelle thead tr {
  background-color: #f5f5f5;
}
.dbi-tabelle .total-row td {
  font-weight: bold;
}
</style>

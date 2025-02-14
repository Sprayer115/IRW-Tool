<template>
  <div class="break-even-page">
    <!-- Titel -->
    <h1 class="title">Break Even Analyse – Break Even Umsatz</h1>
    <br>

    <!-- Kurze Beschreibung -->
    <p>
      Der <strong>Break-Even-Umsatz</strong> zeigt den Umsatz, der notwendig ist,
      um die Gesamtkosten zu decken.
    </p>

    <!-- Formeln -->
    <div class="formulas-container">
      <p class="main-formula">
        <strong>Break-Even-Umsatz = 
          <span class="fraction">
            <span class="numerator">Fixkosten</span>
            <span class="sep"></span>
            <span class="denominator">Deckungsbeitragsquote</span>
          </span>
        </strong>
      </p>
      <p class="main-formula">
        <strong>
        Deckungsbeitragsquote = 
        <span class="fraction">
          <span class="numerator">Deckungsbeitrag</span>
          <span class="sep"></span>
          <span class="denominator">Umsatzerlöse</span>
        </span></strong>
      </p>
    </div>

    <h3>Gegebene Werte aus der Deckungsbeitragsrechnung:</h3>

    <!-- Flex-Layout für linke Tabelle und rechte Ergebnisse -->
    <div class="layout-row">
      <!-- Linke "Schaubild"-Tabelle -->
      <div class="mini-scheme">
        <table>
          <thead>
            <tr>
              <th>Gesamt</th>
            </tr>
          </thead>
          <tbody>
            <tr class="gray-row top-border bottom-border">
              <td>
                <strong>Gesamte Fixkosten (aus DB IV)</strong>
                <br />
                329.000
              </td>
            </tr>
            <tr class="bottom-border">
              <td>
                <strong>Gesamter Deckungsbeitrag (DB I)</strong>
                <br />
                344.700 €
              </td>
            </tr>
            <tr class="gray-row bottom-border">
              <td>
                <strong>Gesamte Umsatzerlöse</strong>
                <br />
                820.000 €
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Rechte Seite: 
           Anzeige der Deckungsbeitragsquote und Break-Even-Umsatz
      -->
      <div class="right-info">
        <p>
          Deckungsbeitragsquote = 
          <strong>≈ 0,42 (42%)</strong>
        </p>
        <p class="beu-calc">
          Break-Even-Umsatz = 
          <span class="fraction fraction-inline">
            <span class="numerator">329.000</span>
            <span class="sep"></span>
            <span class="denominator">0,42</span>
          </span>
          ≈ 783.333 €
        </p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "BreakEvenUmsatz"
};
</script>

<style>
.tabelle-overflow{
  overflow: auto;
}
.title {
  font-size: 1.4rem;
}
.break-even-page {
  max-width: 800px;
  margin: 1rem auto;
  font-family: sans-serif;
  line-height: 1.4;
}

.formulas-container {
  margin: 1rem 0;
}

.main-formula {
  font-size: 1.1rem;
  margin: 1rem 0;
  font-style: italic;
  display: flex;
  flex-wrap: wrap;
}

/* Fraction styling */
.fraction {
  display: inline-block;
  text-align: center;
  margin: 0 0.5rem;
  vertical-align: middle;
}
.numerator,
.denominator {
  display: block;
}
.sep {
  display: block;
  border-bottom: 1px solid #000;
  margin: 2px 0;
}

/* Layout for the "mini-scheme" table (left) and results (right) */
.layout-row {
  display: flex;
  gap: 2rem;
  align-items: flex-start;
  margin-top: 1rem;
  overflow: auto;
}

/* Left "mini-scheme" table */
.mini-scheme table {
  border-collapse: collapse;
  width: 200px;
}
.mini-scheme th {
  border-bottom: 2px solid #000;
  padding: 4px;
  text-align: left;
}
.gray-row {
  background-color: #ccc;
  padding: 8px;
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

/* Right side for calculation text */
.right-info {
  flex: 1;
}
.beu-calc {
  margin-top: 1rem;
  font-size: 1.1rem;
}
.fraction-inline {
  margin-left: 0.5rem;
  margin-right: 0.5rem;
}
</style>

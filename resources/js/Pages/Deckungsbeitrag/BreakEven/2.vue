<template>
  <div class="break-even-menge-page">
    <!-- Titel -->
    <h1 class="title">Break Even Analyse – Break Even Menge</h1>

    <!-- Kurze Beschreibung -->
    <p>
      Die <strong>Break-Even-Menge</strong> gibt an, wie viele Einheiten eines
      Produkts verkauft werden müssen, um die Fixkosten zu decken.
    </p>

    <!-- Formel -->
    <div class="formula-main">
      <p class="formula">
        <strong>Break-Even-Menge =</strong>
        <span class="fraction">
          <span class="numerator">Fixkosten</span>
          <span class="sep"></span>
          <span class="denominator">Deckungsbeitrag pro Stück</span>
        </span>
      </p>
    </div>

    <!-- Zweispaltiges Layout: links Schaubild-Tabelle, rechts Break-Even-Menge A/B -->
    <div class="layout-row">
      <!-- Links: Schaubild-Tabelle -->
      <div class="mini-scheme">
        <table>
          <thead>
            <tr>
              <th></th>
              <th>Produkt A</th>
              <th>Produkt B</th>
            </tr>
          </thead>
          <tbody>
            <!-- Fixkosten (grau) -->
            <tr class="gray-row top-border bottom-border">
              <td>Fixkosten</td>
              <td></td>
              <td></td>
            </tr>
            <!-- Deckungsbeitrag pro Stück (weiß) -->
            <tr class="bottom-border">
              <td>Deckungsbeitrag pro Stück</td>
              <td></td>
              <td></td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Rechts: Konkrete Rechnung für A/B -->
      <div class="calculations-right">
        <p class="bem-calc">
          <strong>Break-Even-Menge A =</strong>
          <span class="fraction fraction-inline">
            <span class="numerator">207.857,1</span>
            <span class="sep"></span>
            <span class="denominator">15</span>
          </span>
          ≈ 13.857 Einheiten
        </p>
        <p class="bem-calc">
          <strong>Break-Even-Menge B =</strong>
          <span class="fraction fraction-inline">
            <span class="numerator">121.142,9</span>
            <span class="sep"></span>
            <span class="denominator">12</span>
          </span>
          ≈ 10.095 Einheiten
        </p>
      </div>
    </div>
    <!-- Skript-Button, analog zu 2.vue -->
    <div style="text-align: right; margin-top: 1rem;">
      <button class="btnShowScript" @click="downloadScript">Skript</button>
    </div>
  </div>
</template>

<script>
export default {
  name: "BreakEvenMenge",
  methods: {
    downloadScript() {
      const link = document.createElement('a');
      link.href = '/storage/BreakEven.pdf';
      link.setAttribute('download', 'BreakEven.pdf');
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    }
  }
};
</script>

<style scoped>
.title {
  font-size: 1.4rem;
}
.break-even-menge-page {
  max-width: 800px;
  margin: 1rem auto;
  font-family: sans-serif;
  line-height: 1.4;
}

h1 {
  margin-bottom: 1rem;
}

/* Haupt-Formel */
.formula-main {
  margin: 1rem 0;
}
.formula {
  font-size: 1.1rem;
  font-style: italic;
  display: flex;
  flex-wrap: wrap;
  align-items: center;
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

/* Layout for table (left) and calculations (right) */
.layout-row {
  display: flex;
  gap: 2rem;
  margin-top: 2rem;
  overflow: auto;
}

/* Linke (mini-scheme) Tabelle */
.mini-scheme table {
  border-collapse: collapse;
  width: 230px;
}
.mini-scheme th {
  border-bottom: 2px solid #000;
  padding: 4px;
  text-align: left;
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

/* Rechte Seite: Break-Even-Menge A/B */
.calculations-right {
  flex: 1;
}
.bem-calc {
  margin-bottom: 1.5rem;
  font-size: 1.05rem;
}
.fraction-inline {
  margin: 0 0.5rem;
}

/* Skript-Button, angelehnt an 2.vue */
.btnShowScript {
  background-color: #475569; /* bg-slate-600 */
  border-radius: 12px;
  margin: 5px;
  padding: 14px 28px;
  font-weight: 500;
  color: rgb(226,232,240);
  border: none;
  cursor: pointer;
}

.btnShowScript:hover {
  opacity: 0.85;
}
</style>

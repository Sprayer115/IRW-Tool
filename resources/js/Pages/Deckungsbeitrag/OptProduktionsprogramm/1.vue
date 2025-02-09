<template>
  <div class="optimal-production-step1">
    <!-- Titel -->
    <h1 class="title">Optimales Produktionsprogramm – Schritt I</h1>

    <br>
    <!-- Schritt 1 -->
    <h2><strong>Schritt 1: Identifikation des Engpasses</strong></h2>
    <br>
    <p>
      Ein Engpass ist die Ressource, die am stärksten begrenzt ist und die
      Produktion limitiert.
    </p>
    <br>
    <p>Beispiele für Engpässe:</p>
    <ul class="sub-list">
      <li>•&nbsp; Maschinenstunden</li>
      <li>•&nbsp; Arbeitszeit</li>
      <li>•&nbsp; Materialkapazität</li>
    </ul>
    <br>

    <!-- Schritt 2 -->
    <h2><strong>Schritt 2: Deckungsbeitrag pro Engpasseinheit</strong></h2>
    <br>
    <p>
      Der <strong>Deckungsbeitrag pro Engpasseinheit</strong> zeigt, wie viel
      Deckungsbeitrag ein Produkt je eingesetzter Einheit der begrenzten
      Ressource generiert.
    </p>

    <!-- Formel -->
    <div class="formula">
      <p class="formula-text">
        Deckungsbeitrag pro Engpasseinheit =
        <span class="fraction">
          <span class="numerator">Deckungsbeitrag pro Stück</span>
          <span class="sep"></span>
          <span class="denominator">Engpasseinheit pro Stück</span>
        </span>
      </p>
    </div>

    <!-- Zweispaltiges Layout: links Tabelle (Engpasseinheit, DB), rechts Rechnung -->
    <div class="layout-row">
      <!-- Linke „Schaubild“-Tabelle -->
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
            <!-- Engpasseinheit pro Stück -->
            <tr class="gray-row top-border bottom-border">
              <td>Engpasseinheit pro Stück</td>
              <td>15</td>
              <td>2</td>
            </tr>
            <!-- DB pro Stück -->
            <tr class="bottom-border">
              <td>Deckungsbeitrag pro Stück</td>
              <td>12</td>
              <td>1,5</td>
            </tr>
          </tbody>
        </table>

        <!-- Kleine Box für verfügbare Engpasskapazität -->
        <div class="capacity-box">
          <strong>Verfügbare Engpasskapazität:</strong> 3000
        </div>
      </div>

      <!-- Rechte Seite: Rechnung DB pro Engpasseinheit -->
      <div class="calc-right">
        <p>
          DB pro Engpasseinheit (A) = 
          <span class="fraction fraction-inline">
            <span class="numerator">15</span>
            <span class="sep"></span>
            <span class="denominator">2</span>
          </span>
          = 7,5 €/Stunde
        </p>

        <p>
          DB pro Engpasseinheit (B) = 
          <span class="fraction fraction-inline">
            <span class="numerator">12</span>
            <span class="sep"></span>
            <span class="denominator">1,5</span>
          </span>
          = 8,0 €/Stunde
        </p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "OptimalesProduktionsprogrammSchritt1"
};
</script>

<style scoped>
.sub-list {
  list-style: none;  /* Unterpunkte manuell nummerieren */
  padding-left: 1.5rem;
}
.title {
  font-size: 1.4rem;
}
.optimal-production-step1 {
  max-width: 800px;
  margin: 1rem auto;
  font-family: sans-serif;
  line-height: 1.4;
}

/* Formel-Abschnitt */
.formula .formula-text {
  text-align: center;
  font-size: 1.1rem;
  font-style: italic;
  margin: 1rem 0;
}

/* Fraction styling (horizontale Bruchstriche) */
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

/* Zweispaltiges Layout */
.layout-row {
  display: flex;
  gap: 2rem;
  margin-top: 1rem;
}
.mini-scheme {
  flex: 0.5;
}

/* Tabellen-Stil (Schaubild links) */
.mini-scheme table {
  border-collapse: collapse;
  width: 100%;
  margin-bottom: 1rem;
}
.mini-scheme th {
  border-bottom: 2px solid #000;
  padding: 4px 8px;
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

/* Box für Engpasskapazität */
.capacity-box {
  border: 1px solid #000;
  padding: 8px;
  width: fit-content;
  margin-top: 0.5rem;
}

/* Rechte Spalte für Rechenbeispiele */
.calc-right {
  flex: 1;
}
.fraction-inline {
  margin: 0 0.5rem;
}
</style>

<template>
  <div class="optimal-production-step2">
    <!-- Titel -->
    <h1 class="title">Optimales Produktionsprogramm – Schritt II</h1>
    <br>

    <!-- 4. Priorisierung -->
    <h2><strong>4. Priorisierung der Produkte</strong></h2>
    <br>
    <ul>
      <li>
        Produkte werden nach dem höchsten
        <strong>Deckungsbeitrag pro Engpasseinheit</strong> priorisiert
      </li>
      <li>
        Das Produkt mit dem höchsten Wert wird zuerst produziert, bis der
        Engpass (z. B. Maschinenstunden) ausgeschöpft ist
      </li>
    </ul>
    <br>

    <!-- 5. Maximale Produktionsmenge eines Produkts -->
    <h2><strong>5. Maximale Produktionsmenge eines Produkts</strong></h2>
    <br>
    <div class="formula-block">
      <p class="formula">
        <strong>Maximale Stückzahl =</strong>
        <span class="fraction">
          <span class="numerator">Verfügbare Engpasskapazität</span>
          <span class="sep"></span>
          <span class="denominator">Engpasseinheit pro Stück</span>
        </span>
      </p>
    </div>

    <p>
      <!-- Beispiel: -->
      <strong>Stückzahl B =</strong>
      <span class="fraction fraction-inline">
        <span class="numerator">Maschinenstunden</span>
        <span class="sep"></span>
        <span class="denominator">Maschinenstunden pro Stück</span>
      </span>
      =
      <span class="fraction fraction-inline">
        <span class="numerator">3000</span>
        <span class="sep"></span>
        <span class="denominator">1,5</span>
      </span>
      = 2000 Stück
    </p>

    <br>
    <!-- 6. Maschinenstundenbedarf -->
    <h2><strong>6. Maschinenstundenbedarf</strong></h2>
    <br>
    <p>
      <strong>Maschinenstundenbedarf </strong>=
      Produzierte Stückzahl × <strong>Engpasseinheit pro Stück</strong>
    </p>
    <br>
    <p>
      <!-- Beispiel: -->
      2000 × 1,5 = 3000 Stunden
    </p>
  </div>
</template>

<script>
export default {
  name: "OptimalesProduktionsprogrammSchritt2"
};
</script>

<style scoped>
.title {
  font-size: 1.4rem;
}
.optimal-production-step2 {
  max-width: 800px;
  margin: 1rem auto;
  font-family: sans-serif;
  line-height: 1.4;
}

.formula-block {
  text-align: center;
  margin: 1rem 0;
}

/* Formel-Layout (Bruch) */
.formula {
  text-align: center;
  font-size: 1.1rem;
  font-style: italic;
  display: flex;
  flex-wrap: wrap;
  align-items: center;
}

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

.fraction-inline {
  margin: 0 0.5rem;
}
</style>

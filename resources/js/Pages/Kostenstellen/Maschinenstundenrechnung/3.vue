<template>
  <div class="maschinenstundensatz-container">
    <!-- Abschreibungen -->
    <h2 class="red-heading">Abschreibungen im Maschinenstundensatz</h2>
    <div class="formula-block">
      <p class="formula-title">Abschreibungskosten p.a. =</p>
      <p class="formula">
        Wiederbeschaffungs- oder Anschaffungswert <br />
        ─────────────────────────────────────────── <br />
        wirtschaftliche Nutzungsdauer der Maschine
      </p>
    </div>
    <p class="example-heading">Abschreibungskosten im Beispiel =</p>
    <p class="example-result">320.000 EUR / 8 Jahre = 40.000 EUR p.a.</p>
    <hr class="my-2 border-gray-300 dark:border-gray-600" />

    <!-- Zinsen -->
    <h2 class="red-heading">Zinsen im Maschinenstundensatz</h2>
    <div class="formula-block">
      <p class="formula-title">Zinskosten p.a. =</p>
      <p class="formula">Zinssatz * durchschnittlich gebundenes Kapital</p>
    </div>
    <p class="example-heading">Zinskosten im Beispiel =</p>
    <p class="example-result">9 % * 150.000 EUR = 13.500 EUR p.a.</p>
    <hr class="my-2 border-gray-300 dark:border-gray-600" />

    <!-- Raumkosten -->
    <h2 class="red-heading">Raumkosten im Maschinenstundensatz</h2>
    <div class="formula-block">
      <p class="formula-title">Raumkosten p.a. =</p>
      <p class="formula">Raumkostensatz * benötigte Fläche</p>
    </div>
    <p class="example-heading">Raumkosten im Beispiel =</p>
    <p class="example-result">240 EUR / qm * 50,75 qm = 12.180 EUR p.a.</p>
    <hr class="my-2 border-gray-300 dark:border-gray-600" />

    <!-- Energiekosten -->
    <h2 class="red-heading">Energiekosten im Maschinenstundensatzrechnung</h2>
    <div class="formula-block">
      <p class="formula-title">Energiekosten p.a. =</p>
      <p class="formula">
        Energieverbrauch * Nutzungszeit * Energiekostensatz
      </p>
    </div>
    <p class="example-heading">Energiekosten im Beispiel =</p>
    <p class="example-result">
      10 kw * 1.320 h * 0,50 EUR/kwh = 6.600 EUR p.a.
    </p>
    <hr class="my-2 border-gray-300 dark:border-gray-600" />

    <!-- Instandhaltungskosten -->
    <h2 class="red-heading">Instandhaltungskosten im Maschinenstundensatz</h2>
    <div class="formula-block">
      <p class="formula-title">Instandhaltungskosten p.a. =</p>
      <p class="formula">
        Einzelkosten der Maschine durch Rechnungen <br />
        oder pauschale Wartungssätze
      </p>
    </div>
    <p class="example-heading">Instandhaltung im Beispiel =</p>
    <p class="example-result">
      7,5 % * 300.000 EUR = 22.500 EUR p.a.
    </p>
  </div>
</template>

<script>
export default {
  name: "MaschinenstundensatzBerechnung"
};
</script>

<style scoped>
.maschinenstundensatz-container {
  max-width: 700px;
  margin: 1rem auto;
  font-family: sans-serif;
  line-height: 1.4;
}

/* Rote Überschriften */
.red-heading {
  color: red;
  margin: 1.5rem 0 1rem;
  font-size: 1.1rem;
}

/* Block für Formel-Darstellung */
.formula-block {
  margin-left: 1rem;
  margin-bottom: 1rem;
}
.formula-title {
  font-weight: bold;
  display: inline-block;
  margin-bottom: 0.25rem;
}
.formula {
  margin-left: 1rem;
  font-style: italic;
}

/* Beispiel-Zeilen */
.example-heading {
  color: red;
  font-weight: bold;
  margin-bottom: 0.25rem;
}
.example-result {
  margin-left: 1rem;
  font-weight: 600;
}
</style>

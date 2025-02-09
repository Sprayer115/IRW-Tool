<template>
  <div class="optimal-production-step3">
    <h1 class="title">Optimales Produktionsprogramm III</h1>
    <br>

    <!-- 7. Restkapazität verrechnen -->
    <h2><strong>7. Restkapazität verrechnen</strong></h2>
    <br>
    <p>
      Nach Produktion eines priorisierten Produkts wird die verbleibende
      Kapazität berechnet:
    </p>

    <div class="formula-block">
      <p class="formula">
        <strong>Restkapazität = Gesamtkapazität – Maschinenstundenbedarf</strong>
      </p>
    </div>

    <p class="example">
      Restkapazität: 3.000 – 3.000 = 0 Stunden
    </p>

    <!-- 8. Endergebnis -->
    <h2>8. Endergebnis</h2>
    <table class="ergebnis-tabelle">
      <thead>
        <tr>
          <th>Produkt</th>
          <th>Stückzahl</th>
          <th>DB/Stück (€)</th>
          <th>Gesamt-DB (€)</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Produkt B</td>
          <td>2.000</td>
          <td>12</td>
          <td>2.000 × 12 = 24.000 €</td>
        </tr>
        <tr>
          <td>Produkt A</td>
          <td>0</td>
          <td>15</td>
          <td>0</td>
        </tr>
      </tbody>
    </table>

    <p class="sum">
      Gesamter Deckungsbeitrag: <strong>24.000 €</strong>
    </p>
  </div>
</template>

<script>
export default {
  name: "OptimalesProduktionsprogrammSchritt3"
};
</script>

<style scoped>
.title {
  font-size: 1.4rem;
}
.optimal-production-step3 {
  max-width: 800px;
  margin: 1rem auto;
  font-family: sans-serif;
  line-height: 1.4;
}

.formula-block {
  margin: 1rem 0;
  text-align: center;
}

.formula {
  font-size: 1.1rem;
  font-style: italic;
  margin: 0.5rem 0;
}

.example {
  margin-bottom: 1rem;
  font-weight: bold;
  text-align: center;
}

.ergebnis-tabelle {
  width: 100%;
  border-collapse: collapse;
  margin-top: 0.75rem;
  text-align: left;
}

.ergebnis-tabelle th,
.ergebnis-tabelle td {
  border: 1px solid #ccc;
  padding: 8px 12px;
}

.ergebnis-tabelle thead tr {
  background-color: #f5f5f5;
}

.sum {
  margin-top: 0.75rem;
  font-size: 1.1rem;
  font-weight: bold;
}
</style>

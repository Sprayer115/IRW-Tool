<template>
  <div class="db-ergebnis-container">
    <h2>Ergebnis der mehrstufigen Deckungsbeitragsrechnung</h2>

    <table class="db-ergebnis-tabelle">
      <thead>
        <tr>
          <th>Stufe</th>
          <th>Produkt A (€)</th>
          <th>Produkt B (€)</th>
          <th>Gesamt (€)</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>DB I (einstufig)</td>
          <td>216.076,5</td>
          <td>128.623,5</td>
          <td>344.700</td>
        </tr>
        <tr>
          <td>DB II (nach Produktfixkosten)</td>
          <td>186.076,5</td>
          <td>108.623,5</td>
          <td>294.700</td>
        </tr>
        <tr>
          <td>DB III (nach Bereichsfixkosten)</td>
          <td>9.832,5</td>
          <td>5.867,5</td>
          <td>15.700</td>
        </tr>
        <tr>
          <td>DB IV (nach Unternehmensfixkosten)</td>
          <td>-21.738,5</td>
          <td>-12.561,5</td>
          <td>-34.300</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: "MehrstufigeDBErgebnis"
};
</script>

<style scoped>
.db-ergebnis-container {
  max-width: 700px;
  margin: 1rem auto;
  font-family: sans-serif;
}

.db-ergebnis-tabelle {
  width: 100%;
  border-collapse: collapse;
  text-align: left;
  margin-top: 1rem;
}

.db-ergebnis-tabelle th,
.db-ergebnis-tabelle td {
  border: 1px solid #ccc;
  padding: 8px 12px;
}

.db-ergebnis-tabelle thead tr {
  background-color: #f5f5f5;
}
</style>

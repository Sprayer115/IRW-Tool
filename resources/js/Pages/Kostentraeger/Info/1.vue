<template>
  <div class="gleichungsverfahren-uebernahme">
    <h1 class="title">Kostenträgerrechnung </h1>
    <br>
    <h2>Übernahme der Zahlen aus dem Gleichungsverfahren</h2>
    <br>
    <p>Die Gesamtkosten aus dem Gleichungsverfahren sind:</p>
    <br>

    <table class="gesamtkosten-tabelle">
      <thead>
        <tr>
          <th>Kostenstelle</th>
          <th>Gesamtkosten (€)</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Verwaltung</td>
          <td>127.000</td>
        </tr>
        <tr>
          <td>Produktion</td>
          <td>230.000</td>
        </tr>
        <tr>
          <td>Vertrieb</td>
          <td>152.000</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: "GleichungsverfahrenUebernahme"
};
</script>

<style scoped>
.title {
  font-size: 1.4rem;
}
.gleichungsverfahren-uebernahme {
  max-width: 600px;
  margin: 1rem auto;
  font-family: sans-serif;
}

h2 {
  margin-bottom: 0.75rem;
}

.gesamtkosten-tabelle {
  width: 100%;
  border-collapse: collapse;
  margin-top: 0.5rem;
  text-align: left;
}

.gesamtkosten-tabelle th,
.gesamtkosten-tabelle td {
  border: 1px solid #ccc;
  padding: 8px 12px;
}

.gesamtkosten-tabelle thead tr {
  background-color: #f5f5f5;
}

.gesamtkosten-tabelle th {
  font-weight: 600;
}
</style>

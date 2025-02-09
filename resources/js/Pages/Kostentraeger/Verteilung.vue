<template>
    <div class="py-12 bg-white dark:bg-white">
    <div class="kostenverteilung-container">
      <h1 class="title">Kostenträgerrechnung – Kostenverteilung</h1>
  
      <table class="kostenverteilung-tabelle">
        <thead>
          <tr>
            <th>Kostenart/Kostenstelle</th>
            <th>Produkt A (€)</th>
            <th>Produkt B (€)</th>
            <th>Gesamtkosten (€)</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Einzelmaterial</td>
            <td>102.000 (60 %)</td>
            <td>68.000 (40 %)</td>
            <td>170.000</td>
          </tr>
          <tr>
            <td>Produktion (Gemeinkosten)</td>
            <td>138.000 (60 %)</td>
            <td>92.000 (40 %)</td>
            <td>230.000</td>
          </tr>
          <tr>
            <td>Verwaltung (74,71 %)</td>
            <td>76.194</td>
            <td>50.806</td>
            <td>127.000</td>
          </tr>
          <tr>
            <td>Vertrieb (89,41 %)</td>
            <td>89.411</td>
            <td>62.589</td>
            <td>152.000</td>
          </tr>
          <tr class="total-row">
            <td>Gesamtkosten</td>
            <td>405.605</td>
            <td>273.395</td>
            <td>679.000</td>
          </tr>
        </tbody>
      </table>
  
      <ul class="summary-list">
        <li>
          <strong>Produkt A</strong> verursacht Gesamtkosten in Höhe von 
          <strong>405.605&nbsp;€</strong>.
        </li>
        <li>
          <strong>Produkt B</strong> verursacht Gesamtkosten in Höhe von 
          <strong>273.395&nbsp;€</strong>.
        </li>
        <li>
          Die Gesamtkosten von <strong>679.000&nbsp;€</strong> stimmen mit den 
          Kosten aus der Kostenstellenrechnung überein (Kontrollsumme).
        </li>
      </ul>
    </div>
</div>
  </template>
  
  <script>
  export default {
    name: "KostentraegerKostenverteilung"
  };
  </script>
  
  <style scoped>
  .title {
  font-size: 1.4rem;
}
  .kostenverteilung-container {
    max-width: 800px;
    margin: 1rem auto;
    font-family: sans-serif;
  }
  
  .kostenverteilung-tabelle {
    width: 100%;
    border-collapse: collapse;
    margin: 1rem 0;
    text-align: left;
  }
  
  .kostenverteilung-tabelle th,
  .kostenverteilung-tabelle td {
    border: 1px solid #ccc;
    padding: 8px 12px;
    vertical-align: middle;
  }
  
  .kostenverteilung-tabelle thead tr {
    background-color: #f5f5f5;
  }
  
  .kostenverteilung-tabelle .total-row td {
    font-weight: bold;
  }
  
  .summary-list {
    list-style: disc;
    margin-left: 1.5rem;
    margin-top: 1rem;
  }
  .summary-list li {
    margin-bottom: 0.5rem;
  }
  </style>
  
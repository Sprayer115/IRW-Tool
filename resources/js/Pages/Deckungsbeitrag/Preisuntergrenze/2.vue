<template>
    <div class="langfristige-preisuntergrenze">
      <!-- Haupt-Titel -->
      <h1 class="title">Preisuntergrenzenrechnung – langfristige Preisuntergrenzen</h1>
  
      <!-- Abschnitt 2: Langfristige Preisuntergrenze -->
      <h2><strong>2. Langfristige Preisuntergrenze</strong></h2>
    
      <br>
      <!-- Definition -->
      <h3><strong>Definition: </strong></h3>
      <br>
      <p>
        Die <strong>langfristige Preisuntergrenze</strong> berücksichtigt sowohl die
        <strong>variablen Kosten</strong> als auch den <strong>Fixkostenanteil</strong> pro Stück,
        um langfristig alle Kosten des Unternehmens zu decken.
      </p>
  
      <br>
      <!-- Formel -->
      <h3><strong>Formel:</strong></h3>
      <br>
      <img src="images/Preisuntergrenze2.png">
      <br>
  
      <!-- Gegeben: Tabelle -->
      <h3><strong>Gegeben:</strong></h3>
      <table class="kosten-tabelle">
        <thead>
          <tr>
            <th>Produkt</th>
            <th>Variable Kosten/Stück (€)</th>
            <th>Fixkosten (€)</th>
            <th>Geplante Absatzmenge (Stück)</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Produkt A</td>
            <td>35</td>
            <td>237.815</td>
            <td>2.000</td>
          </tr>
          <tr>
            <td>Produkt B</td>
            <td>28</td>
            <td>141.185</td>
            <td>1.500</td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script>
  export default {
    name: "LangfristigePreisuntergrenze"
  };
  </script>
  
  <style scoped>
  .langfristige-preisuntergrenze {
    max-width: 700px;
    margin: 1rem auto;
    font-family: sans-serif;
    line-height: 1.4;
  }
  
  h1 {
    margin-bottom: 1rem;
  }
  
  /* Formel-Stil */
  .formula {
    font-size: 1.1rem;
    margin: 1rem 0;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
  }
  
  /* Bruch-Darstellung für Fixkosten / Absatzmenge */
  .fraction {
    display: inline-block;
    text-align: center;
    margin-left: 0.5rem;
  }
  .numerator,
  .denominator {
    display: block;
  }
  .sep {
    display: block;
    border-bottom: 1px solid #000;
    margin: -2px 0;
  }
  
  /* Tabelle */
  .kosten-tabelle {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
    text-align: left;
  }
  
  .kosten-tabelle th,
  .kosten-tabelle td {
    border: 1px solid #ccc;
    padding: 8px 12px;
  }
  
  .kosten-tabelle thead tr {
    background-color: #f5f5f5;
  }
  </style>
  
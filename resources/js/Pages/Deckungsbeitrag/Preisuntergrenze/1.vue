<template>
    <div class="preisuntergrenze-container">
      <!-- Haupt-Titel -->
      <h1 class="title">Preisuntergrenzenrechnung – kurzfristige Preisuntergrenzen</h1>
  
      <!-- Abschnitt 1: Kurzfristige Preisuntergrenze -->
      <h2><strong>1. Kurzfristige Preisuntergrenze</strong></h2>
      <br>
  
      <!-- Definition -->
      <h3><strong>Definition:</strong></h3>
      <p>
        Die kurzfristige Preisuntergrenze entspricht den
        <strong>variablen Kosten pro Stück</strong>. Bei einem Preis unterhalb dieser
        Grenze deckt das Produkt nicht einmal die variablen Kosten, was bedeutet,
        dass mit jedem verkauften Stück ein Verlust entsteht.
      </p>
      <br>
  
      <!-- Formel -->
      <h3><strong>Formel:</strong></h3>
      <br>
      <img src="images/Preisuntergrenze1.png">
      <br>
  
      <!-- Gegeben: Tabelle -->
      <h3><strong>Gegeben:</strong></h3>
      <table class="kosten-tabelle">
        <thead>
          <tr>
            <th>Produkt</th>
            <th>Variable Kosten/Stück (€)</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Produkt A</td>
            <td>35</td>
          </tr>
          <tr>
            <td>Produkt B</td>
            <td>28</td>
          </tr>
        </tbody>
      </table>
  
      <!-- Ergebnis -->
      <h3>Ergebnis:</h3>
      <ul class="result-list">
        <li><strong>Produkt A:</strong> Kurzfristige Preisuntergrenze = 35 €</li>
        <li><strong>Produkt B:</strong> Kurzfristige Preisuntergrenze = 28 €</li>
      </ul>
  
      <br>
      <!-- Interpretation -->
      <h3><strong>Interpretation:</strong></h3>
      <br>
      <p>
        Wenn Produkt A unter 35 € oder Produkt B unter 28 € verkauft wird,
        entsteht ein Verlust pro Stück, da nicht einmal die variablen Kosten
        gedeckt werden.
      </p>
    </div>
  </template>
  
  <script>
  export default {
    name: "KurzfristigePreisuntergrenze"
  };
  </script>
  
  <style scoped>
  .title {
  font-size: 1.4rem;
}
  .preisuntergrenze-container {
    max-width: 700px;
    margin: 1rem auto;
    font-family: sans-serif;
    line-height: 1.4;
  }
  
  h1 {
    margin-bottom: 1rem;
  }
  
  /* Formel-Text etwas hervorgehoben */
  .formula {
    font-size: 1.1rem;
    font-style: italic;
    margin: 0.75rem 0;
  }
  
  /* Tabelle */
  .kosten-tabelle {
    width: 100%;
    border-collapse: collapse;
    margin: 1rem 0;
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
  
  .result-list {
    list-style: disc;
    margin-left: 1.5rem;
  }
  .result-list li {
    margin-bottom: 0.5rem;
  }
  </style>
  
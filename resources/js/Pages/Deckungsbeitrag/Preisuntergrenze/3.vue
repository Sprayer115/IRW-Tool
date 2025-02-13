<template>
  <div class="langfristige-preisuntergrenze">
    <h2>Berechnung:</h2>
    <br>

    <!-- Hauptliste (geordnete Liste) mit zwei großen Punkten -->
    <ol>
      <li>
        <strong>1. Fixkostenanteil pro Stück:</strong>
        <!-- Unterliste für beide Produkte (ungeordnet) -->
        <ul>
          <li>
            <br>
            <strong>• Produkt A:</strong>
            <div class="tabelle-overflow"> <br>
              <img src="images/Preisuntergrenze3.png" style="max-width: 500px;"/></div>
          </li>
          <li>
            <br>
            <strong>• Produkt B:</strong>
            <div class="tabelle-overflow"><br>
              <img src="images/Preisuntergrenze4.png" style="max-width: 500px;"/></div>
          </li>
        </ul>
      </li>

      <br>
      <li>
        <strong>2. Langfristige Preisuntergrenze:</strong>
        
        <ul>
          <li>
            <br>
            <strong>• Produkt A:</strong>
            <ul>
              <li>
                Langfristige Preisuntergrenze A
                = 35 € + 118,91 €
                = 153,91 €/Stück
              </li>
            </ul>
          </li>
          <br>
          <li>
            <strong>• Produkt B:</strong>
            <ul>
              <li>
                Langfristige Preisuntergrenze B
                = 28 € + 94,12 €
                = 122,12 €/Stück
              </li>
            </ul>
          </li>
        </ul>
      </li>
    </ol>

    <!-- Ergebnis (auch Stichpunkte) -->
     <br>
    <h3>Ergebnis:</h3>
    <br>
    <ul class="result-list">
      <li><strong>Produkt A:</strong> Langfristige Preisuntergrenze = 153,91 €</li>
      <li><strong>Produkt B:</strong> Langfristige Preisuntergrenze = 122,12 €</li>
    </ul>

    <br>
    <!-- Interpretation (weitere Aufzählung) -->
    <h3><strong>Interpretation:</strong></h3>
    <ul>
      <li>
        <br>
        Wenn Produkt A unter 153,91 € oder Produkt B unter 122,12 € verkauft wird, 
        werden langfristig nicht alle Fixkosten gedeckt werden, was das Unternehmen insgesamt unrentabel macht.
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: "LangfristigePreisuntergrenzeMitAufzaehlungen"
};
</script>

<style>
.tabelle-overflow{
  overflow: auto;
}

.langfristige-preisuntergrenze {
  max-width: 700px;
  margin: 1rem auto;
  font-family: sans-serif;
  line-height: 1.4;
}

.result-list {
  list-style: disc;
  margin-left: 1.5rem;
}

.result-list li {
  margin-bottom: 0.5rem;
}

/* Zusätzliche Formatierung für innere Listen */
ul ul {
  list-style: circle;
  margin-left: 1.5rem;
  margin-top: 0.5rem;
}
</style>

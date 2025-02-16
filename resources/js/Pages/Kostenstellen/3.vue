<template>
  <div class="gemeinkosten-container">
    <h2>Primäre Gemeinkosten</h2>
    <br>

    <!-- Wrapper mit position: relative, damit wir den Button oben rechts platzieren können -->
           <!-- Infobutton rechts, mittig zur Tabelle ausgerichtet -->
             <!-- eine div mehr da table wrapper mit scroll versehen ist -->
    <div class="table-wrapper">
    <div class="table-scroller">
      <table>
        <thead>
          <tr>
            <th>Kostenart</th>
            <th>Kosten (€)</th>
            <th>Verteilungsschlüssel (Beispiel)</th>
            <th>Kostenstellen</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Miete</td>
            <td>15.000</td>
            <td>Fläche</td>
            <td>50 % Produktion, 50 % Verwaltung</td>
          </tr>
          <tr>
            <td>Zinsen</td>
            <td>47.700</td>
            <td>Kapitaleinsatz</td>
            <td>70 % Produktion, 30 % Verwaltung</td>
          </tr>
          <tr>
            <td>Abschreibungen</td>
            <td>180.000</td>
            <td>Anlagenwert</td>
            <td>80 % Produktion, 20 % Verwaltung</td>
          </tr>
          <tr>
            <td>Einzelmaterial</td>
            <td>170.000</td>
            <td>Direkt zu Kostenträger</td>
            <td>Nicht für Kostenstellenrechnung</td>
          </tr>
          <tr>
            <td>Reparaturen</td>
            <td>21.000</td>
            <td>Anlagenwert</td>
            <td>80 % Produktion, 20 % Verwaltung</td>
          </tr>
          <tr>
            <td>Versicherungen</td>
            <td>16.000</td>
            <td>Fläche</td>
            <td>60 % Produktion, 40 % Verwaltung</td>
          </tr>
          <tr>
            <td>Werbung</td>
            <td>48.000</td>
            <td>Direkt zu Vertrieb</td>
            <td>Vertrieb</td>
          </tr>
          <tr>
            <td>Einzellöhne</td>
            <td>490.000</td>
            <td>Direkt zu Kostenträger</td>
            <td>Nicht für Kostenstellenrechnung</td>
          </tr>
        </tbody>
      </table>

    </div>
    <div>
      <span id="tooltip-aufwand" class="tooltip-container">
            <sup class="info-button">i</sup>
            <div class="table-scroller">
            <span class="tooltip-text">Primäre Gemeinkosten sind jene Kosten, die aus <br>externen Quellen direkt in das Unternehmen einfließen und <br>
              keinem bestimmten Produkt oder Auftrag direkt zugeordnet werden können. <br>Sie umfassen verschiedene Kategorien wie <br>Miete, Zinsen, Abschreibungen und Versicherungen. <br>
              <br>
                •	Miete: Wird oft nach genutzter Fläche aufgeteilt, <br>z. B. zwischen Produktion und Verwaltung. <br><br>
                •	Zinsen: Verteilt sich basierend auf dem <br>Kapitaleinsatz, also der finanziellen Ressourcennutzung.<br><br>
                •	Abschreibungen: Orientieren sich an den <br>Anlagenwerten, da diese die langfristigen Investitionen widerspiegeln.<br><br>
                •	Versicherungen: Meist ebenfalls flächenbezogen <br>verteilt, da sie für die Absicherung von Betriebsmitteln gelten.<br><br>
                •	Einzelmaterial und -löhne: Werden, wenn direkt <br>zuordenbar, nicht in der Kostenstellenrechnung <br>berücksichtigt, sondern direkt den Kostenträgern zugeordnet.<br><br>
                Die Kostenstellenrechnung hilft dabei, diese Gemeinkosten verursachungsgerecht auf <br>Kostenstellen zu verteilen, um später <br>eine präzise Zuweisung an die Kostenträger zu ermöglichen.<br>
            </span></div>
      </span>
    </div>
  </div>
  </div>
</template>

<script>
export default {
  name: "PrimaereGemeinkosten",
  methods: {
    onInfoClick() {
      alert("Hier könnte eine Info oder ein Tooltip erscheinen!");
    }
  }
};
</script>

<style scoped>
.gemeinkosten-container {
  max-width: 800px;
  margin: 1rem auto;
  font-family: sans-serif;

}

/* Wrapper mit position: relative für Button-Positionierung */
.table-wrapper {
  position: relative;
}

.table-scroller{
  overflow: auto;
}


/* Tabelle-Design */
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 0.5rem;
  text-align: left;
}

thead tr {
  background-color: #f5f5f5;
}

th,
td {
  padding: 8px 12px;
  border: 1px solid #ccc;
}

th {
  font-weight: 600;
}

/* Infobutton: rechts, vertical center (top 50% + translateY) */
.info-button {
  position: absolute;
  top: 50%;
  right: -2rem; /* Falls du mehr Platz willst, anpassen */
  transform: translateY(-50%);
  width: 24px;
  height: 24px;
  background-color: #000000;
  color: #fff;
  font-weight: bold;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  overflow: visible;
  
}

/* Optional: Hover-Effekt */
.info-button:hover {
  opacity: 0.85;
}
.tooltip-container:hover .tooltip-text {
    visibility: visible;
    opacity: 1;
    transition-delay: 0.1s; /* Delay before showing the tooltip */
    overflow: visible;
    left: -20rem;
    display: table;
}
.tooltip-container {
    position: absolute;
    display: block;
    cursor: pointer;
    top: 50%;
    right: -1rem;  /*Falls du mehr Platz willst, anpassen */
   transform: translateY(-50%);
   width: fit-content;
}
.tooltip-text {
    visibility: hidden;
    background-color: black;
    color: #fff;
    text-align: left;
    /*border-radius: 5px;*/
    padding: 5px;
    position: absolute;
    top: -15rem;
    z-index: 1;
    bottom: 150%;  /*Adjust to position above the element */
}
</style>

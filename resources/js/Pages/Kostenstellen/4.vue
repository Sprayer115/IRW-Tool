<template>
  <div class="gemeinkostenzuweisung">
    <h2><strong>Zuweisung der primären Gemeinkosten:</strong></h2>

    <!-- Wrapper, um den Infobutton rechts platzieren zu können -->
    <div class="table-wrapper">
      <div class="table-scroller">
      <table>
        <thead>
          <tr>
            <th>Kostenstelle</th>
            <th>Primäre Gemeinkosten (€)</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Verwaltung</td>
            <td>76.200</td>
          </tr>
          <tr>
            <td>Produktion</td>
            <td>193.500</td>
          </tr>
          <tr>
            <td>Vertrieb</td>
            <td>48.000</td>
          </tr>
        </tbody>
      </table>
    </div>
      <!-- Infobutton rechts, vertikal zentriert -->
      <div>
      <span id="tooltip-aufwand" class="tooltip-container">
            <sup class="info-button">i</sup>
            <span class="tooltip-text">Primäre Gemeinkosten sind jene Kosten, die aus externen Quellen <br>direkt in das Unternehmen einfließen und keinem bestimmten Produkt oder Auftrag direkt zugeordnet werden können. <br>Sie umfassen verschiedene Kategorien wie Miete, Zinsen, Abschreibungen und Versicherungen.<br><br>
            •	Miete: Wird oft nach genutzter Fläche aufgeteilt, z. B. zwischen Produktion und Verwaltung.<br>
            •	Zinsen: Verteilt sich basierend auf dem Kapitaleinsatz, also der finanziellen Ressourcennutzung.<br>
            •	Abschreibungen: Orientieren sich an den Anlagenwerten, da diese die langfristigen Investitionen widerspiegeln.<br>
            •	Versicherungen: Meist ebenfalls flächenbezogen verteilt, da sie für die Absicherung von Betriebsmitteln gelten.<br>
            •	Einzelmaterial und -löhne: Werden, wenn direkt zuordenbar, nicht in der <br>Kostenstellenrechnung berücksichtigt, sondern direkt den Kostenträgern zugeordnet.<br><br>
            &nbsp;Die Kostenstellenrechnung hilft dabei, diese Gemeinkosten verursachungsgerecht auf Kostenstellen<br> zu verteilen, um später eine präzise Zuweisung an die Kostenträger zu ermöglichen.
            </span>
      </span>
    </div>
      <br>
      <br>
      <!-- Skript-Button unter der Tabelle -->
      <div style="text-align: right;">
        <button class="btnShowScript" @click="onShowScript">Skript</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "GemeinkostenZuweisung",
  methods: {
    onInfoClick() {
      alert("Hier könnten weitere Informationen angezeigt werden!");
    },
    onShowScript() {
      const link = document.createElement('a');
      link.href = '/storage/Kostenstellen.pdf';
      link.setAttribute('download', 'Kostenstellen.pdf');
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    },
    onCalculator() {
      alert("Calculator clicked!");
      // Hier könntest du z.B. ein Modal öffnen oder eine andere Seite laden
    },
    onQuiz() {
      alert("Quiz clicked!");
      // Hier könntest du z.B. zu einem Quiz-Modul navigieren
    }
  }
};
</script>

<style scoped>
.gemeinkostenzuweisung {
  max-width: 600px;
  margin: 1rem auto;
  font-family: sans-serif;
}

/* Wrapper für Tabelle + Info-Button */
.table-wrapper {
  position: relative;
}

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
  right: -2rem;
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
}

.info-button:hover {
  opacity: 0.85;
}

/* Skript-Button, angelehnt an 2.vue */
.btnShowScript {
  background-color: #475569; /* bg-slate-600 */
  border-radius: 12px;
  margin: 5px;
  padding: 14px 28px;
  font-weight: 500;
  color: rgb(226, 232, 240);
  border: none;
  cursor: pointer;
  position: absolute;
  left: 50%;
  transform: translate(-50%, -50%);
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
    z-index: 1;
    top: 50%;
    /*bottom: 200%;  Adjust to position above the element */
    width: fit-content;
}
.table-scroller{
  overflow: auto;
}
</style>

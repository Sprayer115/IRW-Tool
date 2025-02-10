<template>
  <div class="gemeinkostenzuweisung">
    <h2><strong>Zuweisung der primären Gemeinkosten:</strong></h2>

    <!-- Wrapper, um den Infobutton rechts platzieren zu können -->
    <div class="table-wrapper">
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

      <!-- Infobutton rechts, vertikal zentriert -->
      <div class="info-button" @click="onInfoClick" title="Mehr Informationen">
        i
      </div>
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
}
</style>

<template>
  <div class="kosten-tabelle">
    <table>
      <thead>
        <tr>
          <th>Kostenart</th>
          <th>Aufwand</th>
          <th>Zeitliche Abgrenzung</th>
          <th>Zeitlich abgegrenzter Aufwand</th>
          <th>Sachliche Abgrenzung</th>
          <th>Kosten</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Miete</td>
          <td>60.000</td>
          <td>-45.000</td>
          <td>15.000</td>
          <td>0</td>
          <td>15.000</td>
        </tr>
        <tr>
          <td>Zinsen</td>
          <td>6.000</td>
          <td>0</td>
          <td>6.000</td>
          <td>5.925</td>
          <td>11.925</td>
        </tr>
        <tr>
          <td>Einzelmaterial</td>
          <td>160.000</td>
          <td>0</td>
          <td>160.000</td>
          <td>10.000</td>
          <td>170.000</td>
        </tr>
        <tr>
          <td>Abschreibungen</td>
          <td>55.000</td>
          <td>0</td>
          <td>55.000</td>
          <td>10.000</td>
          <td>45.000</td>
        </tr>
      </tbody>
    </table>

    <!-- Buttons unter der Tabelle -->
    <div class="button-group">
      <button class="btnShowScript" @click="onShowScript">Show script</button>
      <button class="btnShowScript" @click="onCalculator">Calculator</button>
      <button class="btnShowScript" @click="onQuiz">Quiz</button>
    </div>
  </div>
</template>

<script>
export default {
  name: "KostenAbgrenzungsTabelle",
  methods: {
    onShowScript() {
      alert("Show script clicked!");
      // Hier ggf. Route wechseln, Script anzeigen usw.
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
.kosten-tabelle {
  max-width: 800px;
  margin: 1rem auto;
  font-family: sans-serif;
}

table {
  width: 100%;
  border-collapse: collapse;
  text-align: center;
}

thead tr {
  background-color: #e0e0e0;
}

th,
td {
  border: 1px solid #ccc;
  padding: 8px 12px;
}

/* Button-Gruppe */
.button-group {
  margin-top: 1rem;
  display: flex;
  gap: 1rem; /* Abstand zwischen den Buttons */
}

/* Einheitlicher Button-Grundstil */
.btn {
  padding: 0.6rem 1rem;
  border: none;
  border-radius: 4px;
  
  font-size: 0.95rem;
  cursor: pointer;
  transition: background-color 0.2s ease;
}

.btnShowScript{
  background-color: #dbe4ec; /* Blau */
  border-radius: 12px;
  margin: 5px;
  padding: 14px 28px;
  position: relative;
  left: 20%;
}

/* Hover-Effekt */
.btn:hover {
  opacity: 0.85;
}
</style>
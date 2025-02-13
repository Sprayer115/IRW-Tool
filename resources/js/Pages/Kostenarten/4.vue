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

    <!-- Button-Gruppe: Skript-Button am unteren Rand -->

  </div>
  <div class="button-group">
      <button class="btnShowScript" @click="downloadScript">Skript</button>
    </div>
</template>

<script>
export default {
  name: "KostenAbgrenzungsTabelle",
  methods: {
    downloadScript() {
      const link = document.createElement('a');
      link.href = '/storage/Kostenartenrechnung.pdf';
      link.setAttribute('download', 'Kostenartenrechnung.pdf');
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    }
  }
};
</script>

<style scoped>
.kosten-tabelle {
  max-width: 800px;
  margin: 1rem auto;
  font-family: sans-serif;
  overflow: auto;
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
  justify-content: flex-end;
}

/* Skript-Button, angelehnt an 2.vue */
.btnShowScript {
  background-color: #475569; /* bg-slate-600 */
  border-radius: 12px;
  margin: 5px;
  padding: 14px 28px;
  font-weight: 500;
  color: rgb(226,232,240);
  border: none;
  cursor: pointer;
}

/* Hover-Effekt */
.btnShowScript:hover {
  opacity: 0.85;
}
</style>
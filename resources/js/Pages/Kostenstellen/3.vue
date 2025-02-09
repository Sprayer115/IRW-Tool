<template>
  <div class="gemeinkosten-container">
    <h2>Primäre Gemeinkosten</h2>

    <!-- Wrapper mit position: relative, damit wir den Button oben rechts platzieren können -->
    <div class="table-wrapper">
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

      <!-- Infobutton rechts, mittig zur Tabelle ausgerichtet -->
      <div class="info-button" @click="onInfoClick" title="Mehr Informationen">
        i
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
}

/* Optional: Hover-Effekt */
.info-button:hover {
  opacity: 0.85;
}
</style>

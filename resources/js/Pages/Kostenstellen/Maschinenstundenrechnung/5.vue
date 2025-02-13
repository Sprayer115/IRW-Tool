<template>
  <div class="msr-container">
    <h1>Erweiterung der Kostenstellenrechnung – Maschinenstundensatzrechnung</h1>
    
    <!-- Container für die beiden Buttons -->
    <div class="button-group">
      <button @click="clearHighlights" class="clear-button">Highlight Clear</button>
      <button @click="downloadScript" class="btnShowScript">Skript</button>
    </div>
    
    <!-- 1) Dynamische Eingabe-Tabelle -->
    <h2>Gegebene Beispielwerte für die Rechnung</h2>
    <table class="input-table">
      <tbody>
        <tr>
          <th>Anschaffungskosten (€)</th>
          <td>
            <input type="number" min="0" v-model.number="anschaffungskosten" />
          </td>
        </tr>
        <tr>
          <th>Wiederbeschaffungswert (€)</th>
          <td>
            <input type="number" min="0" v-model.number="wiederbeschaffungswert" />
          </td>
        </tr>
        <tr>
          <th>Voraussichtliche Nutzungsdauer (Jahre)</th>
          <td>
            <input type="number" min="1" v-model.number="nutzungsdauer" />
          </td>
        </tr>
        <tr>
          <th>Stellfläche (m²)</th>
          <td>
            <input type="number" step="0.01" min="0" v-model.number="stellflaeche" />
          </td>
        </tr>
        <tr>
          <th>Installierte Motorenleistung (kW)</th>
          <td>
            <input type="number" step="0.1" min="0" v-model.number="motorenleistung" />
          </td>
        </tr>
        <tr>
          <th>Durchschnittlicher Auslastungsgrad (%)</th>
          <td>
            <input type="number" step="1" min="0" max="100" v-model.number="auslastungsgrad" />
          </td>
        </tr>
        <tr>
          <th>Kalkulatorischer Zinssatz (% p.a.)</th>
          <td>
            <input type="number" step="0.1" min="0" v-model.number="zinssatz" />
          </td>
        </tr>
        <tr>
          <th>Instandhaltung (% von Anschaffungskosten)</th>
          <td>
            <input type="number" step="0.1" min="0" v-model.number="instandhaltungProzent" />
          </td>
        </tr>
        <tr>
          <th>Raumkostensatz (€/m² und Jahr)</th>
          <td>
            <input type="number" step="0.1" min="0" v-model.number="raumkostensatz" />
          </td>
        </tr>
        <tr>
          <th>Energiekosten (€/kWh)</th>
          <td>
            <input type="number" step="0.01" min="0" v-model.number="energiekosten" />
          </td>
        </tr>
        <tr>
          <th>Arbeitstage pro Jahr</th>
          <td>
            <input type="number" min="1" v-model.number="arbeitstage" />
          </td>
        </tr>
        <tr>
          <th>Arbeitsstunden pro Tag</th>
          <td>
            <input type="number" step="0.1" min="0" v-model.number="stundenProTag" />
          </td>
        </tr>
        <tr>
          <th>Ruhe- & Instandhaltungszeit (% Abzug der Gesamtarbeitszeit)</th>
          <td>
            <input type="number" step="1" min="0" max="100" v-model.number="pauseProzent" />
          </td>
        </tr>
      </tbody>
    </table>

    <!-- 2) Formel & Berechnung: Maschinenlaufzeit -->
    <h2 class="red-title">Berechnung der Maschinenlaufzeit</h2>
    <br>
    <p>Nutzungszeit im Beispiel:</p>
    <ul>
      <li>
        Maschinenzeit =
        <animated-number :value="arbeitstage" :clearTrigger="clearTrigger" /> Tage × {{ stundenProTag }} h/Tag =
        <animated-number :value="gesamtArbeitsstunden" :clearTrigger="clearTrigger" /> h
      </li>
      <li>
        Abzüglich Ruhe und Instandhaltung ({{ pauseProzent }} % von <animated-number :value="gesamtArbeitsstunden" :clearTrigger="clearTrigger" /> h)
        = <animated-number :value="pauseStunden" :clearTrigger="clearTrigger" /> h
      </li>
      <li>
        <strong>
          Ergibt Maschinenlaufzeit = 
          <animated-number :value="nutzungszeit" :clearTrigger="clearTrigger" /> h p.a.
        </strong>
      </li>
    </ul>
    <br>
    <!-- 3) Abschreibungskosten p.a. -->
    <h2 class="red-title">Abschreibungen im Maschinenstundensatz</h2>
    <br>
    <p>
      <em>Formel:</em>
      Abschreibungskosten p.a. = 
      <span class="fraction">
        <span class="numerator">
          Wiederbeschaffungs- oder Anschaffungswert
        </span>
        <span class="sep"></span>
        <span class="denominator">
          wirtschaftliche Nutzungsdauer
        </span>
      </span>
    </p>
    <br>
    <p>
      Abschreibungskosten (im Beispiel) =
      {{ wiederbeschaffungswert }} € / {{ nutzungsdauer }} Jahre =
      <strong>
        <animated-number :value="abschreibung" :clearTrigger="clearTrigger" /> € p.a.
      </strong>
    </p>
    <br>
    <!-- 4) Zinsen -->
    <h2 class="red-title">Zinsen im Maschinenstundensatz</h2>
    <br>
    <p>
      <em>Formel:</em>
      Zinskosten p.a. = Zinssatz × durchschnittlich gebundenes Kapital
    </p>
    <p>
      (Hier vereinfacht: durchschnittliches Kapital = 
      {{ (anschaffungskosten + wiederbeschaffungswert) / 2 }} €)
    </p>
    <p>
      Zinskosten p.a. (Beispiel) =
      {{ zinssatz }} % × 
      <animated-number :value="durchschnittlichGebundenesKapital" :clearTrigger="clearTrigger" /> =
      <strong>
        <animated-number :value="zinskosten" :clearTrigger="clearTrigger" /> € p.a.
      </strong>
    </p>

    <!-- 5) Instandhaltungskosten p.a. -->
    <br>
    <h2 class="red-title">Instandhaltungskosten im Maschinenstundensatz</h2>
    <br>
    <p>
      Instandhaltung p.a. = {{ instandhaltungProzent }} % × {{ anschaffungskosten }} € =
      <strong>
        <animated-number :value="instandhaltung" :clearTrigger="clearTrigger" /> € p.a.
      </strong>
    </p>

    <!-- 6) Raumkosten -->
    <br>
    <h2 class="red-title">Raumkosten im Maschinenstundensatz</h2>
    <br>
    <p>
      Raumkosten p.a. = {{ raumkostensatz }} € × {{ stellflaeche }} m² =
      <strong>
        <animated-number :value="raumkosten" :clearTrigger="clearTrigger" /> € p.a.
      </strong>
    </p>

    <!-- 7) Energiekosten -->
    <br>
    <h2 class="red-title">Energiekosten im Maschinenstundensatzrechnung</h2>
    <br>
    <p>
      Energiekosten p.a. = Energieverbrauch × Nutzungszeit × Energiekostensatz
      <br />
      (Vereinfacht: <em>Motorenleistung ({{ motorenleistung }} kW)</em> × 
      <em>Auslastungsgrad ({{ auslastungsgrad }} %)</em> × 
      <em>Nutzungszeit ({{ nutzungszeit }} h)</em> × 
      <em>{{ energiekosten }} €/kWh</em>)
    </p>
    <p>
      = <strong>
          <animated-number :value="energiekostenJaehrlich" :clearTrigger="clearTrigger" /> € p.a.
        </strong>
    </p>
    <!-- 8) Maschinenstundensatz -->
    <h2 class="red-title">Maschinenstundensatz</h2>
      <br>
      <p>
        <em>Formel:</em> <br>
        Maschinenstundensatz = 
        <span class="fraction">
          <span class="numerator">
            Maschinenkosten
          </span>
          <span class="sep"></span>
          <span class="denominator">
            Nutzungszeit p.a.
          </span>
        </span>
      </p>
      <br>
      <p style="text-align: center; font-size: 1.7rem;">=</p>
      <br>
      <p>
        Maschinenstundensatz = 
        <span class="fraction">
          <span class="numerator">
            Abschreibung + Zinsen + Raumkosten + Engergie + Instandhaltung
          </span>
          <span class="sep"></span>
          <span class="denominator">
            Nutzungszeit p.a.
          </span>
        </span>
      </p>
      <br>
      <p style="text-align: center; font-size: 1.7rem;">=</p>
      <br>
      <p>
        Maschinenstundensatz = 
        <span class="fraction">
          <span class="numerator">
            <animated-number :value="abschreibung" :clearTrigger="clearTrigger" /> ] 
          </span>
          <span class="sep"></span>
          <span class="denominator">
            Nutzungszeit p.a.
          </span>
        </span>
      </p>
      <br>
      <p>
        Abschreibungskosten (im Beispiel) =
        {{ wiederbeschaffungswert }} € / {{ nutzungsdauer }} Jahre =
        <strong>
          <animated-number :value="abschreibung" :clearTrigger="clearTrigger" /> € p.a.
        </strong>
      </p>
      <br>
  </div>
</template>

<script>
import AnimatedNumber from "@/Pages/Kostenstellen/Maschinenstundenrechnung/AnimatedNumber.vue";

export default {
  name: "MaschinenstundensatzRechnung",
  components: { AnimatedNumber },
  data() {
    return {
      // Input Values
      anschaffungskosten: 300000,
      wiederbeschaffungswert: 320000,
      nutzungsdauer: 8,
      stellflaeche: 50.75,
      motorenleistung: 25,
      auslastungsgrad: 40,
      zinssatz: 9,
      instandhaltungProzent: 7.5,
      raumkostensatz: 240,
      energiekosten: 0.4,
      arbeitstage: 220,
      stundenProTag: 8,
      pauseProzent: 25,
      clearTrigger: 0
    };
  },
  computed: {
    gesamtArbeitsstunden() {
      return this.arbeitstage * this.stundenProTag;
    },
    pauseStunden() {
      return (this.pauseProzent / 100) * this.gesamtArbeitsstunden;
    },
    nutzungszeit() {
      return this.gesamtArbeitsstunden - this.pauseStunden;
    },
    abschreibung() {
      return (this.wiederbeschaffungswert / this.nutzungsdauer).toFixed(2);
    },
    durchschnittlichGebundenesKapital() {
      return ((this.anschaffungskosten + this.wiederbeschaffungswert) / 2).toFixed(2);
    },
    zinskosten() {
      const zinsDecimal = this.zinssatz / 100;
      return (zinsDecimal * this.durchschnittlichGebundenesKapital).toFixed(2);
    },
    instandhaltung() {
      return ((this.instandhaltungProzent / 100) * this.anschaffungskosten).toFixed(2);
    },
    raumkosten() {
      return (this.raumkostensatz * this.stellflaeche).toFixed(2);
    },
    energiekostenJaehrlich() {
      const verbrauchProJahr =
        this.motorenleistung * (this.auslastungsgrad / 100) * this.nutzungszeit;
      return (verbrauchProJahr * this.energiekosten).toFixed(2);
    }
  },
  methods: {
    clearHighlights() {
      this.clearTrigger++;
    },
    downloadScript() {
      const link = document.createElement('a');
      link.href = '/storage/Maschinenstundensatzrechnung.pdf';
      link.setAttribute('download', 'Maschinenstundensatzrechnung.pdf');
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    }
  }
};
</script>

<style scoped>
.red-title {
  color: red;
  font-size: 1.2rem;
}

.msr-container {
  max-width: 900px;
  margin: 1rem auto;
  font-family: sans-serif;
  line-height: 1.4;
}

/* Container für die beiden Buttons */
.button-group {
  display: flex;
  gap: 350px;
  margin-bottom: 1rem;
}

/* Style for the clear button */
.clear-button {
  padding: 0.5rem 1rem;
  font-size: 1rem;
}

/* Style for the Skript button, angelehnt an 2.vue */
.btnShowScript {
  background-color: #475569; /* bg-slate-600 */
  border-radius: 12px;
  padding: 14px 28px;
  font-weight: 500;
  color: rgb(226, 232, 240);
  /* Damit der Button in der Flex-Box mit dem Clear-Button mitskalieren kann */
  border: none;
  cursor: pointer;
}
  
/* Style for the input table */
.input-table {
  border-collapse: collapse;
  width: 100%;
  max-width: 600px;
  margin-bottom: 2rem;
}

.input-table th,
.input-table td {
  border: 1px solid #ccc;
  padding: 8px;
}

.input-table th {
  background-color: #f5f5f5;
  text-align: left;
}

input {
  width: 100%;
  box-sizing: border-box;
}

/* Bruchformatierung */
.fraction {
  display: inline-block;
  text-align: center;
  margin: 0 0.5rem;
}

.numerator,
.denominator {
  display: block;
}

.sep {
  display: block;
  border-bottom: 1px solid #000;
  margin: 2px 0;
}

.fraction {
    display: inline-block;
    text-align: center;
    margin: 0 0.5rem;
  }
  
  .numerator,
  .denominator {
    display: block;
  }
  
  .sep {
    display: block;
    border-bottom: 1px solid #000;
    margin: 2px 0;
  }
  
  /* Style for the clear button */
  .clear-button {
    margin-bottom: 1rem;
    padding: 0.5rem 1rem;
    font-size: 1rem;
  }
  </style>
  
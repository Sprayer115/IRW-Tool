<template>
  <div class="msr-container">
    <h1>Erweiterung der Kostenstellenrechnung – Maschinenstundensatzrechnung</h1>
    <br>
    
    <!-- Container für die beiden Buttons -->
    <div class="button-group">
      <button @click="clearHighlights" class="clear-button">Highlights entfernen</button>
      <button @click="downloadScript" class="btnShowScript clear-button ml-2">Skript</button>
    </div>
    
    <!-- 1) Dynamische Eingabe-Tabelle -->
     
    <details open>
      <summary> <h2>Gegebene Beispielwerte für die Rechnung</h2></summary>
    <br>
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
  </details>
    <!-- 2) Formel & Berechnung: Maschinenlaufzeit -->
    <h2 class="red-title">Berechnung der Maschinenlaufzeit</h2>
    <br>
    <p>Nutzungszeit im Beispiel:</p>
    <ul>
      <li>
        Maschinenzeit =
        <animated-number :value="arbeitstage" :clearTrigger="clearTrigger" /> Tage × <animated-number :value="stundenProTag" :clearTrigger="clearTrigger" /> h/Tag =
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
      Abschreibungskosten =
      <animated-number :value="wiederbeschaffungswert" :clearTrigger="clearTrigger" /> € / <animated-number :value="nutzungsdauer" :clearTrigger="clearTrigger" /> Jahre =
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
    <br>
    <p>
      <em>Formel:</em> durchschnittlich gebundenes Kapital = 
      <span class="fraction">
        <span class="numerator">
          (Anschaffungskosten + Restbuchwert)
        </span>
        <span class="sep"></span>
        <span class="denominator">
          2
        </span>
      </span>
    </p>
    <br>
    <p>
      durchschnittlich gebundenes Kapital = 
      <span class="fraction">
        <span class="numerator">
          (<animated-number :value="anschaffungskosten" :clearTrigger="clearTrigger" /> + 0)
        </span>
        <span class="sep"></span>
        <span class="denominator">
          2
        </span>
      </span>
      <span>
        = <animated-number :value="durchschnittlichGebundenesKapital" :clearTrigger="clearTrigger" />
      </span>
    </p>
    <br>
    <p>
      Zinskosten p.a. (Beispiel) =
      <animated-number :value="zinssatz" :clearTrigger="clearTrigger" /> % × 
      <animated-number :value="durchschnittlichGebundenesKapital" :clearTrigger="clearTrigger" /> =
      <strong>
        <animated-number :value="zinskosten" :clearTrigger="clearTrigger" /> € p.a.
      </strong>
    </p>

    <!-- 5) Raumkosten -->
    <br>
    <h2 class="red-title">Raumkosten im Maschinenstundensatz</h2>
    <br>
    <p>
      <em>Formel:</em> Raumkosten p.a. = Raumkostensatz × benötigte Fläche 
    </p>
    <br>
    <p>
      Raumkosten p.a. = <animated-number :value="raumkostensatz" :clearTrigger="clearTrigger" /> €/qm × <animated-number :value="stellflaeche" :clearTrigger="clearTrigger" /> qm =
      <strong>
        <animated-number :value="raumkosten" :clearTrigger="clearTrigger" /> € p.a.
      </strong>
    </p>

    <!-- 6) Energiekosten -->
    <br>
    <h2 class="red-title">Energiekosten im Maschinenstundensatzrechnung</h2>
    <br>
    <p>
      <em>Formel:</em> Energiekosten p.a. = Energieverbrauch × Nutzungszeit × Energiekostensatz</p>
      <br>
      <p>
        Energiekosten p.a. = <em>(Motorenleistung) <animated-number :value="motorenleistung" :clearTrigger="clearTrigger" /> kW</em> × 
       <!--<em>Auslastungsgrad ({{ auslastungsgrad }} %)</em> × -->
      <em><animated-number :value="nutzungszeit" :clearTrigger="clearTrigger" /> h</em> × 
      <em><animated-number :value="energiekosten" :clearTrigger="clearTrigger" /> €/kWh</em>
    </p>
    <p>
      = <strong>
          <animated-number :value="energiekostenJaehrlich" :clearTrigger="clearTrigger" /> € p.a.
        </strong>
        <br>
    </p>

    <!-- 7) Instandhaltungskosten p.a. -->
    <br>
    <h2 class="red-title">Instandhaltungskosten im Maschinenstundensatz</h2>
    <br>
    <p>
      <em>Formel:</em> Instandhaltung p.a. = Instandhaltung (% von Anschaffungskosten) × Anschaffungskosten (€)

    </p>
    <br>
    <p>
      Instandhaltung p.a. = <animated-number :value="instandhaltungProzent" :clearTrigger="clearTrigger" /> % × <animated-number :value="anschaffungskosten" :clearTrigger="clearTrigger" /> € =
      <strong>
        <animated-number :value="instandhaltung" :clearTrigger="clearTrigger" /> € p.a.
      </strong>
    </p>
    <br>
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
            <animated-number :value="abschreibung" :clearTrigger="clearTrigger" /> + <animated-number :value="zinskosten" :clearTrigger="clearTrigger" /> + <animated-number :value="raumkosten" :clearTrigger="clearTrigger" /> + <animated-number :value="energiekostenJaehrlich" :clearTrigger="clearTrigger" /> + <animated-number :value="instandhaltung" :clearTrigger="clearTrigger" />
          </span>
          <span class="sep"></span>
          <span class="denominator">
            <animated-number :value="nutzungszeit" :clearTrigger="clearTrigger" />
          </span>
        </span>
      </p>
      <br>
      <p style="text-align: center; font-size: 1.7rem;">=</p>
      <br>
      <p>
        Maschinenstundensatz = <animated-number :value="maschinenstundensatz" :clearTrigger="clearTrigger" /> €/h
      </p>
      <br>
      <br>
  </div>
</template>

<script>
import AnimatedNumber from "@/Pages/Kostenstellen/Maschinenstundenrechnung/AnimatedNumber.vue";
import Maschinenstundenrechnung from "../Maschinenstundenrechnung.vue";
import Maschinenstundensatzrechnung from "@/Pages/Calc/Maschinenstundensatzrechnung.vue";

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
      motorenleistung: 10,
      auslastungsgrad: 40,
      zinssatz: 9,
      instandhaltungProzent: 7.5,
      raumkostensatz: 240,
      energiekosten: 0.5,
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
      return ((this.anschaffungskosten + 0) / 2).toFixed(2);
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
      const verbrauchProJahr = this.motorenleistung * this.nutzungszeit * this.energiekosten  ;/* (this.auslastungsgrad / 100)*/ 
      return verbrauchProJahr.toFixed(2);
    },
    maschinenstundensatz() {
      const instandhaltung = Number(this.instandhaltung);
      const energiekostenJaehrlich = Number(this.energiekostenJaehrlich);
      const raumkosten = Number(this.raumkosten);
      const zinskosten = Number(this.zinskosten);
      const abschreibung = Number(this.abschreibung);
      const nutzungszeit = Number(this.nutzungszeit);
      const maschinenstundensatz = instandhaltung + energiekostenJaehrlich + raumkosten + zinskosten + abschreibung;
      return (maschinenstundensatz / nutzungszeit).toFixed(2);
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
  display: table;
  gap: 350px;
  margin-bottom: 1rem;
}

/* Style for the clear button */
.clear-button {
  background-color: #475569; /* bg-slate-600 */
  border-radius: 12px;
  padding: 14px 28px;
  font-weight: 500;
  color: rgb(226, 232, 240);
  /* Damit der Button in der Flex-Box mit dem Clear-Button mitskalieren kann */
  border: none;
  cursor: pointer;
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
  
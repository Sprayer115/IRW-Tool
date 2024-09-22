<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref, computed, watch } from "vue";

// Kostentraegerzeitrechnung
const stueckPreis = ref(0); //enter
const geplantePMenge = ref(0); //enter
const KTZrechnung = ref(0);

// Deckungsbeitrag
const deckungsBeitrag = ref(0);
const varKosten = ref(0); //enter
 
// operative Ergebnis
const fixkosten = ref(0); //enter
const opErgebnis = ref(0);

const rows = ref([]);

onMounted(() => {
    rows.value = props.items.map(item => ({
        id: item.id,  // Ensure you have an ID field for deleting rows later
        stueckPreis: item.stueckPreis,
        geplantePMenge: item.geplantePMenge,
        KTZrechnung: item.KTZrechnung,
        deckungsBeitrag: item.deckungsBeitrag,
        varKosten: item.varKosten,
        fixkosten: item.fixkosten,
        opErgebnis: item.opErgebnis,
        neueSpalte: null,
    }));
});

async function addRow() {
    try {
        const newRow = {
            stueckPreis: stueckPreis.value, // Use month difference
            geplantePMenge: geplantePMenge.value,
            KTZrechnung: KTZrechnung.value,
            deckungsBeitrag: deckungsBeitrag.value,
            varKosten: varKosten.value,
            fixkosten: fixkosten.value,
            opErgebnis: opErgebnis.value,
        };

        try{
            newRow.KTZrechnung = calculateKTZ(newRow);
            newRow.deckungsBeitrag = calculateDB(newRow);
            newRow.opErgebnis = calculateOP(newRow);
            console.log(newRow);
        }catch(error){
            console.error('Error setting functions:', error)
        }
        

        const response = await axios.post('/breakeven', newRow);
        
        if (response.data) {
            rows.value.push({
                ...newRow,
                id: response.data.id, 
            });
            clearInputs();
        }
    } catch (error) {
        console.error('Error adding row:', error);
    }
}

async function deleteRow(id, index) {
    try {
        const response = await axios.delete(`/breakeven/${id}`);
        
        if (response.data) {
            rows.value.splice(index, 1); // Remove row from the array
        }
    } catch (error) {
        console.error('Error deleting row:', error);
    }
}

function clearInputs() {
    fixkosten.value = null;
    varPlanverrechnungssatz.value = null;
    istLeistung.value = null;
    istKosten.value = null;
    istKostenVerechneteLeistung.value = null;
}

function calculateOP(row) {
    let wert = 0;
    if (row.deckungsBeitrag && row.fixkosten) {
        wert = row.deckungsBeitrag - row.fixkosten;
    }
    row.opErgebnis = wert;
    return wert;
}

function calculateKTZ(row){
    let wert = 0;
    if(row.stueckPreis && row.geplantePMenge)
    {
        wert = row.stueckPreis * row.geplantePMenge;
    }
    console.log("wert:"+ wert)
    row.KTZrechnung = wert;
    return wert;
}

function calculateDB(row){
    let wert = 0;
    if(row.KTZrechnung && row.varKosten)
    {
        wert = row.KTZrechnung - row.varKosten;
    }
    row.deckungsBeitrag = wert;
    return wert;
}
</script>



<template>
    <div>
      <Head title="Break-Even">
      </Head>
  
      <AuthenticatedLayout>
          <template #header>
              <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Break-Even</h2>
          </template>
          <div class="py-12 m-lg-4">
            <div class="input-area"
                style="display: grid; grid-template-columns: 3fr 2fr; grid-gap: 20px; align-items: center; justify-content: center; justify-items: center; max-width: 600px; margin: 0 auto;">

                <!-- stueckPreis Label -->
                <label for="input1" style="justify-self: start;">Stückpreis:
                    <span id="tooltip-aufwand" class="tooltip-container">
                        <sup class="information">i</sup>
                        <span class="tooltip-text">Definition für den Aufwand</span>
                    </span>
                </label>
                <input type="number" v-model="stueckPreis" id="input1" style="max-width: 250px;" />

                <!-- geplantePMenge Input -->
                <label for="input2" style="justify-self: start;">geplante Produktionsmenge:  
                    <span id="tooltip-aufwand" class="tooltip-container">
                        <sup class="information">i</sup>
                        <span class="tooltip-text">Definition für den Aufwand</span>
                    </span>
                </label>
                <input type="number" v-model="geplantePMenge" id="input2" style="max-width: 250px;" />
                
                <!-- varKosten Input -->
                <label for="input3" style="justify-self: start;">Variable Kosten:  
                    <span id="tooltip-aufwand" class="tooltip-container">
                        <sup class="information">i</sup>
                        <span class="tooltip-text">Definition für den Aufwand</span>
                    </span>
                </label>
                <input type="number" v-model="varKosten" id="input3" style="max-width: 250px;" />

                <!-- fixkosten Input -->
                <label for="input4" style="justify-self: start;">fix Kosten:  
                    <span id="tooltip-aufwand" class="tooltip-container">
                        <sup class="information">i</sup>
                        <span class="tooltip-text">Definition für den Aufwand</span>
                    </span>
                </label>
                <input type="number" v-model="fixkosten" id="input4" style="max-width: 250px;" />

                <!-- Empty space to align button -->
                <div></div>
                <button class="button bg-primary" style="justify-self: start; max-width: 150px;" @click="addRow">Berechnen</button>
            </div>




  
              <table class="table">
                  <thead>
                      <tr>
                            <th class="bg-success">KTZrechnung
                                <span id="tooltip-sollKosten" class="tooltip-container">
                        <sup class="information">i</sup>
                        <span class="tooltip-text">SollKosten: Fixkosten + variabler Planverrechnungssatz * IstLeistung</span>
                    </span>
                            </th>
                            <th class = "bg-warning">deckungsBeitrag
                                <span id="tooltip-verbrauchsabweichung" class="tooltip-container">
                        <sup class="information">i</sup>
                        <span class="tooltip-text">Verbrauchsabweichung: IstKosten - SollKosten</span>
                    </span>
                            </th>
                            <th>opErgebnis
                                <span id="tooltip-beschaeftAbweichung" class="tooltip-container">
                        <sup class="information">i</sup>
                        <span class="tooltip-text">Beschäftigungsabweichung: SollKosten - IstKosten verrechnete Leistung</span>
                    </span>
                            </th>
                            <th>Actions</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr v-for="(row, index) in rows" :key="index">
                          <td>{{ row.KTZrechnung }}</td>
                          <td>{{ row.deckungsBeitrag }}</td>
                          <td>{{ row.opErgebnis }}</td>
                          <td><button class = "button bg-danger" @click="deleteRow(row.id, index)">löschen</button></td>
                      </tr>
                  </tbody>
              </table>
          </div>
      </AuthenticatedLayout>
    </div>
    <div> 
        
    </div>
</template>

<style>
.table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    border: 1px solid black;
    padding: 8px;
    text-align: left;
}


.input-area {
    margin-bottom: 20px;
}

label {
    margin-right: 10px;
}

.button{
  background-color: #ffffff;
  border: none;
  color: rgb(0, 0, 0);
  padding: 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  outline-color: black;
  outline: auto;
  
}

input {
    margin-right: 10px;
}

button {
    margin-top: 10px;
    
}

.tooltip {
    position: relative;
    display: inline-block;
    border-bottom: 1px dotted black;
    cursor: pointer;
}

.tooltip .tooltiptext {
    visibility: hidden;
    width: 120px;
    background-color: black;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px 0;
    position: absolute;
    z-index: 1;
    bottom: 125%; 
    left: 50%; 
    margin-left: -60px;
    opacity: 0;
    transition: opacity 0.3s;
}

.tooltip:hover .tooltiptext {
    visibility: visible;
    opacity: 1;
}

.tooltip-container {
    position: relative;
    display: inline-block;
    cursor: pointer;
}

.information {
    border: 1px solid;
    border-radius: 50%;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    width: 10px;
    height: 10px;
    font-size: 8px;
    margin-left: 1px;
}

/* Tooltip text - hidden by default */
.tooltip-text {
    visibility: hidden;
    background-color: black;
    color: #fff;
    text-align: center;
    border-radius: 5px;
    padding: 5px;
    position: absolute;
    z-index: 1;
    bottom: 150%; /* Adjust to position above the element */
    left: 50%;
    transform: translateX(-50%);
    opacity: 0;
    transition: opacity 0.5s ease-in-out; /* Animation */
    white-space: nowrap;
}

/* Show the tooltip when hovering over the container */
.tooltip-container:hover .tooltip-text {
    visibility: visible;
    opacity: 1;
    transition-delay: 0.1s; /* Delay before showing the tooltip */
}

</style>

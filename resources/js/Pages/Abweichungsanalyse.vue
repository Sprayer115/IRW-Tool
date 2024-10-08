<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import html2pdf from 'html2pdf.js';

const emit = defineEmits(['update:checked']);

const props = defineProps({
    value: {
        default: null,
    },
    items: {
        type: Array,
        default: () => [],
    }
});

const proxyChecked = computed({
    get() {
        return props.checked;
    },
    set(val) {
        emit('update:checked', val);
    },
});

//Sollkosten
const sollkosten = ref(null);
const fixkosten = ref(null);
const varPlanverrechnungssatz = ref(null);
const istLeistung = ref(null);

//Verbrauchsabweichung
const verbrauchsabweichung = ref(null);
const istKosten = ref(null);
const sollKosten = ref(null);

//Beschäftigungsabweichung
const beschaeftAbweichung = ref(null);
const istKostenVerechneteLeistung = ref(null);

//Gesamtabweichung
const gesamtabweichung = ref(null);
const rows = ref([]);
const rowsP = ref([]);
const rowsP2 = ref([]);

const selectedRow = ref(null); // To hold the selected row in the modal
const showModal = ref(false);  // Controls the modal visibility
const showModalDetail = ref(false);

// Populating rows on component mount
onMounted(() => {
    if (props.items && props.items.length > 0) {
        rows.value = props.items.map(item => ({
            id: item.id,
            fixkosten: item.fixkosten,
            varPlanverrechnungssatz: item.varPlanverrechnungssatz,
            istLeistung: item.istLeistung,
            verbrauchsabweichung: item.verbrauchsabweichung,
            istKosten: item.istKosten,
            sollKosten: item.sollKosten,
            beschaeftAbweichung: item.beschaeftAbweichung,
            istKostenVerechneteLeistung: item.istKostenVerechneteLeistung,
            gesamtabweichung: item.gesamtabweichung,
            neueSpalte: null,
        }));
    } else {
        console.warn("No initial data provided for 'props.items'.");
    }
});

async function addRow() {
    try {
        const newRow = {
            fixkosten: fixkosten.value,
            varPlanverrechnungssatz: varPlanverrechnungssatz.value,
            istLeistung: istLeistung.value,
            verbrauchsabweichung: verbrauchsabweichung.value,
            istKosten: istKosten.value,
            sollKosten: sollKosten.value,
            beschaeftAbweichung: beschaeftAbweichung.value,
            istKostenVerechneteLeistung: istKostenVerechneteLeistung.value,
            gesamtabweichung: gesamtabweichung.value,
        };

        try{
        newRow.sollKosten = calculateSK(newRow);
        newRow.verbrauchsabweichung = calculateVA(newRow);
        newRow.beschaeftAbweichung = calculateBA(newRow);
        newRow.gesamtabweichung = calculateGA(newRow);
            console.log(newRow);
        }catch(error){
            console.error('Error setting functions:', error)
        }
        

        const response = await axios.post('/abweichungsanalyse', newRow);
        
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
    rowsP.value = addRowFromExist();
}

async function deleteRow(id, index) {
    try {
        const response = await axios.delete(`/abweichungsanalyse/${id}`);
        
        if (response.data) {
            rows.value.splice(index, 1);  // Remove the row from the array
        }
    } catch (error) {
        console.error('Error deleting row:', error);
    }
    rowsP.value = addRowFromExist();
}

async function fetchRowsFromAbweichungsanalyse() {
    try {
        const response = await axios.get('/getAbweichungsrechnung');
        rowsP.value = response.data[0];
    } catch (error) {
        console.error('Error fetching rows:', error);
    }
}

function exportToPDF(name) {
    const element = document.getElementById('modalContent');
  const opt = {
    margin:       [0.5, 0.5],
    filename:     `${name}.pdf`,
    image:        { type: 'jpeg', quality: 0.98 },
    html2canvas:  { scale: 2 },
    jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
  };
  html2pdf().from(element).set(opt).save();
    }

async function addRowFromExist() {
    await fetchRowsFromAbweichungsanalyse();
}

async function addRowFromExistFromTabelle() {
    await fetchRowsFromTabelle();
    showModal.value = true; // Open modal to select the row
}

async function fetchRowsFromTabelle() {
    try {
        const response = await axios.get('/getAbweichungsrechnungTabelle');
        console.log(("response"));
        console.log((response.data[0]));
        rowsP2.value = response.data[0];
    } catch (error) {
        console.error('Error fetching rows:', error);
    }
}

function openDetailModal(row) {
      selectedRow.value = row; // Set the selected row for displaying details
      showModalDetail.value = true; // Open the modal
    }
// Utility functions to clear inputs
function clearInputs() {
    fixkosten.value = null;
    varPlanverrechnungssatz.value = null;
    istLeistung.value = null;
    istKosten.value = null;
    istKostenVerechneteLeistung.value = null;
}

// Calculation functions for each type of cost
function calculateBA(row) {
    let wert = 0;
    if (row.sollKosten && row.istKostenVerechneteLeistung) {
        wert = row.sollKosten - row.istKostenVerechneteLeistung;
    }
    row.beschaeftAbweichung = wert;
    return wert;
}

function applySelectedRow() {
    if (selectedRow.value) {
        varPlanverrechnungssatz.value = selectedRow.value.varPlanverrechnungssatz;
        istLeistung.value = selectedRow.value.IstLeistung;
        istKosten.value = selectedRow.value.SummeIstKosten;
        showModal.value = false;
    } else {
        alert("Please select a row to apply.");
    }
}

function calculateGA(row) {
    let wert = 0;
    if (row.beschaeftAbweichung && row.verbrauchsabweichung) {
        wert = row.beschaeftAbweichung - row.verbrauchsabweichung;
    }
    row.gesamtabweichung = wert;
    return wert;
}

function calculateSK(row){
    let wert = 0;
    if(row.fixkosten && row.varPlanverrechnungssatz && row.istLeistung) {
        wert = row.fixkosten + (row.varPlanverrechnungssatz * row.istLeistung);
    }
    row.sollKosten = wert;
    return wert;
}

function calculateVA(row){
    let wert = 0;
    if(row.istKosten && row.sollKosten) {
        wert = row.istKosten - row.sollKosten;
    }
    row.verbrauchsabweichung = wert;
    return wert;
}

rowsP.value = addRowFromExist();
</script>

<template>
    <div>
      <Head title="Abweichungsanalyse">
      </Head>
  
      <AuthenticatedLayout :hideNavbar="true" >
          <template #header>
              <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Abweichungsanalyse</h2>
          </template>

          <div class="py-12 m-lg-4">
            <div class="input-area"
                style="display: grid; grid-template-columns: 3fr 2fr; grid-gap: 20px; align-items: center; justify-content: center; justify-items: center; max-width: 600px; margin: 0 auto;">

                <!-- Label and Date Picker in Grid -->
                <label for="input1" style="justify-self: start;">Fixkosten:
                    <span id="tooltip-aufwand" class="tooltip-container">
                        <sup class="information">i</sup>
                        <span class="tooltip-text">Definition für den Aufwand</span>
                    </span>
                </label>
                <input type="number" v-model="fixkosten" id="input1" style="max-width: 250px;" />

                <!-- variabler Planverrechnungssatz Input -->
                <label for="input2" style="justify-self: start;">variabler Planverrechnungssatz:  
                    <span id="tooltip-aufwand" class="tooltip-container">
                        <sup class="information">i</sup>
                        <span class="tooltip-text">Definition für den Aufwand</span>
                    </span>
                </label>
                <input type="number" v-model="varPlanverrechnungssatz" id="input2" style="max-width: 250px;" />
                
                <!-- IstLeistung Input -->
                <label for="input3" style="justify-self: start;">Ist Leistung:  
                    <span id="tooltip-aufwand" class="tooltip-container">
                        <sup class="information">i</sup>
                        <span class="tooltip-text">Definition für den Aufwand</span>
                    </span>
                </label>
                <input type="number" v-model="istLeistung" id="input3" style="max-width: 250px;" />

                <!-- IstKosten Input -->
                <label for="input4" style="justify-self: start;">Ist Kosten:  
                    <span id="tooltip-aufwand" class="tooltip-container">
                        <sup class="information">i</sup>
                        <span class="tooltip-text">Definition für den Aufwand</span>
                    </span>
                </label>
                <input type="number" v-model="istKosten" id="input4" style="max-width: 250px;" />

                <!-- istKostenVerrechneteLeistung Input -->
                <label for="input1" style="justify-self: start;">IstKosten verrechnete Leistung:  
                    <span id="tooltip-aufwand" class="tooltip-container">
                        <sup class="information">i</sup>
                        <span class="tooltip-text">Definition für den Aufwand</span>
                    </span>
                </label>
                <input type="number" v-model="istKostenVerechneteLeistung" id="input6" style="max-width: 250px;" />

                <div></div>
                <div>
                <button class="button bg-primary" style="justify-self: start; max-width: 150px;" @click="addRow">Berechnen</button>
                <button class="button bg-primary" style="justify-self: end;" @click="addRowFromExistFromTabelle">Zeile hinzufügen</button></div>
                <div></div>
            </div>

            <!-- Display the Results in the Table -->
            <table class="table">
                <thead>
                    <tr>
            <th class="bg-success">SollKosten
                <span id="tooltip-sollKosten" class="tooltip-container">
                    <sup class="information">i</sup>
                    <span class="tooltip-text">SollKosten: Fixkosten + variabler Planverrechnungssatz * IstLeistung</span>
                </span>
            </th>
            <th class="bg-warning">Verbrauchsabweichung
                <span id="tooltip-verbrauchsabweichung" class="tooltip-container">
                    <sup class="information">i</sup>
                    <span class="tooltip-text">Verbrauchsabweichung: IstKosten - SollKosten</span>
                </span>
            </th>
            <th>Beschäftigungsabweichung
                <span id="tooltip-beschaeftAbweichung" class="tooltip-container">
                    <sup class="information">i</sup>
                    <span class="tooltip-text">Beschäftigungsabweichung: SollKosten - IstKosten verrechnete Leistung</span>
                </span>
            </th>
            <th>Gesamtabweichung
                <span id="tooltip-gesamtabweichung" class="tooltip-container">
                    <sup class="information">i</sup>
                    <span class="tooltip-text">Gesamtabweichung: Beschäftigungsabweichung - Verbrauchsabweichung</span>
                </span>
            </th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index) in rowsP" :key="index">
                        <td>{{ row.sollKosten }}</td>
                        <td>{{ row.verbrauchsabweichung }}</td>
                        <td>{{ row.beschaeftAbweichung }}</td>
                        <td>{{ row.gesamtabweichung }}</td>
                        <td>
                            <button class="button bg-danger" @click="deleteRow(row.id, index)">löschen</button>
                            <button class="button bg-info" @click="openDetailModal(row)">Details</button>
                        </td>
                    </tr>
                </tbody>
            </table>
          </div>
                  <!-- Modal Window for Adding a Row -->
        <div v-if="showModal" class="modal-overlay">
          <div class="modal-content">
            <h3>Wählen Sie eine Zeile aus:</h3>
            <table class="table">
              <thead>
                <tr>
                  <th>Auswahl</th>
                  <th>verrechneteLeistungGesamt</th>
                  <th>varPlanverrechnungssatz</th>
                  <th>gesPlanverrechnungssatz</th>
                  <th>verrechneteLeistungIst</th>
                  <th>abweichung</th>
                  <th>IstKosten</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(row, index) in rowsP2" :key="index">
                  <td><input type="radio" :value="row" v-model="selectedRow" /></td>
                  <td>{{ row?.verrechneteLeistungGesamt}}</td>
                  <td>{{ row?.varPlanverrechnungssatz}}</td>
                  <td>{{ row?.gesPlanverrechnungssatz}}</td>
                  <td>{{ row?.verrechneteLeistungIst}}</td>
                  <td>{{ row.abweichung }}</td>
                  <td>{{ row?.IstKostensatz}}</td>
                </tr>
              </tbody>
            </table>
            <button @click="applySelectedRow">Anweden</button>
            <button @click="showModal = false">Schließen</button>
          </div>
        </div>

                          <!-- Modal Window for Row Details -->
                          <div v-if="showModalDetail" class="modal-overlay">
          <div class="modal-content-details" id="modalContent">
            <h3>Details für:</h3>
            <p><strong>Abweichungsanalyse</strong> {{ selectedRow?.kurzPreisUG || '' }}</p>

            <br>
            <strong>SollKosten:</strong>                    
            <p> SollKosten = FixKosten + variabler Planverrechnungssatz × Ist Leistung</p>
            <p> SollKosten = {{ selectedRow?.fixkosten }} + {{ selectedRow?.varPlanverrechnungssatz }} × {{ selectedRow?.istLeistung }}</p>
            <p> <u>SollKosten = {{ selectedRow.sollKosten }} </u></p>
            <br> 
            <strong>Verbrauchsabweichung :</strong>
            <p> Verbrauchsabweichung  = Ist Kosten – Soll Kosten </p>
            <p> Verbrauchsabweichung  = {{ selectedRow?.istKosten }} / {{ selectedRow?.sollKosten }}</p>
            <p><u> Verbrauchsabweichung  = {{ selectedRow?.verbrauchsabweichung }}</u></p>
            <br> 
            <p><strong>Beschäftigungsabweichung :</strong> </p>
            <p> Beschäftigungsabweichung  = Soll Kosten – Ist Kosten verrechnete Leistung</p>
            <p> Beschäftigungsabweichung  = {{ selectedRow?.sollKosten }} – {{ selectedRow?.istKostenVerechneteLeistung }}</p>
            <p><u> Beschäftigungsabweichung  = {{ selectedRow?.beschaeftAbweichung }}</u></p>
            <br> 
            <p><strong>Gesamtabweichung 	:</strong> </p>
            <p> Gesamtabweichung  = Beschäftigungsabweichung – Verbrauchsabweichung </p>
            <p> Gesamtabweichung  = {{ selectedRow?.beschaeftAbweichung }} – {{ selectedRow?.verbrauchsabweichung }}</p>
            <p><u> Gesamtabweichung 	= {{ selectedRow?.gesamtabweichung }}</u></p>
            <br> 
        <div>
            <button @click="exportToPDF(`Abweichungsanalyse_${selectedRow.id}`)">Als PDF exportieren</button>
            <div></div>
            <button @click="showModalDetail = false">Schließen</button>
        </div>
          </div>
        </div>
      </AuthenticatedLayout>
    </div>
</template>


<style>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0); /* Black background with opacity */
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background-color: rgb(141, 141, 141);
  padding: 20px;
  border-radius: 10px;
  width: calc(100vw - 2 * 200px);   /* Set a fixed width for the modal */
  max-height: 80%; /* Set a maximum height and enable scrolling if needed */
  overflow-y: auto; /* Enable vertical scrolling if content overflows */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add a box shadow for a popup effect */
}
/* Styles for accordion button, border, and icons */
.accordion-button {
  padding: var(--accordion-button-padding-y) var(--accordion-button-padding-x);
  color: var(--accordion-button-color);
  background-color: var(--accordion-button-bg);
  border: var(--accordion-border-width) solid var(--accordion-border-color);
  border-radius: var(--accordion-border-radius);
  transition: var(--accordion-transition);
}

.accordion-collapse.collapse.show {
    display: block !important;
    visibility: visible !important;
}

.accordion-button:focus {
  border-color: var(--accordion-button-focus-border-color);
  box-shadow: var(--accordion-button-focus-box-shadow);
}

.accordion-button:not(.collapsed) {
  background-color: var(--accordion-button-active-bg);
  color: var(--accordion-button-active-color);
}

.accordion-button::after {
  width: var(--accordion-icon-width);
  height: var(--accordion-icon-width);
  background-image: var(--accordion-button-icon);
  background-repeat: no-repeat;
  background-size: 100%;
  transform: var(--accordion-icon-transform);
  transition: var(--accordion-icon-transition);
}

.accordion-button:not(.collapsed)::after {
  background-image: var(--accordion-button-active-icon);
  transform: none;
}

.accordion-body {
  padding: var(--accordion-body-padding-y) var(--accordion-body-padding-x);
}

.accordion-collapse {
  border-radius: var(--accordion-inner-border-radius);
}

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

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
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

//Eingeben
const varSummeKosten = ref(null);
const geplanteLeistung = ref(null);
const IstLeistung = ref(null);
const SummeIstKosten = ref(null);
const verrechneteLeistungGesamt = ref(null);
//Berechnen

const varPlanverrechnungssatz = ref(null);
const gesPlanverrechnungssatz = ref(null);
const verrechneteLeistungIst = ref(null);
const abweichung = ref(null);
const IstKostensatz = ref(null);

const selectedRow = ref(null); // To hold the selected row in the modal
const rows = ref([]);
const rowsP = ref([]);
const showModalDetail = ref(false);

onMounted(() => {
    rows.value = props.items.map(item => ({
        id: item.id,  // Ensure you have an ID field for deleting rows later
        varSummeKosten: item.varSummeKosten,
        geplanteLeistung: item.geplanteLeistung,
        IstLeistung: item.IstLeistung,
        SummeIstKosten: item.SummeIstKosten,
        verrechneteLeistungGesamt: item.verrechneteLeistungGesamt,
        varPlanverrechnungssatz: item.varPlanverrechnungssatz,
        gesPlanverrechnungssatz: item.gesPlanverrechnungssatz,
        verrechneteLeistungIst: item.verrechneteLeistungIst,
        abweichung: item.abweichung,
        IstKostensatz: item.IstKostensatz,
        neueSpalte: null,
    }));
});

async function addRow() {
    try {
        const newRow = {
            varSummeKosten: varSummeKosten.value, // Use month difference
            geplanteLeistung: geplanteLeistung.value,
            IstLeistung: IstLeistung.value,
            SummeIstKosten: SummeIstKosten.value,
            verrechneteLeistungGesamt: verrechneteLeistungGesamt.value,
            varPlanverrechnungssatz: varPlanverrechnungssatz.value,
            gesPlanverrechnungssatz: gesPlanverrechnungssatz.value,
            verrechneteLeistungIst: verrechneteLeistungIst.value,
            abweichung: abweichung.value,
            IstKostensatz: IstKostensatz.value,
        };

        try{
            newRow.varPlanverrechnungssatz = calculateVPRS(newRow);
            newRow.gesPlanverrechnungssatz = calculateGPRS(newRow);
            newRow.verrechneteLeistungIst = calculateVLI(newRow);
            newRow.abweichung = calculateA(newRow);
            newRow.IstKostensatz = calculateIKS(newRow);
            console.log(newRow);
        }catch(error){
            console.error('Error setting functions:', error)
        }
        

        const response = await axios.post('/abweichungsanalysetabelle', newRow);
        
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
    //rowsP.value = addRowFromExist();
}

async function deleteRow(id, index) {
    try {
        const response = await axios.delete(`/abweichungsanalysetabelle/${id}`);
        
        if (response.data) {
            rows.value.splice(index, 1); // Remove row from the array
        }
    } catch (error) {
        console.error('Error deleting row:', error);
    }
    rowsP.value = addRowFromExist();
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

async function fetchRowsFromAbweichungsanalyse() {
    try {
        const response = await axios.get('/getAbweichungsrechnungTabelle');
        rowsP.value = response.data[0];
    } catch (error) {
        console.error('Error fetching rows:', error);
    }
}

function clearInputs() {
    verrechneteLeistungGesamt.value = null;
    varSummeKosten.value = null;
    geplanteLeistung.value = null;
    IstLeistung.value = null;
    SummeIstKosten.value = null;
}

function calculateVPRS(row) {
    let wert = 0;
    if (row.varSummeKosten && row.geplanteLeistung) {
        wert = row.varSummeKosten / row.geplanteLeistung;
    }
    row.varPlanverrechnungssatz = wert;
    return wert;
}

function calculateGPRS(row) {
    let wert = 0;
    if (row.verrechneteLeistungGesamt && row.geplanteLeistung) {
        wert = row.verrechneteLeistungGesamt / row.geplanteLeistung;
    }
    row.gesPlanverrechnungssatz = wert;
    return wert;
}

function calculateVLI(row) {
    let wert = 0;
    if (row.IstLeistung && row.gesPlanverrechnungssatz) {
        wert = row.IstLeistung * row.gesPlanverrechnungssatz;
    }
    row.verrechneteLeistungIst = wert;
    return wert;
}

function calculateA(row) {
    let wert = 0;
    if (row.SummeIstKosten && row.verrechneteLeistungIst) {
        wert = row.SummeIstKosten - row.verrechneteLeistungIst;
    }
    row.abweichung = wert;
    return wert;
}

function calculateIKS(row) {
    let wert = 0;
    if (row.SummeIstKosten && row.IstLeistung) {
        wert = row.SummeIstKosten / row.IstLeistung;
    }
    row.IstKostensatz = wert;
    return wert;
}



function openDetailModal(row) {
      selectedRow.value = row; // Set the selected row for displaying details
      showModalDetail.value = true; // Open the modal
    }

function applySelectedRow() {
    if (selectedRow.value) {
        name.value = selectedRow.value.name;
        stueckZahl.value = selectedRow.value.stueckZahl;
        varKostenProStueck.value = selectedRow.value.varKostenProStueck;
        fixkosten.value = selectedRow.value.fixkosten;
        showModal.value = false; // Close modal
    } else {
        alert("Please select a row to apply.");
    }
}

rowsP.value = addRowFromExist();
</script>



<template>
    <div>
      <Head title="Abweichungsanalyse">
      </Head>
  
      <AuthenticatedLayout :hideNavbar="true">
          <template #header>
              <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Abweichungsanalyse Tabelle</h2>
          </template>
          <div class="py-12 m-lg-4">
            <div style="display: flex; justify-content: center;">
                 <img src='/images/klausur.png' style="max-width: 800px;">
            </div>
            <div class="input-area"
                style="display: grid; grid-template-columns: 3fr 2fr; grid-gap: 20px; align-items: center; justify-content: center; justify-items: center; max-width: 600px; margin: 0 auto;">
                <div>  
                </div>
                <div></div>
                <!-- Label and Date Picker in Grid -->
                <label for="input1" style="justify-self: start;">verrechneteLeistungGesamt:
                    <span id="tooltip-aufwand" class="tooltip-container">
                        <sup class="information">i</sup>
                        <span class="tooltip-text">Definition für den Aufwand</span>
                    </span>
                </label>
                <input type="number" v-model="verrechneteLeistungGesamt" id="input1" style="max-width: 250px;" />

                <!-- variabler Planverrechnungssatz Input -->
                <label for="input2" style="justify-self: start;">varSummeKosten:  
                    <span id="tooltip-aufwand" class="tooltip-container">
                        <sup class="information">i</sup>
                        <span class="tooltip-text">Definition für den Aufwand</span>
                    </span>
                </label>
                <input type="number" v-model="varSummeKosten" id="input2" style="max-width: 250px;" />
                
                <!-- IstLeistung Input -->
                <label for="input3" style="justify-self: start;">geplanteLeistung:  
                    <span id="tooltip-aufwand" class="tooltip-container">
                        <sup class="information">i</sup>
                        <span class="tooltip-text">Definition für den Aufwand</span>
                    </span>
                </label>
                <input type="number" v-model="geplanteLeistung" id="input3" style="max-width: 250px;" />

                <!-- istKostenVerrechneteLeistung Input -->
                <label for="input1" style="justify-self: start;">IstLeistung:  
                    <span id="tooltip-aufwand" class="tooltip-container">
                        <sup class="information">i</sup>
                        <span class="tooltip-text">Definition für den Aufwand</span>
                    </span>
                </label>
                <input type="number" v-model="IstLeistung" id="input6" style="max-width: 250px;" />

                <!-- istKostenVerrechneteLeistung Input -->
                <label for="input1" style="justify-self: start;">SummeIstKosten:  
                    <span id="tooltip-aufwand" class="tooltip-container">
                        <sup class="information">i</sup>
                        <span class="tooltip-text">Definition für den Aufwand</span>
                    </span>
                </label>
                <input type="number" v-model="SummeIstKosten" id="input6" style="max-width: 250px;" />

                <!-- Empty space to align button -->
                <div></div>
                <button class="button bg-primary" style="justify-self: start; max-width: 150px;" @click="addRow">Berechnen</button>
                <div></div>
            </div>
            <table class="table">
          <thead>
            <tr>
              <th class="bg-success">verrechneteLeistungGesamt</th>
              <th class="bg-warning">varPlanverrechnungssatz</th>
              <th>gesPlanverrechnungssatz</th>
              <th>verrechneteLeistungIst</th>
              <th>abweichung</th>
              <th>IstKostensatz</th>
              <th>Aktionen</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(row, index) in rowsP" :key="index">
              <td>{{ row.verrechneteLeistungGesamt }}</td>
              <td>{{ row.varPlanverrechnungssatz }}</td>
              <td>{{ row.gesPlanverrechnungssatz }}</td>
              <td>{{ row.verrechneteLeistungIst }}</td>
              <td>{{ row.abweichung }}</td>
              <td>{{ row.IstKostensatz }}</td>
              <td>
                <button class="button bg-info" @click="openDetailModal(row)">Details</button>
                <button class="button bg-danger" @click="deleteRow(row.id, index)">Löschen</button>
              </td>
            </tr>
          </tbody>
        </table>
          </div>
         <!-- Modal Window for Row Details -->
        <div v-if="showModalDetail" class="modal-overlay">
          <div class="modal-content-details" id="modalContent">
            <h3>Details für {{ selectedRow?.name || '' }}</h3>
            <p><strong>Abweichungsanalyse (Tabelle):</strong> {{ selectedRow?.kurzPreisUG || '' }}</p>

            <br>
            <strong>verrechneteLeistungGesamt:</strong>
                                 
            <p> verrechneteLeistungGesamt = Summe Kosten gesamt</p>
            <p> <u>verrechneteLeistungGesamt = {{ selectedRow.verrechneteLeistungGesamt }} </u></p>
            <p> <strong>Info:</strong> Hierbei besteht keine Rechnung. Es wird das Feld darüber übernommen.</p>
            <br> 
            <strong>varPlanverrechnungssatz:</strong>
            <p> varPlanverrechnungssatz = Summe variable Kosten / Geplante Leistung <sub>(Stk.)</sub> </p>
            <p> varPlanverrechnungssatz = {{ selectedRow?.varSummeKosten }} / {{ selectedRow?.geplanteLeistung }}</p>
            <p><u> varPlanverrechnungssatz = {{ selectedRow?.varPlanverrechnungssatz }}</u></p>
            <br> 
            <p><strong>gesPlanverrechnungssatz:</strong> {{ selectedRow?.langPreisUG || '' }}</p>
            <p> gesPlanverrechnungssatz = Summe Plankosten gesamt / Geplante Lestung <sub>(Stk.)</sub> </p>
            <p> gesPlanverrechnungssatz = {{ selectedRow?.verrechneteLeistungGesamt }} / {{ selectedRow?.geplanteLeistung }}</p>
            <p><u> gesPlanverrechnungssatz = {{ selectedRow?.gesPlanverrechnungssatz }}</u></p>
            <br> 
            <p><strong>verrechneteLeistungIstKosten	:</strong> {{ selectedRow?.langPreisUG || '' }}</p>
            <p> verrechneteLeistungIstKosten = IstLeistung <sub>(Stk.)</sub> × gesPlanverrechnungssatz </p>
            <p> verrechneteLeistungIstKosten = {{ selectedRow?.IstLeistung }} × {{ selectedRow?.gesPlanverrechnungssatz }}</p>
            <p><u> verrechneteLeistungIstKosten	= {{ selectedRow?.verrechneteLeistungIst }}</u></p>
            <br> 
            <p><strong>abweichung (Kostenstellenergebnis IstKosten):</strong> {{ selectedRow?.langPreisUG || '' }}</p>
            <p> abweichung = Summe Ist Kosten – verrechneteLeistungIstKosten </p>
            <p> abweichung = {{ selectedRow?.SummeIstKosten }} – {{ selectedRow?.verrechneteLeistungIst }}</p>
            <p><u> abweichung = {{ selectedRow?.abweichung }}</u></p>
            <br> 
            <p><strong>IstKostensatz:</strong> {{ selectedRow?.langPreisUG || '' }}</p>
            <p> IstKostensatz = Summe Ist Kosten / Ist Leistung <sub>(Stk.)</sub> </p>
            <p> IstKostensatz = {{ selectedRow?.SummeIstKosten }} / {{ selectedRow?.IstLeistung }}</p>
            <p><u> IstKostensatz = {{ selectedRow?.IstKostensatz }}</u></p>
            <br> 
        <div>
            <button @click="exportToPDF(`AbweichungsanalyseTabelle_${selectedRow.id}`)">Als PDF exportieren</button>
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
  width: 800px;   /* Set a fixed width for the modal */
  max-height: 80%; /* Set a maximum height and enable scrolling if needed */
  overflow-y: auto; /* Enable vertical scrolling if content overflows */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add a box shadow for a popup effect */
}

.modal-content-details {
  background-color: rgb(255, 255, 255);
  padding: 20px;
  border-radius: 10px;
  width: calc(100vw - 2 * 200px);   /* Set a fixed width for the modal */
  max-height: 80%; /* Set a maximum height and enable scrolling if needed */
  overflow-y: auto; /* Enable vertical scrolling if content overflows */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add a box shadow for a popup effect */
}

#modalContent * {
  color: #2c3e50; /* Custom text color for all text elements in the modal */
  font-family: Arial, sans-serif; /* Set a custom font family */
  line-height: 1.5; /* Improve readability */
}


.modal-content-details button {
  color: #000000; /* Custom color for modal text */
  outline-color: #000000;
  outline: auto;
  outline-offset: 3px;
}

.modal-content button {
  color: #000000; /* Custom color for modal text */
  outline-color: #000000;
  outline: auto;
  outline-offset: 3px;
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

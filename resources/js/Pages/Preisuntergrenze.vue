<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

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

//Input
const name = ref(null);
const stueckZahl = ref(null);
const varKostenProStueck = ref(null);
const fixkosten = ref(null);

//Ergebniss
const kurzPreisUG = ref(null);
const langPreisUG = ref(null);

const rows = ref([]);
const rowsP = ref([]);
const selectedRow = ref(null); // To hold the selected row in the modal
const showModal = ref(false);  // Controls the modal visibility

onMounted(() => {
    rows.value = props.items.map(item => ({
        id: item.id,
        name: item.name,
        stueckZahl: item.stueckZahl,
        varKostenProStueck: item.varKostenProStueck,
        fixkosten: item.fixkosten,
        kurzPreisUG: item.kurzPreisUG,
        langPreisUG: item.langPreisUG,
        neueSpalte: null,
    }));
});

async function addRow() {
    try {
        const newRow = {
            name: name.value,
            stueckZahl: stueckZahl.value,
            varKostenProStueck: varKostenProStueck.value,
            fixkosten: fixkosten.value,
            kurzPreisUG: kurzPreisUG.value,
            langPreisUG: langPreisUG.value,
        };

        try{
        newRow.kurzPreisUG = calculateKurz(newRow);
        newRow.langPreisUG = calculateLang(newRow);
        }catch(error){
            console.error('Error setting functions:', error)
        }

        const response = await axios.post('/preisuntergrenze', newRow);
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

async function fetchRowsFromDeckungsbeitrag() {
    try {
        const response = await axios.get('/getDeckungsbeitragsrechnungen');
        console.log(("response"));
        console.log((response));
    } catch (error) {
        console.error('Error fetching rows:', error);
    }
}

async function addRowFromExist() {
    showModal.value = true; // Open modal to select the row
    await fetchRowsFromDeckungsbeitrag();
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

async function deleteRow(id, index) {
    try {
        const response = await axios.delete(`/preisuntergrenze/${id}`);
        if (response.data) {
            rows.value.splice(index, 1); // Remove row from the array
        }
    } catch (error) {
        console.error('Error deleting row:', error);
    }
}

function clearInputs() {
    name.value = null;
    stueckZahl.value = null;
    varKostenProStueck.value = null;
    fixkosten.value = null;
}

function calculateKurz(row) {
    let wert = row.varKostenProStueck || 0;
    row.kurzPreisUG = wert;
    return wert;
}

function calculateLang(row) {
    let wert = 0;
    if (row.varKostenProStueck && row.fixkosten && row.stueckZahl) {
        wert = (row.fixkosten + row.varKostenProStueck * row.stueckZahl) / row.stueckZahl;
    }
    row.langPreisUG = wert;
    return wert;
}
</script>

<template>
    <div>
      <Head title="Preisuntergrenze">
    </Head>
      <AuthenticatedLayout>
          <template #header>
              <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Abweichungsanalyse</h2>
          </template>

          <div class="py-12 m-lg-4">
            <!-- Input Fields -->
            <div class="input-area"
                style="display: grid; grid-template-columns: 3fr 2fr; grid-gap: 20px; align-items: center; justify-content: center; justify-items: center; max-width: 600px; margin: 0 auto;">
                <!-- Name Input -->
                <label for="input1" style="justify-self: start;">Bezeichnung:</label>
                <input type="text" v-model="name" id="input1" style="max-width: 250px;" />

                <!-- Stückanzahl Input -->
                <label for="input3" style="justify-self: start;">Stückanzahl:</label>
                <input type="number" v-model="stueckZahl" id="input3" style="max-width: 250px;" />

                <!-- Variable Kosten pro Stück Input -->
                <label for="input4" style="justify-self: start;">variable Kosten pro Stück:</label>
                <input type="number" v-model="varKostenProStueck" id="input4" style="max-width: 250px;" />

                <!-- Fixkosten Input -->
                <label for="input1" style="justify-self: start;">Fixkosten:</label>
                <input type="number" v-model="fixkosten" id="input6" style="max-width: 250px;" />

                <!-- Buttons -->
                <button class="button bg-primary" style="justify-self: start;" @click="addRow">Berechnen</button>
                <button class="button bg-primary" style="justify-self: end;" @click="addRowFromExist">Zeile hinzufügen</button>
            </div>

<!-- Modal Window -->
<div v-if="showModal" class="modal-overlay">
      <div class="modal-content">
        <h3>Select a Row</h3>
        <table class="table">
          <thead>
            <tr>
              <th>Select</th>
              <th>Name</th>
              <th>Stückzahl</th>
              <th>VarKosten</th>
              <th>Fixkosten</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(row, index) in rows" :key="index">
              <td><input type="radio" :value="row" v-model="selectedRow" /></td>
              <td>{{ row.name }}</td>
              <td>{{ row.stueckZahl }}</td>
              <td>{{ row.varKostenProStueck }}</td>
              <td>{{ row.fixkosten }}</td>
            </tr>
          </tbody>
        </table>
        <button @click="applySelectedRow">Apply</button>
        <button @click="showModal = false">Close</button>
      </div>
    </div>
            
            <table class="table">
    <thead>
        <tr>
            <th class="bg-success">Bezeichnung
                <span id="tooltip-sollKosten" class="tooltip-container">
                    <sup class="information">i</sup>
                    <span class="tooltip-text">SollKosten: Fixkosten + variabler Planverrechnungssatz * IstLeistung</span>
                </span>
            </th>
            <th class="bg-warning">kurzfristige Untergrenze
                <span id="tooltip-verbrauchsabweichung" class="tooltip-container">
                    <sup class="information">i</sup>
                    <span class="tooltip-text">Verbrauchsabweichung: IstKosten - SollKosten</span>
                </span>
            </th>
            <th>langfristige Untergrenze
                <span id="tooltip-beschaeftAbweichung" class="tooltip-container">
                    <sup class="information">i</sup>
                    <span class="tooltip-text">Beschäftigungsabweichung: SollKosten - IstKosten verrechnete Leistung</span>
                </span>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="(row, index) in rows" :key="index">
            <td>{{ row.name }}</td>
            <td>{{ row.kurzPreisUG }}</td>
            <td>{{ row.langPreisUG }}</td>
            <td><button class="button bg-danger" @click="deleteRow(row.id, index)">löschen</button></td>
            <td>
                <div class="accordion" :id="'accordionExample' + index">
                    <div class="accordion-item">
                        <h2 class="accordion-header" :id="'heading' + index">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" :data-bs-target="'#collapse' + index" aria-expanded="true" :aria-controls="'collapse' + index">
                                Rechnung {{ index + 1 }}
                            </button>
                        </h2>
                        <div :id="'collapse' + index" class="accordion-collapse collapse" :aria-labelledby="'heading' + index" :data-bs-parent="'#accordionExample' + index">
                            <div class="accordion-body">
                                <br>
                                <strong>kurzfristige Preisuntergrenze für {{ row.name }}:</strong>
                                 
                                <p> kurzfristige Preisuntergrenze = ( Verkaufspreis pro Stück₍<sub>{{ row.name }}</sub>₎ – Variable Kosten pro Stück₍<sub>{{ row.name }}</sub>₎ ) × Stückzahl₍<sub>{{ row.name }}</sub>₎</p>
                                <!-- <p> Deckungsbeitrag = {{ row.preisProStueck }} – {{ row.varKostenProStueck }} × {{ row.stueckZahl }}</p>-->
                                <p> kurzfristige Preisuntergrenze = {{ row.kurzPreisUG }} </p>
                                <br> 
                                <strong>langfristige Preisuntergrenze für {{ row.name }}:</strong>
                                <p> langfristige Preisuntergrenze = Deckungsbeitrag₍<sub>{{ row.name }}</sub>₎ – Fixkosten₍<sub>{{ row.name }}</sub>₎</p>
                                <p> langfristige Preisuntergrenze = {{ row.stueckZahl }} – {{ row.stueckZahl }}</p>
                                <p> langfristige Preisuntergrenze = {{ row.langPreisUG }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
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
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(117, 117, 117, 0.6); /* Black background with opacity */
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background-color: rgb(117, 117, 117);
  padding: 20px;
  border-radius: 10px;
  width: 600px;   /* Set a fixed width for the modal */
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

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
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
const showModalDetail = ref(false);

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
        console.log((response.data[0]));
        rowsP.value = response.data[0];
    } catch (error) {
        console.error('Error fetching rows:', error);
    }
}

async function addRowFromExist() {
    await fetchRowsFromDeckungsbeitrag();
    showModal.value = true; // Open modal to select the row
}

function openDetailModal(row) {
      selectedRow.value = row; // Set the selected row for displaying details
      showModalDetail.value = true; // Open the modal
    }

function exportToPDF() {
    const element = document.getElementById('modalContent');
  const opt = {
    margin:       1,
    filename:     'Modal_Details.pdf',
    image:        { type: 'jpeg', quality: 0.98 },
    html2canvas:  { scale: 2 },
    jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
  };
  html2pdf().from(element).set(opt).save();
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
      <Head title="Preisuntergrenze"></Head>
      <AuthenticatedLayout>
        <template #header>
          <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Abweichungsanalyse</h2>
        </template>
  
        <div class="py-12 m-lg-4">
          <!-- Input Fields -->
          <div class="input-area"
            style="display: grid; grid-template-columns: 3fr 2fr; grid-gap: 20px; align-items: center; justify-content: center; justify-items: center; max-width: 600px; margin: 0 auto;">
            <label for="input1" style="justify-self: start;">Bezeichnung:</label>
            <input type="text" v-model="name" id="input1" style="max-width: 250px;" />
  
            <label for="input3" style="justify-self: start;">Stückanzahl:</label>
            <input type="number" v-model="stueckZahl" id="input3" style="max-width: 250px;" />
  
            <label for="input4" style="justify-self: start;">Variable Kosten pro Stück:</label>
            <input type="number" v-model="varKostenProStueck" id="input4" style="max-width: 250px;" />
  
            <label for="input1" style="justify-self: start;">Fixkosten:</label>
            <input type="number" v-model="fixkosten" id="input6" style="max-width: 250px;" />
  
            <button class="button bg-primary" style="justify-self: start;" @click="addRow">Berechnen</button>
            <button class="button bg-primary" style="justify-self: end;" @click="addRowFromExist">Zeile hinzufügen</button>
          </div>
  
          <!-- Table with Rows -->
          <table class="table">
            <thead>
              <tr>
                <th class="bg-success">Bezeichnung</th>
                <th class="bg-warning">kurzfristige Untergrenze</th>
                <th>langfristige Untergrenze</th>
                <th>Aktionen</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(row, index) in rows" :key="index">
                <!-- Main Row Content -->
                <td>{{ row?.name || '' }}</td>
                <td>{{ row?.kurzPreisUG || '' }}</td>
                <td>{{ row?.langPreisUG || '' }}</td>
                <td>
                  <!-- Button to open the modal with row details -->
                  <button class="button bg-info" @click="openDetailModal(row)">Details</button>
                  <button class="button bg-danger" @click.stop="deleteRow(row.id, index)">Löschen</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
  
        <!-- Modal Window for Row Details -->
        <div v-if="showModalDetail" class="modal-overlay">
          <div class="modal-content-details" id="modalContent">
            <h3>Details für {{ selectedRow?.name || '' }}</h3>
            <p><strong>kurzfristige Preisuntergrenze:</strong> {{ selectedRow?.kurzPreisUG || '' }}</p>

            <br>
            <strong>kurzfristige Preisuntergrenze für {{ selectedRow?.name }}:</strong>
                                 
            <p> kurzfristige Preisuntergrenze = ( Verkaufspreis pro Stück₍<sub>{{ selectedRow?.name }}</sub>₎ – Variable Kosten pro Stück₍<sub>{{ selectedRow?.name }}</sub>₎ ) × Stückzahl₍<sub>{{ selectedRow?.name }}</sub>₎</p>
            <!-- <p> Deckungsbeitrag = {{ row.preisProStueck }} – {{ row.varKostenProStueck }} × {{ row.stueckZahl }}</p>-->
             <p> kurzfristige Preisuntergrenze = {{ selectedRow?.kurzPreisUG }} </p>
            <br> 
            <strong>langfristige Preisuntergrenze für {{ selectedRow?.name }}:</strong>
            <p> langfristige Preisuntergrenze = Deckungsbeitrag₍<sub>{{ selectedRow?.name }}</sub>₎ – Fixkosten₍<sub>{{ selectedRow?.name }}</sub>₎</p>
            <p> langfristige Preisuntergrenze = {{ selectedRow?.stueckZahl }} – {{ selectedRow?.stueckZahl }}</p>
            <p> langfristige Preisuntergrenze = {{ selectedRow?.langPreisUG }}</p>
            
            <p><strong>langfristige Preisuntergrenze:</strong> {{ selectedRow?.langPreisUG || '' }}</p>
        <div>
            <button @click="exportToPDF">Export as PDF</button>
            <div></div>
            <button @click="showModalDetail = false">Close</button>
        </div>
          </div>
        </div>
  
        <!-- Modal Window for Adding a Row -->
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
                <tr v-for="(row, index) in rowsP" :key="index">
                  <td><input type="radio" :value="row" v-model="selectedRow" /></td>
                  <td>{{ row?.name || '' }}</td>
                  <td>{{ row?.stueckZahl || '' }}</td>
                  <td>{{ row?.varKostenProStueck || '' }}</td>
                  <td>{{ row?.fixkosten || '' }}</td>
                </tr>
              </tbody>
            </table>
            <button @click="applySelectedRow">Apply</button>
            <button @click="showModal = false">Close</button>
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
  width: 600px;   /* Set a fixed width for the modal */
  max-height: 80%; /* Set a maximum height and enable scrolling if needed */
  overflow-y: auto; /* Enable vertical scrolling if content overflows */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add a box shadow for a popup effect */
}

.modal-content-details {
  background-color: rgb(255, 255, 255);
  padding: 20px;
  border-radius: 10px;
  width: 600px;   /* Set a fixed width for the modal */
  max-height: 80%; /* Set a maximum height and enable scrolling if needed */
  overflow-y: auto; /* Enable vertical scrolling if content overflows */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add a box shadow for a popup effect */
}

.modal-content-details p {
  color: #000000; /* Custom color for modal text */
}

.modal-content-details h3 {
  color: #000000; /* Custom color for modal text */
}

.modal-content-details button {
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

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
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

onMounted(() => {
    rows.value = props.items.map(item => ({
        id: item.id,  // Ensure you have an ID field for deleting rows later
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
});

async function addRow() {
    try {
        const newRow = {
            fixkosten: fixkosten.value, // Use month difference
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
}

async function deleteRow(id, index) {
    try {
        const response = await axios.delete(`/abweichungsanalyse/${id}`);
        
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

function calculateBA(row) {
    let wert = 0;
    if (row.sollKosten && row.istKostenVerechneteLeistung) {
        wert = row.sollKosten - row.istKostenVerechneteLeistung;
    }
    row.beschaeftAbweichung = wert;
    return wert;
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
    console.log("fixKosten"+row.fixkosten);
    console.log("varPlanverrechnungssatz"+row.varPlanverrechnungssatz);
    console.log("istLeistung"+row.istLeistung);
    if(row.fixkosten && row.varPlanverrechnungssatz && row.istLeistung)
    {
        wert = row.fixkosten + (row.varPlanverrechnungssatz * row.istLeistung);
    }
    console.log("wert:"+ wert)
    row.sollKosten = wert;
    return wert;
}

function calculateVA(row){
    let wert = 0;
    if(row.istKosten && row.sollKosten)
    {
        wert = row.istKosten - row.sollKosten;
    }
    row.verbrauchsabweichung = wert;
    return wert;
}
</script>



<template>
    <div>
      <Head title="Abweichungsanalyse">
      </Head>
  
      <AuthenticatedLayout>
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

                <!-- Empty space to align button -->
                <div></div>
                <button class="button bg-primary" style="justify-self: start; max-width: 150px;" @click="addRow">Berechnen</button>
            </div>
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
        <tr v-for="(row, index) in rows" :key="index">
            <td>{{ row.sollKosten }}</td>
            <td>{{ row.verbrauchsabweichung }}</td>
            <td>{{ row.beschaeftAbweichung }}</td>
            <td>{{ row.gesamtabweichung }}</td>
            <td>
                <button class="button bg-danger" @click="deleteRow(row.id, index)">löschen</button>
            </td>
        </tr>
        <!-- Collapsible details row immediately after each data row -->
        <tr v-for="(row, index) in rows" :key="'collapse-row-' + index">
            <td colspan="5">
                <div class="accordion" :id="'accordionExample-' + index">
                    <div class="accordion-item">
                        <h2 class="accordion-header" :id="'heading-' + index">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" :data-bs-target="'#collapse-' + index" aria-expanded="false" :aria-controls="'collapse-' + index">
                                Details for row {{ index + 1 }}
                            </button>
                        </h2>
                        <div :id="'collapse-' + index" class="accordion-collapse collapse" :aria-labelledby="'heading-' + index">
                            <div class="accordion-body">
                                <strong>Daten:</strong> Idee ist das wir die Rechnung hier Abbilden. Sieht glaube ich einfach clean aus. Also ich mach das
                                <ul>
                                    <li>SollKosten: {{ row.sollKosten }}</li>
                                    <li>Verbrauchsabweichung: {{ row.verbrauchsabweichung }}</li>
                                    <li>Beschäftigungsabweichung: {{ row.beschaeftAbweichung }}</li>
                                    <li>Gesamtabweichung: {{ row.gesamtabweichung }}</li>
                                </ul>
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

</template>

<style>

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

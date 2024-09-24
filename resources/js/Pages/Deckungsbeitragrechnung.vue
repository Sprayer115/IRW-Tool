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

//Input
const name = ref(null);
const preisProStueck = ref(null);
const stueckZahl = ref(null);
const varKostenProStueck = ref(null);
const fixkosten = ref(null);

//Ergebniss
const umsatz = ref(null);
const deckungsBeitrag = ref(null);
const gewinn = ref(null);

const rows = ref([]);

onMounted(() => {
    rows.value = props.items.map(item => ({
        id: item.id,  // Ensure you have an ID field for deleting rows later
        name: item.name,
        preisProStueck: item.preisProStueck,
        stueckZahl: item.stueckZahl,
        varKostenProStueck: item.varKostenProStueck,
        fixkosten: item.fixkosten,
        umsatz: item.umsatz,
        deckungsBeitrag: item.deckungsBeitrag,
        gewinn: item.gewinn,
        neueSpalte: null,
    }));
});

async function addRow() {
    try {
        const newRow = {
            name: name.value, // Use month difference
            preisProStueck: preisProStueck.value,
            stueckZahl: stueckZahl.value,
            varKostenProStueck: varKostenProStueck.value,
            fixkosten: fixkosten.value,
            umsatz: umsatz.value,
            deckungsBeitrag: deckungsBeitrag.value,
            gewinn: gewinn.value
        };

        try{
            newRow.deckungsBeitrag = calculateDB(newRow);
            newRow.gewinn = calculateGewinn(newRow);
            console.log(newRow);
        }catch(error){
            console.error('Error setting functions:', error)
        }
        

        const response = await axios.post('/deckungsbeitrag', newRow);
        
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
        const response = await axios.delete(`/deckungsbeitrag/${id}`);
        
        if (response.data) {
            rows.value.splice(index, 1); // Remove row from the array
        }
    } catch (error) {
        console.error('Error deleting row:', error);
    }
}

function clearInputs() {
    name.value = null;
    preisProStueck.value = null;
    stueckZahl.value = null;
    varKostenProStueck.value = null;
    fixkosten.value = null;
}

function calculateUmsatz(row) {
    let wert = 0;
    if (row.deckungsBeitrag && row.fixkosten) {
        wert = row.deckungsBeitrag - row.fixkosten;
    }
    row.gewinn = wert;
    return wert;
}

function calculateDB(row){
    let wert = 0;
    if(row.preisProStueck && row.varKostenProStueck && row.stueckZahl)
    {
        wert = (row.preisProStueck - row.varKostenProStueck) * row.stueckZahl;
    }
    row.deckungsBeitrag = wert;
    return wert;
}

function calculateGewinn(row){
    let wert = 0;
    if(row.deckungsBeitrag && row.fixkosten)
    {
        wert = row.istKosten - row.sollKosten;
    }
    row.verbrauchsabweichung = wert;
    return wert;
}
</script>



<template>
    <div>
      <Head title="Deckungsbeitragrechnung">
      </Head>
  
      <AuthenticatedLayout>
          <template #header>
              <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Abweichungsanalyse</h2>
          </template>
          <div class="py-12 m-lg-4">
            <div class="input-area"
                style="display: grid; grid-template-columns: 3fr 2fr; grid-gap: 20px; align-items: center; justify-content: center; justify-items: center; max-width: 600px; margin: 0 auto;">

                <!-- name -->
                <label for="input1" style="justify-self: start;">Bezeichnung:
                    <span id="tooltip-aufwand" class="tooltip-container">
                        <sup class="information">i</sup>
                        <span class="tooltip-text">Definition für den Aufwand</span>
                    </span>
                </label>
                <input type="text" v-model="name" id="input1" style="max-width: 250px;" />

                <!-- preisProStueck Input -->
                <label for="input2" style="justify-self: start;">Preis pro Stück:  
                    <span id="tooltip-aufwand" class="tooltip-container">
                        <sup class="information">i</sup>
                        <span class="tooltip-text">Definition für den Aufwand</span>
                    </span>
                </label>
                <input type="number" v-model="preisProStueck" id="input2" style="max-width: 250px;" />
                
                <!-- stueckZahl Input -->
                <label for="input3" style="justify-self: start;">Stückanzahl:  
                    <span id="tooltip-aufwand" class="tooltip-container">
                        <sup class="information">i</sup>
                        <span class="tooltip-text">Definition für den Aufwand</span>
                    </span>
                </label>
                <input type="number" v-model="stueckZahl" id="input3" style="max-width: 250px;" />

                <!-- varKostenProStueck Input -->
                <label for="input4" style="justify-self: start;">variable Kosten pro Stück:  
                    <span id="tooltip-aufwand" class="tooltip-container">
                        <sup class="information">i</sup>
                        <span class="tooltip-text">Definition für den Aufwand</span>
                    </span>
                </label>
                <input type="number" v-model="varKostenProStueck" id="input4" style="max-width: 250px;" />

                <!-- Fixkosten Input -->
                <label for="input1" style="justify-self: start;">Fixkosten:  
                    <span id="tooltip-aufwand" class="tooltip-container">
                        <sup class="information">i</sup>
                        <span class="tooltip-text">Definition für den Aufwand</span>
                    </span>
                </label>
                <input type="number" v-model="fixkosten" id="input6" style="max-width: 250px;" />

                <!-- Empty space to align button -->
                <div></div>
                <button class="button bg-primary" style="justify-self: start; max-width: 150px;" @click="addRow">Berechnen</button>
            </div>
              <table class="table">
                  <thead>
                      <tr>
                            <th class="bg-success">Umsatz
                                <span id="tooltip-sollKosten" class="tooltip-container">
                        <sup class="information">i</sup>
                        <span class="tooltip-text">SollKosten: Fixkosten + variabler Planverrechnungssatz * IstLeistung</span>
                    </span>
                            </th>
                            <th class = "bg-warning">Deckungsbeitrag
                                <span id="tooltip-verbrauchsabweichung" class="tooltip-container">
                        <sup class="information">i</sup>
                        <span class="tooltip-text">Verbrauchsabweichung: IstKosten - SollKosten</span>
                    </span>
                            </th>
                            <th>Gewinn
                                <span id="tooltip-beschaeftAbweichung" class="tooltip-container">
                        <sup class="information">i</sup>
                        <span class="tooltip-text">Beschäftigungsabweichung: SollKosten - IstKosten verrechnete Leistung</span>
                    </span>
                            </th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr v-for="(row, index) in rows" :key="index">
                          <td>{{ row.umsatz }}</td>
                          <td>{{ row.deckungsBeitrag }}</td>
                          <td>{{ row.gewinn }}</td>
                          <td><button class = "button bg-danger" @click="deleteRow(row.id, index)">löschen</button></td>
                          <td>
                            <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Test
                                </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <strong>This is the first item's accordion body.</strong> It is shown by default until the collapse plugin adds the appropriate classes to handle the animation.
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
/* Styles for accordion button, border, and icons */
.accordion-button {
  padding: var(--accordion-button-padding-y) var(--accordion-button-padding-x);
  color: var(--accordion-button-color);
  background-color: var(--accordion-button-bg);
  border: var(--accordion-border-width) solid var(--accordion-border-color);
  border-radius: var(--accordion-border-radius);
  transition: var(--accordion-transition);
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

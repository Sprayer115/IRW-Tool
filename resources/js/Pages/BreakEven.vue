<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref, computed, onMounted } from 'vue';
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

//Berechnungen
const stueckkosten = ref(0);
const deckungsBeitragProStueck = ref(0);
const breakEvenMenge = ref(0);
const breakEvenUmsatz = ref(0);

const rows = ref([]);

const selectedRow = ref(null); // To hold the selected row in the modal
const showModalDetail = ref(false);

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
        deckungsBeitragProStueck: item.deckungsBeitragProStueck,
        breakEvenMenge: item.breakEvenMenge,
        breakEvenUmsatz: item.breakEvenUmsatz,
        stueckkosten: item.stueckkosten,
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
            deckungsBeitragProStueck: deckungsBeitragProStueck.value,
            breakEvenMenge: breakEvenMenge.value,
            breakEvenUmsatz: breakEvenUmsatz.value,
            stueckkosten: stueckkosten.value
        };

        try{
            newRow.KTZrechnung = calculateKTZ(newRow);
            newRow.deckungsBeitrag = calculateDB(newRow);
            newRow.opErgebnis = calculateOP(newRow);
            newRow.stueckkosten = calculateSK(newRow);
            newRow.deckungsBeitragProStueck = calculateDPS(newRow);
            newRow.breakEvenMenge = calculateBEM(newRow);
            newRow.breakEvenUmsatz = calculateBEU(newRow);
            console.log(newRow);
        }catch(error){
            console.error('Error setting functions:', error)
        }
        

        const response = await axios.post('/break-even', newRow);
        
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
        const response = await axios.delete(`/break-even/${id}`);
        
        if (response.data) {
            rows.value.splice(index, 1); // Remove row from the array
        }
    } catch (error) {
        console.error('Error deleting row:', error);
    }
}

function openDetailModal(row) {
      selectedRow.value = row; // Set the selected row for displaying details
      showModalDetail.value = true; // Open the modal
    }

function clearInputs() {
    fixkosten.value = null;
    varKosten.value = null;
    geplantePMenge.value = null;
    stueckPreis.value = null;
}

function calculateKTZ(row){
    let wert = 0;
    if(row.stueckPreis && row.geplantePMenge)
    {
        wert = row.stueckPreis * row.geplantePMenge;
    }
    row.KTZrechnung = wert;
    return wert;
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

function calculateOP(row) {
    let wert = 0;
    if (row.deckungsBeitrag && row.fixkosten) {
        wert = row.deckungsBeitrag - row.fixkosten;
    }
    row.opErgebnis = wert;
    return wert;
}

function calculateSK(row){
    let wert = 0;
    if(row.varKosten && row.geplantePMenge)
    {
        wert = row.varKosten / row.geplantePMenge;
    }
    row.stueckkosten = wert;
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

function calculateDPS(row){
    let wert = 0;
    if(row.stueckPreis && row.stueckkosten)
    {
        wert = row.stueckPreis - row.stueckkosten;
    }
    row.deckungsBeitragProStueck = wert;
    return wert;
}

function calculateBEM(row){
    let wert = 0;
    if(row.fixkosten && row.deckungsBeitragProStueck)
    {
        wert = row.fixkosten / row.deckungsBeitragProStueck;
    }
    row.breakEvenMenge = wert;
    return wert;
}

function calculateBEU(row){
    let wert = 0;
    if(row.breakEvenMenge && row.stueckPreis)
    {
        wert = row.breakEvenMenge * row.stueckPreis;
    }
    row.breakEvenUmsatz = wert;
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
                            <th>Deckungsbeitrag pro Stück:
                                <span id="tooltip-beschaeftAbweichung" class="tooltip-container">
                        <sup class="information">i</sup>
                        <span class="tooltip-text">Beschäftigungsabweichung: SollKosten - IstKosten verrechnete Leistung</span>
                    </span>
                            </th>
                            <th>Break Even Menge:
                                <span id="tooltip-beschaeftAbweichung" class="tooltip-container">
                        <sup class="information">i</sup>
                        <span class="tooltip-text">Beschäftigungsabweichung: SollKosten - IstKosten verrechnete Leistung</span>
                    </span>
                            </th>
                            <th>Break Even Umsatz:
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
                          <td>{{ row.deckungsBeitragProStueck }}</td>
                          <td>{{ row.breakEvenMenge }}</td>
                          <td>{{ row.breakEvenUmsatz }}</td>
                          <td><button class = "button bg-danger" @click="deleteRow(row.id, index)">löschen</button>
                            <button class="button bg-info" @click="openDetailModal(row)">Details</button></td>
                      </tr>
                  </tbody>
              </table>
          </div>
                   <!-- Modal Window for Row Details -->
        <div v-if="showModalDetail" class="modal-overlay">
          <div class="modal-content-details" id="modalContent">
            <h3>Details für {{ selectedRow?.name || '' }}</h3>
            <p><strong>Break-Even:</strong> {{ selectedRow?.kurzPreisUG || '' }}</p>

            <br>
            <strong>KTZrechnung :</strong>    
            <p> KTZrechnung  = Stückpreis × Produktionsmenge</p>
            <p> KTZrechnung = {{ selectedRow?.stueckPreis }} × {{ selectedRow?.geplantePMenge }}</p>
            <p> <u>KTZrechnung  = {{ selectedRow.KTZrechnung }} </u></p>
            <br> 
            <strong>deckungsBeitrag :</strong>
            <p> deckungsBeitrag  = Umsatz – variable Kosten</p>
            <p> deckungsBeitrag  = {{ selectedRow?.KTZrechnung }} – {{ selectedRow?.varKosten }}</p>
            <p><u> deckungsBeitrag  = {{ selectedRow?.deckungsBeitrag }}</u></p>
            <br> 
            <p><strong>opErgebnis :</strong> {{ selectedRow?.langPreisUG || '' }}</p>
            <p> opErgebnis  = deckungsBeitrag – Fix Kosten </p>
            <p> opErgebnis  = {{ selectedRow?.deckungsBeitrag }} – {{ selectedRow?.fixkosten }}</p>
            <p><u> opErgebnis  = {{ selectedRow?.opErgebnis }}</u></p>
            <br> 
            <p><strong>Deckungsbeitrag pro Stück	:</strong> {{ selectedRow?.langPreisUG || '' }}</p>
            <p> Stückkosten = variable Kosten / Menge </p>
            <p> Stückkosten = {{ selectedRow?.varKosten }} / {{ selectedRow?.geplantePMenge }} </p>
            <p> Stückkosten = {{ selectedRow?.stueckkosten }} </p>
            <p> Deckungsbeitrag pro Stück = Stückpreis – Stückkosten </p>
            <p> Deckungsbeitrag pro Stück = {{ selectedRow?.stueckPreis }} – {{ selectedRow?.stueckkosten }}</p>
            <p><u> Deckungsbeitrag pro Stück	= {{ selectedRow?.deckungsBeitragProStueck }}</u></p>
            <br> 
            <p><strong>Break Even Menge:</strong> {{ selectedRow?.langPreisUG || '' }}</p>
            <p> Break Even Menge = Fixkosten / deckungsBeitrag Pro Stück </p>
            <p> Break Even Menge = {{ selectedRow?.fixkosten }} – {{ selectedRow?.deckungsBeitragProStueck }}</p>
            <p><u> Break Even Menge = {{ selectedRow?.breakEvenMenge }}</u></p>
            <br> 
            <p><strong>Break Even Umsatz:</strong> {{ selectedRow?.langPreisUG || '' }}</p>
            <p> Break Even Umsatz = Break-Even Menge × Stückpreis</p>
            <p> Break Even Umsatz = {{ selectedRow?.breakEvenMenge }} / {{ selectedRow?.stueckPreis }}</p>
            <p><u> Break Even Umsatz = {{ selectedRow?.breakEvenUmsatz }}</u></p>
            <br> 
        <div>
            <button @click="exportToPDF(`BreakEven_${selectedRow.id}`)">Als PDF exportieren</button>
            <div></div>
            <button @click="showModalDetail = false">Schließen</button>
        </div>
          </div>
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

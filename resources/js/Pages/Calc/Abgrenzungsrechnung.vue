<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'


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

const aufwand = ref(null);
const selectedRange = ref(null); // For date range picker (months)
const zeitliche_abgrenzung = ref(null);
const sachliche_abgrenzung = ref(null);
const za_aw = ref(null);
const kosten = ref(null);
const rows = ref([]);

const monthDifference = computed(() => {
    console.log(selectedRange)
    if (selectedRange.value && selectedRange.value.length === 2) {
        const [startDate, endDate] = selectedRange.value;

        // Extract month and year from both startDate and endDate
        const startMonth = startDate.year * 12 + startDate.month; // Convert year and month into total months
        const endMonth = endDate.year * 12 + endDate.month;

        return endMonth - startMonth + 1; // +1 to include the start month
    }
    return 0;
});

onMounted(() => {
    rows.value = props.items.map(item => ({
        id: item.id,  // Ensure you have an ID field for deleting rows later
        aufwand: item.aufwand,
        zeitraum: item.zeitraum,
        zeitliche_abgrenzung: item.zeitliche_abgrenzung,
        sachliche_abgrenzung: item.sachliche_abgrenzung,
        za_aw: item.za_aw,
        kosten: item.kosten,
        neueSpalte: null,
    }));
});

async function addRow() {
    try {
        const newRow = {
            aufwand: aufwand.value,
            zeitraum: monthDifference.value, // Use month difference
            zeitliche_abgrenzung: zeitliche_abgrenzung.value,
            sachliche_abgrenzung: sachliche_abgrenzung.value,
            za_aw: za_aw.value,
            kosten: kosten.value,
        };

        try{
            newRow.zeitliche_abgrenzung = calculateZA(newRow);
            newRow.za_aw = calculateZAAW(newRow);
            newRow.kosten = calculateWert(newRow);
            console.log(newRow);
            if(newRow.sachliche_abgrenzung == ''){
                newRow.sachliche_abgrenzung = '-';
            }
        }catch(error){
            console.error('Error setting functions:', error)
        }
        

        const response = await axios.post('/abgrenzungsrechnung', newRow);
        
        if (response.data) {
            rows.value.push({
                ...newRow,
                id: response.data.id,  
                neueSpalte: calculateWert(newRow),
            });
            clearInputs();
        }
    } catch (error) {
        console.error('Error adding row:', error);
    }
}

async function deleteRow(id, index) {
    try {
        const response = await axios.delete(`/abgrenzungsrechnung/${id}`);
        
        if (response.data) {
            rows.value.splice(index, 1); // Remove row from the array
        }
    } catch (error) {
        console.error('Error deleting row:', error);
    }
}

function clearInputs() {
    aufwand.value = null;
    selectedRange.value = null;
    zeitliche_abgrenzung.value = null;
    sachliche_abgrenzung.value = null;
    za_aw.value = null;
    kosten.value = null;
}

function calculateWert(row) {
    let wert = 0;
    if (row.zeitraum && row.aufwand) {
        wert = (row.aufwand / 12) * row.zeitraum - row.aufwand;
    } else if (row.sachliche_abgrenzung) {
        wert = row.sachliche_abgrenzung * 1.2;
    }
    row.neueSpalte = wert;
    return wert;
}

function calculateZA(row){
    let wert = 0;
    if(row.zeitliche_abgrenzung)
    {
        wert = zeitliche_abgrenzung;
    }
    else if(row.aufwand && row.zeitraum)
    {
        let x = row.aufwand / 12;
        wert = x * row.zeitraum;
    }
    row.zeitliche_abgrenzung = -(wert);
    return -(wert);
}

function calculateZAAW(row){
    let wert = 0;
    if(row.aufwand && row.zeitliche_abgrenzung)
    {
        wert = row.aufwand + row.zeitliche_abgrenzung;
    }
    row.za_aw = wert;
    return wert;
}
</script>



<template>
  <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Abgrenzungsrechnung</h2>

  <div class="py-12 m-lg-4">
    <div
      class="input-area"
      style="display: grid; grid-template-columns: 3fr 2fr; grid-gap: 20px; align-items: center; justify-content: center; justify-items: center; max-width: 600px; margin: 0 auto;"
    >
      <!-- Label and Date Picker in Grid -->
      <label for="input2" style="justify-self: start;">Für welchen Zeitraum soll abgegrenzt werden?</label>
      <VueDatePicker v-model="selectedRange" auto-apply month-picker range style="max-width: 250px;" />

      <!-- Aufwand Input -->
      <label for="input1" style="justify-self: start;">Bitte trage den <span id="tooltip-aufwand" class="tooltip-container">
              Aufwand<sup class="information">i</sup>
              <span class="tooltip-text">Was wurde bezahlt</span>
            </span>
        ein:</label>
      <input type="number" v-model="aufwand" id="input1" style="max-width: 250px;" />

      <!-- Sachliche Abgrenzung Input -->
      <label for="input4" style="justify-self: start;">Gibt es eine sachliche <span id="tooltip-aufwand" class="tooltip-container">
              Abgrenzung<sup class="information">i</sup>
              <span class="tooltip-text">betriebsfremde, außerordentliche und periodenfremde Aufwendungen</span>
            </span>?</label>
      <input type="number" v-model="sachliche_abgrenzung" id="input4" style="max-width: 250px;" />

      <!-- Kosten Input -->
      <label for="input6" style="justify-self: start;">Gibt es schon die fertigen Kosten?</label>
      <input type="number" v-model="kosten" id="input6" style="max-width: 250px;" />

      <!-- Empty space to align button -->
      <div></div>
      <button class="button bg-primary" style="justify-self: start; max-width: 150px;" @click="addRow">
        Berechnen
      </button>
    </div>

    <table class="table">
      <thead>
        <tr>
          <th class="bg-success">Aufwand</th>
          <th>Zeitraum</th>
          <th>Zeitliche Abgrenzung</th>
          <th>
            <span id="tooltip-aufwand" class="tooltip-container">
              zeitlich abgegrenzter Aufwand<sup class="information">i</sup>
              <span class="tooltip-text">Definition/Rechnung für den zeitlich abgegrenzter Aufwand</span>
            </span>
          </th>
          <th>Sachliche Abgrenzung</th>
          <th class="bg-danger">
            <span id="tooltip-aufwand" class="tooltip-container">
              Kosten<sup class="information">i</sup>
              <span class="tooltip-text">tatsächlich angefallene Kosten</span>
            </span>
          </th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(row, index) in rows" :key="index">
          <td>{{ row.aufwand }}</td>
          <td>{{ row.zeitraum }}</td>
          <td>{{ row.zeitliche_abgrenzung }}</td>
          <td>{{ row.za_aw }}</td>
          <td>{{ row.sachliche_abgrenzung }}</td>
          <td>{{ row.kosten }}</td>
          <td>
            <button class="button bg-danger" @click="deleteRow(row.id, index)">
              löschen
            </button>
          </td>
        </tr>
      </tbody>
    </table>
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

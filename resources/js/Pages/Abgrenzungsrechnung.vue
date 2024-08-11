<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';

const emit = defineEmits(['update:checked']);

const props = defineProps({
    checked: {
        type: [Array, Boolean],
        required: true,
    },
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
const zeitraum = ref(null);
const zeitlicheAbgrenzung = ref(null);
const sachlicheAbgrenzung = ref(null);
const za_aw = ref(null);
const kosten = ref(null);
const rows = ref([]);

onMounted(() => {
    rows.value = props.items.map(item => ({
        id: item.id,  // Ensure you have an ID field for deleting rows later
        aufwand: item.aufwand,
        zeitraum: item.zeitraum,
        zeitlicheAbgrenzung: item.zeitliche_abgrenzung,
        sachlicheAbgrenzung: item.sachliche_abgrenzung,
        za_aw: item.za_aw,
        kosten: item.kosten,
        neueSpalte: null,
    }));
});

async function addRow() {
    try {
        const newRow = {
            aufwand: aufwand.value,
            zeitraum: zeitraum.value,
            zeitliche_abgrenzung: zeitlicheAbgrenzung.value,
            sachliche_abgrenzung: sachlicheAbgrenzung.value,
            za_aw: za_aw.value,
            kosten: kosten.value,
        };

        try{
            newRow.zeitliche_abgrenzung = calculateZA(newRow);
            newRow.za_aw = calculateZAAW(newRow);
            newRow.kosten = calculateWert(newRow);
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
    zeitraum.value = null;
    zeitlicheAbgrenzung.value = null;
    sachlicheAbgrenzung.value = null;
    za_aw.value = null;
    kosten.value = null;
}

function calculateWert(row) {
    let wert = 0;
    if (row.zeitraum && row.aufwand) {
        wert = (row.aufwand / 12) * row.zeitraum - row.aufwand;
    } else if (row.sachlicheAbgrenzung) {
        wert = row.sachlicheAbgrenzung * 1.2;
    }
    row.neueSpalte = wert;
    return wert;
}

function calculateZA(row){
    let wert = 0;
    if(row.zeitlicheAbgrenzung)
    {
        wert = zeitlicheAbgrenzung;
    }
    else if(row.aufwand && row.zeitraum)
    {
        let x = row.aufwand / 12;
        wert = x * row.zeitraum;
    }
    row.zeitlicheAbgrenzung = -(wert);
    return -(wert);
}

function calculateZAAW(row){
    let wert = 0;
    if(row.aufwand && row.zeitlicheAbgrenzung)
    {
        wert = row.aufwand + row.zeitlicheAbgrenzung;
    }
    row.za_aw = wert;
    return wert;
}
</script>



<template>
    <div>
      <Head title="Abgrenzungsrechnung">
      </Head>
  
      <AuthenticatedLayout>
          <template #header>
              <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Abgrenzungsrechnung</h2>
          </template>
          
          <div class="py-12">
              <div class="input-area">
                  <label for="input1">Aufwand:</label>
                  <input type="number" v-model="aufwand" id="input1" />
                  
                  <label for="input2">Zeitraum (Monate):</label>
                  <input type="number" v-model="zeitraum" id="input2" />

                  <label for="input4">Sachliche Abgrenzung:</label>
                  <input type="number" v-model="sachlicheAbgrenzung" id="input4" />

                  <label for="input6">Kosten:</label>
                  <input type="number" v-model="kosten" id="input6" />
                  
                  <button class="button" @click="addRow"> Add Row </button>
              </div>
  
              <table class="table">
                  <thead>
                      <tr>
                          <th class="success">Aufwand</th>
                          <th class = "highlight">Zeitraum</th>
                          <th>Zeitliche Abgrenzung</th>
                          <th>Sachliche Abgrenzung</th>
                          <th>zeitlich abgegrenzter Aufwand</th>
                          <th class="warning">Kosten</th>
                          <th>Actions</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr v-for="(row, index) in rows" :key="index">
                          <td>{{ row.aufwand }}</td>
                          <td>{{ row.zeitraum }}</td>
                          <td>{{ row.zeitlicheAbgrenzung }}</td>
                          <td>{{ row.sachlicheAbgrenzung }}</td>
                          <td>{{ row.za_aw }}</td>
                          <td>{{ row.kosten }}</td>
                          <td><button class = "button" @click="deleteRow(row.id, index)">Delete</button></td>
                      </tr>
                  </tbody>
              </table>
          </div>
      </AuthenticatedLayout>
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

.highlight {
    background-color: yellow;
}

.success{
    background-color: green;
}

.warning{
    background-color: red;
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
</style>

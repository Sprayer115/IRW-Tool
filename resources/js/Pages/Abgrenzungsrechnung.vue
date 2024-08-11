<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed, onMounted } from 'vue';

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

const input1 = ref(null);
const zeitraum = ref(null);
const sachlicheAbgrenzung = ref(null);
const rows = ref([]);

function addRow() {
    rows.value.push({
        input1: input1.value,
        zeitraum: zeitraum.value,
        sachlicheAbgrenzung: sachlicheAbgrenzung.value,
        neueSpalte: null
    });
    clearInputs();
}

function clearInputs() {
    input1.value = null;
    zeitraum.value = null;
    sachlicheAbgrenzung.value = null;
}

function calculateWert(row) {
    let wert = 0;
    if (row.zeitraum && row.input1) {
        wert = (row.input1 / 12) * row.zeitraum - row.input1;
    } else if (row.sachlicheAbgrenzung) {
        wert = row.sachlicheAbgrenzung * 1.2;
    }
    row.neueSpalte = wert;
    return wert;
}

// Initialize rows with data passed from the server
onMounted(() => {
    rows.value = props.items.map(item => ({
        input1: item.input1,
        zeitraum: item.zeitraum,
        sachlicheAbgrenzung: item.sachliche_abgrnzung,
        
    }));
});
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
                <label for="input1">Input 1:</label>
                <input type="number" v-model="input1" id="input1" />
                
                <label for="input2">Zeitraum (Monate):</label>
                <input type="number" v-model="zeitraum" id="input2" />
                
                <label for="input3">Sachliche Abgrenzung:</label>
                <input type="number" v-model="sachlicheAbgrenzung" id="input3" />
                
                <button @click="addRow">Add Row</button>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>Input 1</th>
                        <th>Zeitraum</th>
                        <th>Sachliche Abgrenzung</th>
                        <th>Berechneter Wert</th>
                        <th class="highlight">Neue Spalte</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index) in rows" :key="index">
                        <td>{{ row.input1 }}</td>
                        <td>{{ row.zeitraum }}</td>
                        <td>{{ row.sachlicheAbgrenzung }}</td>
                        <td>{{ calculateWert(row) }}</td>
                        <td>{{ row.neueSpalte }}</td>
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

.input-area {
    margin-bottom: 20px;
}

label {
    margin-right: 10px;
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

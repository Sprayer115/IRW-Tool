<script setup>
import { ref, computed, watch, onMounted } from "vue";
import mermaid from "mermaid";

const preAuxiliaryCostCenters = ref([
    { id: 1, name: "Vor-Hilfskostenstelle 1", value: 0 },
]);

const primaryOverheadCosts = ref([
    { id: 1, name: "Primäre Gemeinkosten 1", value: 0 },
]);

const allocationMatrix = ref({});
const mermaidDiagram = ref("");

const calculationResults = ref(null);
const showResults = ref(false);

const performCalculations = () => {
    const results = {};

    // Initialize results object
    preAuxiliaryCostCenters.value.forEach((cc) => {
        results[cc.id] = {
            name: cc.name,
            primaryCosts: cc.value,
            allocations: {},
            secondaryCosts: 0,
            totalCosts: cc.value,
        };
    });

    primaryOverheadCosts.value.forEach((oc) => {
        results[`oc${oc.id}`] = {
            name: oc.name,
            primaryCosts: oc.value,
            allocations: {},
            secondaryCosts: 0,
            totalCosts: oc.value,
        };
    });

    // Calculate allocations
    preAuxiliaryCostCenters.value.forEach((cc) => {
        primaryOverheadCosts.value.forEach((oc) => {
            const allocationPercentage =
                allocationMatrix.value[cc.id][oc.id] / 100;
            const allocationAmount = cc.value * allocationPercentage;
            results[cc.id].allocations[`oc${oc.id}`] = allocationAmount;
            results[`oc${oc.id}`].secondaryCosts += allocationAmount;
            results[`oc${oc.id}`].totalCosts += allocationAmount;
        });
    });

    calculationResults.value = results;
};

const calculate = () => {
    performCalculations();
    showResults.value = true;
    updateMermaidDiagram();
    renderMermaidDiagram();
};

const updateMermaidDiagram = () => {
    let diagramCode = "graph LR;\n";

    preAuxiliaryCostCenters.value.forEach((cc) => {
        diagramCode += `CC${cc.id}["${cc.name}<br/>${cc.value} €"];\n`;
    });

    primaryOverheadCosts.value.forEach((oc) => {
        diagramCode += `OC${oc.id}(["${oc.name}<br/>${oc.value} €"]);\n`;
    });

    preAuxiliaryCostCenters.value.forEach((cc) => {
        primaryOverheadCosts.value.forEach((oc) => {
            const allocationValue = allocationMatrix.value[cc.id]?.[oc.id] || 0;
            if (allocationValue > 0) {
                diagramCode += `CC${cc.id} -->|"<div class='mermaid-edge-label'>${allocationValue}</div>"| OC${oc.id};\n`;
            }
        });
    });

    mermaidDiagram.value = diagramCode;
};

const renderMermaidDiagram = async () => {
    try {
        const { svg } = await mermaid.render(
            "mermaid-diagram",
            mermaidDiagram.value
        );
        const diagramContainer = document.getElementById("mermaid-container");
        if (diagramContainer) {
            diagramContainer.innerHTML = svg;
        }
    } catch (error) {
        console.error("Failed to render Mermaid diagram:", error);
    }
};

watch(
    [preAuxiliaryCostCenters, primaryOverheadCosts, allocationMatrix],
    () => {
        updateMermaidDiagram();
        renderMermaidDiagram();
    },
    { deep: true }
);

onMounted(() => {
    mermaid.initialize({
        startOnLoad: false,
        theme: "neutral",
        flowchart: {
            nodeSpacing: 50,
            rankSpacing: 100,
            curve: "basis",
            useMaxWidth: false,
        },
        themeVariables: {
            edgeLabelBackground: "#ffffff",
            lineColor: "#333333",
        },
        htmlLabels: true,
        sequence: {
            useMaxWidth: false,
        },
    });
    updateMermaidDiagram();
    renderMermaidDiagram();
});

const addPreAuxiliaryCostCenter = () => {
    const newId = preAuxiliaryCostCenters.value.length + 1;
    preAuxiliaryCostCenters.value.push({
        id: newId,
        name: `Vor-Hilfskostenstelle ${newId}`,
        value: 0,
    });
    updateAllocationMatrix();
};

const addPrimaryOverheadCost = () => {
    const newId = primaryOverheadCosts.value.length + 1;
    primaryOverheadCosts.value.push({
        id: newId,
        name: `Primäre Gemeinkosten ${newId}`,
        value: 0,
    });
    updateAllocationMatrix();
};

const updateAllocationMatrix = () => {
    preAuxiliaryCostCenters.value.forEach((costCenter) => {
        if (!allocationMatrix.value[costCenter.id]) {
            allocationMatrix.value[costCenter.id] = {};
        }
        primaryOverheadCosts.value.forEach((overheadCost) => {
            if (
                allocationMatrix.value[costCenter.id][overheadCost.id] ===
                undefined
            ) {
                allocationMatrix.value[costCenter.id][overheadCost.id] = 0;
            }
        });
    });
};

const removePreAuxiliaryCostCenter = (id) => {
    preAuxiliaryCostCenters.value = preAuxiliaryCostCenters.value.filter(
        (cc) => cc.id !== id
    );
    delete allocationMatrix.value[id];
};

const removePrimaryOverheadCost = (id) => {
    primaryOverheadCosts.value = primaryOverheadCosts.value.filter(
        (oc) => oc.id !== id
    );
    Object.keys(allocationMatrix.value).forEach((ccId) => {
        delete allocationMatrix.value[ccId][id];
    });
};

const totalCosts = computed(() => {
    return (
        preAuxiliaryCostCenters.value.reduce((sum, cc) => sum + cc.value, 0) +
        primaryOverheadCosts.value.reduce((sum, oc) => sum + oc.value, 0)
    );
});


// Initialize the allocation matrix
updateAllocationMatrix();
</script>

<template>
    <div class="p-6 bg-white2 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6">Anbauverfahren</h2>

        <div class="flex flex-wrap -mx-2 mb-8">
            <div class="w-full md:w-1/2 px-2 mb-4 md:mb-0">
                <h3 class="text-xl font-semibold mb-4">
                    Vor-Hilfskostenstellen
                </h3>
                <div
                    v-for="costCenter in preAuxiliaryCostCenters"
                    :key="costCenter.id"
                    class="mb-4 flex items-center space-x-2"
                >
                    <input
                        v-model="costCenter.name"
                        type="text"
                        class="flex-grow p-2 border rounded text-sm"
                        :placeholder="`Name der Vor-Hilfskostenstelle ${costCenter.id}`"
                    />
                    <input
                        v-model.number="costCenter.value"
                        type="number"
                        class="w-24 p-2 border rounded text-sm"
                        placeholder="Wert"
                    />
                    <button
                        @click="removePreAuxiliaryCostCenter(costCenter.id)"
                        class="p-2 text-red-500 hover:text-red-700"
                    >
                        <span class="sr-only">Entfernen</span>
                        <svg
                            class="w-5 h-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                            ></path>
                        </svg>
                    </button>
                </div>
                <button
                    @click="addPreAuxiliaryCostCenter"
                    class="mt-2 p-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm"
                >
                    Vor-Hilfskostenstelle hinzufügen
                </button>
            </div>

            <div class="w-full md:w-1/2 px-2">
                <h3 class="text-xl font-semibold mb-4">Primäre Gemeinkosten</h3>
                <div
                    v-for="overheadCost in primaryOverheadCosts"
                    :key="overheadCost.id"
                    class="mb-4 flex items-center space-x-2"
                >
                    <input
                        v-model="overheadCost.name"
                        type="text"
                        class="flex-grow p-2 border rounded text-sm"
                        :placeholder="`Name der Primären Gemeinkosten ${overheadCost.id}`"
                    />
                    <input
                        v-model.number="overheadCost.value"
                        type="number"
                        class="w-24 p-2 border rounded text-sm"
                        placeholder="Wert"
                    />
                    <button
                        @click="removePrimaryOverheadCost(overheadCost.id)"
                        class="p-2 text-red-500 hover:text-red-700"
                    >
                        <span class="sr-only">Entfernen</span>
                        <svg
                            class="w-5 h-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                            ></path>
                        </svg>
                    </button>
                </div>
                <button
                    @click="addPrimaryOverheadCost"
                    class="mt-2 p-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm"
                >
                    Primäre Gemeinkosten hinzufügen
                </button>
            </div>
        </div>

        <div class="mb-8">
            <h3 class="text-xl font-semibold mb-4">Verrechnungssätze</h3>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse border">
                    <thead>
                        <tr>
                            <th class="border p-2">Vor-Hilfskostenstelle</th>
                            <th
                                v-for="overheadCost in primaryOverheadCosts"
                                :key="overheadCost.id"
                                class="border p-2"
                            >
                                {{ overheadCost.name }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="costCenter in preAuxiliaryCostCenters"
                            :key="costCenter.id"
                        >
                            <td class="border p-2">{{ costCenter.name }}</td>
                            <td
                                v-for="overheadCost in primaryOverheadCosts"
                                :key="overheadCost.id"
                                class="border p-2"
                            >
                                <input
                                    v-model.number="
                                        allocationMatrix[costCenter.id][
                                            overheadCost.id
                                        ]
                                    "
                                    type="number"
                                    class="w-full p-1 border rounded"
                                    placeholder="Verrechnungssatz"
                                />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8">
            <h3 class="text-xl font-semibold mb-4">Visualisierung</h3>
            <div id="mermaid-container" class="overflow-x-auto"></div>
        </div>

        <button
            @click="calculate"
            class="mt-4 p-2 bg-green-500 text-white rounded hover:bg-green-600"
        >
            Berechnen
        </button>

        <div v-if="showResults" class="mt-8">
      <h3 class="text-xl font-semibold mb-4">Ergebnisse</h3>
      <div class="overflow-x-auto">
        <table class="w-full border-collapse border">
          <thead>
            <tr>
              <th class="border p-2">Beschreibung</th>
              <th v-for="cc in preAuxiliaryCostCenters" :key="cc.id" class="border p-2">
                {{ calculationResults[cc.id].name }}
              </th>
              <th v-for="oc in primaryOverheadCosts" :key="oc.id" class="border p-2">
                {{ calculationResults[`oc${oc.id}`].name }}
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="border p-2 font-semibold">Primäre GK</td>
              <td v-for="cc in preAuxiliaryCostCenters" :key="cc.id" class="border p-2">
                {{ calculationResults[cc.id].primaryCosts.toFixed(2) }} €
              </td>
              <td v-for="oc in primaryOverheadCosts" :key="oc.id" class="border p-2">
                {{ calculationResults[`oc${oc.id}`].primaryCosts.toFixed(2) }} €
              </td>
            </tr>
            <tr v-for="cc in preAuxiliaryCostCenters" :key="cc.id">
              <td class="border p-2 font-semibold">Verrechnung {{ calculationResults[cc.id].name }}</td>
              <td v-for="innerCc in preAuxiliaryCostCenters" :key="innerCc.id" class="border p-2">
                {{ innerCc.id === cc.id ? '-'+cc.value.toFixed(2)+ " €" : '-' }}
              </td>
              <td v-for="oc in primaryOverheadCosts" :key="oc.id" class="border p-2">
                {{ (calculationResults[cc.id].allocations[`oc${oc.id}`] || 0).toFixed(2) }} €
              </td>
            </tr>
            <tr>
              <td class="border p-2 font-semibold">Sekundäre GK</td>
              <td v-for="cc in preAuxiliaryCostCenters" :key="cc.id" class="border p-2">
                    -
              </td>
              <td v-for="oc in primaryOverheadCosts" :key="oc.id" class="border p-2">
                {{ calculationResults[`oc${oc.id}`].secondaryCosts.toFixed(2) }} €
              </td>
            </tr>
            <tr>
              <td class="border p-2 font-semibold">Gesamte GK</td>
              <td v-for="cc in preAuxiliaryCostCenters" :key="cc.id" class="border p-2">
                {{ calculationResults[cc.id].primaryCosts.toFixed(2) }} €
              </td>
              <td v-for="oc in primaryOverheadCosts" :key="oc.id" class="border p-2">
                {{ calculationResults[`oc${oc.id}`].totalCosts.toFixed(2) }} €
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    </div>
</template>

<style scoped>
#mermaid-container {
    width: 100%;
    overflow-x: auto;
}

@media (max-width: 768px) {
    .flex-wrap > div {
        width: 100%;
    }
}
</style>
<style>
.mermaid-edge-label {
    background-color: white;
    border: 1px solid #333;
    border-radius: 4px;
    font-weight: bold;
    display: flex;
    justify-content: center;
    align-items: center;
    min-width: 24px;
    min-height: 24px;
    padding: 2px 4px;
    font-size: 12px;
    line-height: 1;
}

.mermaid .edgeLabel {
    background-color: transparent;
}

.mermaid .edgeLabel foreignObject {
    overflow: visible;
}
</style>

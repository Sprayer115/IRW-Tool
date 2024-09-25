<script setup>
import { ref, computed, watch, onMounted } from "vue";
import mermaid from "mermaid";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import Anbauverfahren from "@/Pages/Anbauverfahren.vue";
import Stufenleiterverfahren from "@/Pages/Stufenleiterverfahren.vue";
import Gleichungsverfahren from "@/Pages/Gleichungsverfahren.vue";

const activeComponent = ref("Anbauverfahren");

const components = {
    Anbauverfahren,
    Stufenleiterverfahren,
    Gleichungsverfahren,
};

const setActiveComponent = (component) => {
    activeComponent.value = component;
};

const preAuxiliaryCostCenters = ref([
    { id: 1, name: "Vor-Hilfskostenstelle 1", value: 0, order: 1 },
]);

const primaryOverheadCosts = ref([
    { id: 1, name: "Primäre Gemeinkosten 1", value: 0 },
]);

const allocationMatrix = ref({});
const mermaidDiagram = ref("");

const calculationResults = ref(null);
const showResults = ref(false);

const updateMermaidDiagram = () => {
    let diagramCode = "graph TD;\n";

    // Add nodes for pre-auxiliary cost centers
    sortedPreAuxiliaryCostCenters.value.forEach((cc) => {
        diagramCode += `CC${cc.id}["${cc.name}<br/>${cc.value} €"];\n`;
    });

    // Add nodes for primary overhead costs
    primaryOverheadCosts.value.forEach((oc) => {
        diagramCode += `OC${oc.id}["${oc.name}<br/>${oc.value} €"];\n`;
    });

    // Add edges between pre-auxiliary cost centers
    sortedPreAuxiliaryCostCenters.value.forEach((sourceCC, sourceIndex) => {
        for (let targetIndex = sourceIndex + 1; targetIndex < sortedPreAuxiliaryCostCenters.value.length; targetIndex++) {
            const targetCC = sortedPreAuxiliaryCostCenters.value[targetIndex];
            const allocationValue = allocationMatrix.value[sourceCC.id]?.[targetCC.id] || 0;
            if (allocationValue > 0) {
                diagramCode += `CC${sourceCC.id} -->|"<div class='mermaid-edge-label'>${allocationValue}</div>"| CC${targetCC.id};\n`;
            }
        }
    });

    // Add edges from pre-auxiliary cost centers to primary overhead costs
    sortedPreAuxiliaryCostCenters.value.forEach((cc) => {
        primaryOverheadCosts.value.forEach((oc) => {
            const allocationValue = allocationMatrix.value[cc.id]?.[`oc${oc.id}`] || 0;
            if (allocationValue > 0) {
                diagramCode += `CC${cc.id} -->|"<div class='mermaid-edge-label'>${allocationValue}</div>"| OC${oc.id};\n`;
            }
        });
    });

    mermaidDiagram.value = diagramCode;
};

const isExtendedAllocationRequired = computed(() => {
    return (
        activeComponent.value === "Stufenleiterverfahren" ||
        activeComponent.value === "Gleichungsverfahren"
    );
});

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
        graph: {
            rankDir: "TB",
        },
    });
    updateMermaidDiagram();
    renderMermaidDiagram();
});

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
    // Include relationships with other Kostenstellen
    preAuxiliaryCostCenters.value.forEach((targetCostCenter) => {
      if (
        costCenter.id !== targetCostCenter.id &&
        allocationMatrix.value[costCenter.id][targetCostCenter.id] === undefined
      ) {
        allocationMatrix.value[costCenter.id][targetCostCenter.id] = 0;
      }
    });
    // Include relationships with Gemeinkosten
    primaryOverheadCosts.value.forEach((overheadCost) => {
      if (
        allocationMatrix.value[costCenter.id][`oc${overheadCost.id}`] === undefined
      ) {
        allocationMatrix.value[costCenter.id][`oc${overheadCost.id}`] = 0;
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

const sortedPreAuxiliaryCostCenters = computed(() => {
    if (activeComponent.value === "Stufenleiterverfahren") {
        return [...preAuxiliaryCostCenters.value].sort(
            (a, b) => a.order - b.order
        );
    }
    return preAuxiliaryCostCenters.value;
});

const addPreAuxiliaryCostCenter = () => {
    const newId = preAuxiliaryCostCenters.value.length + 1;
    preAuxiliaryCostCenters.value.push({
        id: newId,
        name: `Vor-Hilfskostenstelle ${newId}`,
        value: 0,
        order: newId,
    });
    updateAllocationMatrix();
};

const showAllocationInput = (sourceCC, targetCC) => {
    if (activeComponent.value === "Anbauverfahren") {
        return false; // No allocations between Kostenstellen for Anbauverfahren
    } else if (activeComponent.value === "Stufenleiterverfahren") {
        return sourceCC.order < targetCC.order; // Only allow allocations to "later" Kostenstellen
    } else {
        return sourceCC.id !== targetCC.id; // Allow all allocations except self for Gleichungsverfahren
    }
};

const updateOrder = (id, newOrder) => {
    if (activeComponent.value === "Stufenleiterverfahren") {
        const costCenter = preAuxiliaryCostCenters.value.find(
            (cc) => cc.id === id
        );
        if (costCenter) {
            costCenter.order = newOrder;
        }
    }
};

const handleCalculation = (results) => {
    calculationResults.value = results;
    showResults.value = true;
    updateMermaidDiagram();
    renderMermaidDiagram();
};

// Initialize the allocation matrix
updateAllocationMatrix();
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Innerbetriebliche Leistungsverrechnung" />

        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Innerbetriebliche Leistungsverrechnung
            </h2>
            <hr class="my-2 border-gray-300 dark:border-gray-600" />
            <nav class="">
                <ul class="flex space-x-4">
                    <li
                        v-for="component in Object.keys(components)"
                        :key="component"
                    >
                        <button
                            @click="setActiveComponent(component)"
                            :class="[
                                'px-4 py-2 bg-transparent transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2',
                                activeComponent === component
                                    ? 'text-blue-500 font-semibold'
                                    : 'text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white',
                            ]"
                        >
                            {{ component }}
                        </button>
                    </li>
                </ul>
            </nav>
        </template>

        <div class="py-12">
            <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white2 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
                >
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
                                    @click="
                                        removePreAuxiliaryCostCenter(
                                            costCenter.id
                                        )
                                    "
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
                            <h3 class="text-xl font-semibold mb-4">
                                Primäre Gemeinkosten
                            </h3>
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
                                    @click="
                                        removePrimaryOverheadCost(
                                            overheadCost.id
                                        )
                                    "
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
                        <h3 class="text-xl font-semibold mb-4">
                            Verrechnungssätze
                        </h3>
                        <div class="overflow-x-auto">
                            <!-- Table for Relations-->
                            <table class="w-full border-collapse border">
                                <thead>
                                    <tr>
                                        <th
                                            v-if="
                                                activeComponent ===
                                                'Stufenleiterverfahren'
                                            "
                                            class="border p-2"
                                        >
                                            Reihenfolge
                                        </th>
                                        <th class="border p-2">Von \ Zu</th>
                                        <th
                                            v-for="cc in sortedPreAuxiliaryCostCenters"
                                            :key="cc.id"
                                            class="border p-2"
                                        >
                                            {{ cc.name }}
                                        </th>
                                        <th
                                            v-for="oc in primaryOverheadCosts"
                                            :key="oc.id"
                                            class="border p-2"
                                        >
                                            {{ oc.name }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="sourceCC in sortedPreAuxiliaryCostCenters"
                                        :key="sourceCC.id"
                                    >
                                        <td
                                            v-if="
                                                activeComponent ===
                                                'Stufenleiterverfahren'
                                            "
                                            class="border p-2"
                                        >
                                            <input
                                                v-model.number="sourceCC.order"
                                                @input="
                                                    updateOrder(
                                                        sourceCC.id,
                                                        $event.target.value
                                                    )
                                                "
                                                type="number"
                                                min="1"
                                                :max="
                                                    preAuxiliaryCostCenters.length
                                                "
                                                class="w-full p-1 border rounded"
                                            />
                                        </td>
                                        <td class="border p-2">
                                            {{ sourceCC.name }}
                                        </td>
                                        <td
                                            v-for="targetCC in sortedPreAuxiliaryCostCenters"
                                            :key="targetCC.id"
                                            class="border p-2"
                                        >
                                            <input
                                                v-if="
                                                    showAllocationInput(
                                                        sourceCC,
                                                        targetCC
                                                    )
                                                "
                                                v-model.number="
                                                    allocationMatrix[
                                                        sourceCC.id
                                                    ][targetCC.id]
                                                "
                                                type="number"
                                                class="w-full p-1 border rounded"
                                                placeholder="Verrechnungssatz"
                                            />
                                            <span v-else>-</span>
                                        </td>
                                        <td
                                            v-for="oc in primaryOverheadCosts"
                                            :key="oc.id"
                                            class="border p-2"
                                        >
                                            <input
                                                v-model.number="
                                                    allocationMatrix[
                                                        sourceCC.id
                                                    ][`oc${oc.id}`]
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
                        <h3 class="text-xl font-semibold mb-4">
                            Visualisierung
                        </h3>
                        <div
                            id="mermaid-container"
                            class="overflow-x-auto"
                        ></div>
                    </div>

                    <!-- Active component (calculation method) -->
                    <component
                        :is="components[activeComponent]"
                        :preAuxiliaryCostCenters="preAuxiliaryCostCenters"
                        :primaryOverheadCosts="primaryOverheadCosts"
                        :allocationMatrix="allocationMatrix"
                        @calculate="handleCalculation"
                    ></component>

                    <div v-if="showResults && calculationResults" class="mt-8">
                        <h3 class="text-xl font-semibold mb-4">Ergebnisse</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse border">
                                <thead>
                                    <tr>
                                        <th class="border p-2">Beschreibung</th>
                                        <th
                                            v-for="cc in sortedPreAuxiliaryCostCenters"
                                            :key="cc.id"
                                            class="border p-2"
                                        >
                                            {{
                                                calculationResults[cc.id]
                                                    ?.name ||
                                                `Kostenstelle ${cc.id}`
                                            }}
                                        </th>
                                        <th
                                            v-for="oc in primaryOverheadCosts"
                                            :key="oc.id"
                                            class="border p-2"
                                        >
                                            {{
                                                calculationResults[`oc${oc.id}`]
                                                    ?.name ||
                                                `Gemeinkosten ${oc.id}`
                                            }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="border p-2 font-semibold">
                                            Primäre GK
                                        </td>
                                        <td
                                            v-for="cc in sortedPreAuxiliaryCostCenters"
                                            :key="cc.id"
                                            class="border p-2"
                                        >
                                            {{
                                                (
                                                    calculationResults[cc.id]
                                                        ?.primaryCosts || 0
                                                ).toFixed(2)
                                            }}
                                            €
                                        </td>
                                        <td
                                            v-for="oc in primaryOverheadCosts"
                                            :key="oc.id"
                                            class="border p-2"
                                        >
                                            {{
                                                (
                                                    calculationResults[
                                                        `oc${oc.id}`
                                                    ]?.primaryCosts || 0
                                                ).toFixed(2)
                                            }}
                                            €
                                        </td>
                                    </tr>
                                    <tr
                                        v-for="sourceCC in sortedPreAuxiliaryCostCenters"
                                        :key="sourceCC.id"
                                    >
                                        <td class="border p-2 font-semibold">
                                            Verrechnung
                                            {{
                                                calculationResults[sourceCC.id]
                                                    ?.name ||
                                                `Kostenstelle ${sourceCC.id}`
                                            }}
                                        </td>
                                        <td
    v-for="targetCC in sortedPreAuxiliaryCostCenters"
    :key="targetCC.id"
    class="border p-2"
  >
    {{
      sourceCC.id === targetCC.id
        ? `-${(
            (calculationResults[sourceCC.id]?.primaryCosts || 0) +
            (calculationResults[sourceCC.id]?.secondaryCosts || 0)
          ).toFixed(2)} €`
        : sourceCC.order < targetCC.order
        ? (calculationResults[sourceCC.id]?.allocations?.[targetCC.id] || 0).toFixed(2) + " €"
        : "-"
    }}
  </td>
                                        <td
                                            v-for="oc in primaryOverheadCosts"
                                            :key="oc.id"
                                            class="border p-2"
                                        >
                                            {{
                                                (
                                                    calculationResults[
                                                        sourceCC.id
                                                    ]?.allocations?.[
                                                        `oc${oc.id}`
                                                    ] || 0
                                                ).toFixed(2) + " €"
                                            }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border p-2 font-semibold">
                                            Sekundäre GK
                                        </td>
                                        <td
                                            v-for="cc in sortedPreAuxiliaryCostCenters"
                                            :key="cc.id"
                                            class="border p-2"
                                        >
                                            <!--{{
                                                (
                                                    calculationResults[cc.id]
                                                        ?.secondaryCosts || 0
                                                ).toFixed(2) 
                                            }} €-->
                                            -
                                        </td>
                                        <td
                                            v-for="oc in primaryOverheadCosts"
                                            :key="oc.id"
                                            class="border p-2"
                                        >
                                            {{
                                                (
                                                    calculationResults[
                                                        `oc${oc.id}`
                                                    ]?.secondaryCosts || 0
                                                ).toFixed(2)
                                            }}
                                            €
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border p-2 font-semibold">
                                            Gesamte GK
                                        </td>
                                        <td
                                            v-for="cc in sortedPreAuxiliaryCostCenters"
                                            :key="cc.id"
                                            class="border p-2"
                                        >
                                            {{
                                                (
                                                    calculationResults[cc.id]
                                                        ?.totalCosts || 0
                                                ).toFixed(2)
                                            }}
                                            €
                                        </td>
                                        <td
                                            v-for="oc in primaryOverheadCosts"
                                            :key="oc.id"
                                            class="border p-2"
                                        >
                                            {{
                                                (
                                                    calculationResults[
                                                        `oc${oc.id}`
                                                    ]?.totalCosts || 0
                                                ).toFixed(2)
                                            }}
                                            €
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
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

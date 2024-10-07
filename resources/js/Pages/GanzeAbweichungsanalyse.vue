<script setup>
import { ref, computed, watch, onMounted } from "vue";
import mermaid from "mermaid";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head,usePage, Link } from "@inertiajs/vue3";
import { Inertia } from '@inertiajs/inertia';
import AbweichungsanalyseTabelle from "@/Pages/AbweichungsanalyseTabelle.vue";
import Abweichungsanalyse from "@/Pages/Abweichungsanalyse.vue";

const activeComponent = ref("Abweichungsanalyse");

const components = {
    AbweichungsanalyseTabelle,
    Abweichungsanalyse,
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
      <Head title="Abweichungsanalyse Komplett" />
      <!-- Page Title and Navigation Buttons -->
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          Abweichungsanalyse Komplett
        </h2>
        <hr class="my-2 border-gray-300 dark:border-gray-600" />
  
        <!-- Navigation Buttons -->
        <nav>
          <ul class="flex space-x-4">
            <li v-for="component in Object.keys(components)" :key="component">
              <button
                @click="setActiveComponent(component)"
                :class="[
                  'px-4 py-2 bg-transparent transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2',
                  activeComponent === component ? 'text-blue-500 font-semibold' : 'text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white',
                ]"
              >
                {{ component }}
              </button>
            </li>
          </ul>
        </nav>
      </template>
  
      <!-- Dynamic Component Rendering Based on Selection -->
      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <component
            :is="components[activeComponent]"
            :preAuxiliaryCostCenters="preAuxiliaryCostCenters"
            :primaryOverheadCosts="primaryOverheadCosts"
            :allocationMatrix="allocationMatrix"
            @calculate="handleCalculation"
          ></component>
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

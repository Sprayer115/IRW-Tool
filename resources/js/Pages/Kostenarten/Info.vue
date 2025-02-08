<script>
import { ref, computed, watch, onMounted } from "vue";
import mermaid from "mermaid";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head,usePage, Link } from "@inertiajs/vue3";
import { Inertia } from '@inertiajs/inertia';

// Die Unterkomponenten importieren
import KA1 from "@/Pages/Kostenarten/1.vue";
import KA2 from "@/Pages/Kostenarten/2.vue";
import KA3 from "@/Pages/Kostenarten/3.vue";
import KA4 from "@/Pages/Kostenarten/4.vue";

const activeComponent = ref("KA1");

const components = {
  KA1,
  KA2,
  KA3,
  KA4,
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



const handleCalculation = (results) => {
    calculationResults.value = results;
    showResults.value = true;
    updateMermaidDiagram();
    renderMermaidDiagram();
};

// Initialize the allocation matrix
updateAllocationMatrix();
</script>

<!-- Kostenarten/Info.vue -->
<template>
  <AuthenticatedLayout>
      <Head title="Abweichungsanalyse Komplett" />
      <!-- Page Title and Navigation Buttons -->
      <template #header></template>
    <!-- Page Title and Navigation Buttons -->
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
  






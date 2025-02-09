<template>
  <AuthenticatedLayout>
    <Head title="Abweichungsanalyse Komplett" />
    <template #header></template>

    <!-- Page Content with Side Navigation -->
    <div class="py-12 bg-white dark:bg-white">

      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex">
        <!-- Side Navigation Panel -->
        <div class="w-1/6">
          <!-- "Pages" header above the navigation buttons -->
          <h3 class="font-bold mb-4">Seiten</h3>
          <nav>
            <ul class="flex flex-col space-y-4">
              <li v-for="component in Object.keys(registeredComponents)" :key="component">
                <button
                  @click="setActiveComponent(component)"
                  :class="[
                    'px-4 py-2 bg-transparent transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2',
                    activeComponent === component
                      ? 'text-blue-500 font-semibold'
                      : 'text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white'
                  ]"
                >
                  {{ component }}
                </button>
              </li>
            </ul>
          </nav>
        </div>

        <!-- Main Content Area -->
        <div class="w-3/4 pl-8">
          <!-- Dynamic Component Rendering -->
          <component
            :is="registeredComponents[activeComponent]"
            :preAuxiliaryCostCenters="preAuxiliaryCostCenters"
            :primaryOverheadCosts="primaryOverheadCosts"
            :allocationMatrix="allocationMatrix"
            @calculate="handleCalculation"
          ></component>
          <!-- Mermaid Diagram Container -->
          <div id="mermaid-container" class="mt-4"></div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script>
import { ref, watch, onMounted } from "vue";
import mermaid from "mermaid";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

import I from "@/Pages/Kostenstellen/1.vue";
import II from "@/Pages/Kostenstellen/2.vue";
import III from "@/Pages/Kostenstellen/3.vue";
import IV from "@/Pages/Kostenstellen/4.vue";

export default {
  name: 'InfoKostenarten',

  // Register the components so Vue knows about them.
  components: {
    I,
    II,
    III,
    IV,
  },

  setup() {
    // Reactive state variables
    const activeComponent = ref("I");
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

    // Mapping of registered components for dynamic rendering
    const registeredComponents = { I, II, III, IV };

    const setActiveComponent = (component) => {
      activeComponent.value = component;
    };

    // Create the Mermaid diagram source code
    const updateMermaidDiagram = () => {
      let diagramCode = "graph TD;\n";
      // You can add more Mermaid syntax here as needed.
      mermaidDiagram.value = diagramCode;
    };

    // Render the Mermaid diagram into the designated container
    const renderMermaidDiagram = async () => {
      try {
        const { svg } = await mermaid.render("mermaid-diagram", mermaidDiagram.value);
        const diagramContainer = document.getElementById("mermaid-container");
        if (diagramContainer) {
          diagramContainer.innerHTML = svg;
        }
      } catch (error) {
        console.error("Failed to render Mermaid diagram:", error);
      }
    };

    // Update the allocation matrix based on cost centers and overhead costs
    const updateAllocationMatrix = () => {
      preAuxiliaryCostCenters.value.forEach((costCenter) => {
        if (!allocationMatrix.value[costCenter.id]) {
          allocationMatrix.value[costCenter.id] = {};
        }
        preAuxiliaryCostCenters.value.forEach((targetCostCenter) => {
          if (
            costCenter.id !== targetCostCenter.id &&
            allocationMatrix.value[costCenter.id][targetCostCenter.id] === undefined
          ) {
            allocationMatrix.value[costCenter.id][targetCostCenter.id] = 0;
          }
        });
        primaryOverheadCosts.value.forEach((overheadCost) => {
          if (allocationMatrix.value[costCenter.id][`oc${overheadCost.id}`] === undefined) {
            allocationMatrix.value[costCenter.id][`oc${overheadCost.id}`] = 0;
          }
        });
      });
    };

    // Handle the calculation event and update the diagram accordingly.
    const handleCalculation = (results) => {
      calculationResults.value = results;
      showResults.value = true;
      updateMermaidDiagram();
      renderMermaidDiagram();
    };

    // Watch for changes in the cost centers, overhead costs, or allocation matrix
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
      updateAllocationMatrix();
    });

    return {
      activeComponent,
      preAuxiliaryCostCenters,
      primaryOverheadCosts,
      allocationMatrix,
      mermaidDiagram,
      calculationResults,
      showResults,
      setActiveComponent,
      handleCalculation,
      registeredComponents,
    };
  },
};
</script>

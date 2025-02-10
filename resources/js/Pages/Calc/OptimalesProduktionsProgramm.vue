<script setup>
import { ref, computed, watch, onMounted } from "vue";
import mermaid from "mermaid";
import { Head,usePage, Link } from "@inertiajs/vue3";
import { Inertia } from '@inertiajs/inertia';
import Deckungsbeitrag from "@/Pages/Calc/Deckungsbeitragrechnung.vue";
import Preisuntergrenze from "@/Pages/Calc/Preisuntergrenze.vue";

const props = defineProps({
  preAuxiliaryCostCenters: { type: Array, default: () => [] },
  primaryOverheadCosts: { type: Array, default: () => [] },
  allocationMatrix: { type: Object, default: () => ({}) },
  // Deine bisherigen Props:
  value: { default: null },
  items: { type: Array, default: () => [] },
});

const emit = defineEmits(['update:checked', 'calculate']);
  

const activeComponent = ref("Deckungsbeitrag");

const components = {
    Deckungsbeitrag,
    Preisuntergrenze,
};

const setActiveComponent = (component) => {
  activeComponent.value = component;
};

// Initialize the allocation matrix
</script>

<template>
      <!-- Page Title and Navigation Buttons -->
      <div >
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          Optimales Produktionsprogramm
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
      </div>
  
      <!-- Dynamic Component Rendering Based on Selection -->
      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <component
            :is="components[activeComponent]"
            :preAuxiliaryCostCenters="preAuxiliaryCostCenters"
            :primaryOverheadCosts="primaryOverheadCosts"
            :allocationMatrix="allocationMatrix"
          ></component>
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

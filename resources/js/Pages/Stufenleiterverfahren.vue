<script setup>
import { ref, computed } from 'vue';

const departments = ref([
  { name: 'Abteilung 1', primaryCosts: 0, allocation: { 'Abteilung 2': 0, 'Abteilung 3': 0 } },
  { name: 'Abteilung 2', primaryCosts: 0, allocation: { 'Abteilung 3': 0 } },
  { name: 'Abteilung 3', primaryCosts: 0, allocation: {} },
]);

const totalCosts = computed(() => {
  return departments.value.reduce((sum, dept) => sum + dept.primaryCosts, 0);
});

const calculate = () => {
  // Implement the Stufenleiterverfahren calculation logic here
  // This is a simplified example and may need to be adjusted based on specific requirements
  for (let i = 0; i < departments.value.length - 1; i++) {
    const currentDept = departments.value[i];
    const allocationSum = Object.values(currentDept.allocation).reduce((sum, value) => sum + value, 0);

    for (let j = i + 1; j < departments.value.length; j++) {
      const targetDept = departments.value[j];
      const allocationAmount = (currentDept.primaryCosts * currentDept.allocation[targetDept.name]) / 100;
      targetDept.primaryCosts += allocationAmount;
    }

    currentDept.primaryCosts -= (currentDept.primaryCosts * allocationSum) / 100;
  }
};
</script>

<template>
  <div>
    <h3 class="text-lg font-semibold mb-4">Stufenleiterverfahren</h3>
    
    <div v-for="dept in departments" :key="dept.name" class="mb-4">
      <h4 class="font-medium">{{ dept.name }}</h4>
      <div class="flex space-x-4">
        <div>
          <label class="block text-sm">Primärkosten</label>
          <input v-model.number="dept.primaryCosts" type="number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>
        <div v-for="(value, targetDept) in dept.allocation" :key="targetDept">
          <label class="block text-sm">Umlage auf {{ targetDept }}</label>
          <input v-model.number="dept.allocation[targetDept]" type="number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>
      </div>
    </div>

    <button @click="calculate" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
      Berechnen
    </button>

    <div class="mt-4">
      <h4 class="font-medium">Ergebnisse:</h4>
      <ul>
        <li v-for="dept in departments" :key="dept.name">
          {{ dept.name }}: {{ dept.primaryCosts.toFixed(2) }}
        </li>
      </ul>
      <p class="mt-2">Gesamtkosten: {{ totalCosts.toFixed(2) }}</p>
    </div>
  </div>
</template>
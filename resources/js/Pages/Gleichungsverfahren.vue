<script setup>
import { ref, computed } from 'vue';

const departments = ref([
  { name: 'Abteilung 1', primaryCosts: 0, allocation: { 'Abteilung 2': 0, 'Abteilung 3': 0 } },
  { name: 'Abteilung 2', primaryCosts: 0, allocation: { 'Abteilung 1': 0, 'Abteilung 3': 0 } },
  { name: 'Abteilung 3', primaryCosts: 0, allocation: { 'Abteilung 1': 0, 'Abteilung 2': 0 } },
]);

const totalCosts = computed(() => {
  return departments.value.reduce((sum, dept) => sum + dept.primaryCosts, 0);
});

const calculate = () => {
  // Implement the Gleichungsverfahren calculation logic here
  // This is a simplified example and may need to be adjusted based on specific requirements
  const n = departments.value.length;
  const matrix = [];
  const vector = [];

  for (let i = 0; i < n; i++) {
    matrix[i] = [];
    for (let j = 0; j < n; j++) {
      if (i === j) {
        matrix[i][j] = 1;
      } else {
        matrix[i][j] = -departments.value[j].allocation[departments.value[i].name] / 100;
      }
    }
    vector[i] = departments.value[i].primaryCosts;
  }

  // Solve the system of linear equations (simplified Gaussian elimination)
  for (let i = 0; i < n; i++) {
    for (let j = i + 1; j < n; j++) {
      const factor = matrix[j][i] / matrix[i][i];
      for (let k = i; k < n; k++) {
        matrix[j][k] -= factor * matrix[i][k];
      }
      vector[j] -= factor * vector[i];
    }
  }

  for (let i = n - 1; i >= 0; i--) {
    for (let j = i + 1; j < n; j++) {
      vector[i] -= matrix[i][j] * vector[j];
    }
    vector[i] /= matrix[i][i];
  }

  // Update department costs with the calculated values
  for (let i = 0; i < n; i++) {
    departments.value[i].primaryCosts = vector[i];
  }
};
</script>

<template>
  <div>
    <h3 class="text-lg font-semibold mb-4">Gleichungsverfahren</h3>
    
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
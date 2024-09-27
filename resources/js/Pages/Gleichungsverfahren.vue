<script setup>
import { computed } from 'vue';

const props = defineProps({
    preAuxiliaryCostCenters: Array,
    primaryOverheadCosts: Array,
    allocationMatrix: Object
});

const emit = defineEmits(['calculate']);

const performCalculations = () => {
    console.log("Starting Gleichungsverfahren calculations");
    console.log("Input data:", JSON.stringify(props, null, 2));

    const results = {};
    const costCenters = [...props.preAuxiliaryCostCenters];
    const n = costCenters.length;

    // Initialize results object
    costCenters.forEach((cc) => {
        results[cc.id] = {
            name: cc.name,
            primaryCosts: cc.value,
            allocations: {},
            secondaryCosts: 0,
            totalCosts: 0,
        };
    });

    props.primaryOverheadCosts.forEach((oc) => {
        results[`oc${oc.id}`] = {
            name: oc.name,
            primaryCosts: oc.value,
            allocations: {},
            secondaryCosts: 0,
            totalCosts: oc.value,
        };
    });

    console.log("Initialized results:", JSON.stringify(results, null, 2));

    // Calculate total allocations for each cost center
    const totalAllocations = {};
    costCenters.forEach((cc) => {
        totalAllocations[cc.id] = Object.values(props.allocationMatrix[cc.id]).reduce((sum, val) => sum + val, 0);
    });

    // Set up equations: K1 = PK1 + a21*K2, K2 = PK2 + a12*K1
    const A = Array(n).fill().map(() => Array(n).fill(0));
    const b = Array(n).fill(0);

    costCenters.forEach((cc, i) => {
        A[i][i] = 1; // Coefficient for Ki
        b[i] = cc.value; // PKi

        costCenters.forEach((otherCC, j) => {
            if (i !== j) {
                // aij is the proportion of costs transferred from j to i
                A[i][j] = -props.allocationMatrix[otherCC.id][cc.id] / totalAllocations[otherCC.id];
            }
        });
    });

    // Solve system of linear equations
    const totalCosts = gaussianElimination(A, b);

    // Update results with solved values and calculate allocations
    costCenters.forEach((cc, i) => {
        results[cc.id].totalCosts = totalCosts[i];
        
        Object.entries(props.allocationMatrix[cc.id]).forEach(([targetId, allocation]) => {
            const allocationAmount = (allocation / totalAllocations[cc.id]) * totalCosts[i];
            results[cc.id].allocations[targetId] = allocationAmount;

            if (targetId.startsWith('oc')) {
                results[targetId].secondaryCosts += allocationAmount;
                results[targetId].totalCosts += allocationAmount;
            } else {
                results[targetId].secondaryCosts += allocationAmount;
            }
        });
    });

    console.log("Final results:", JSON.stringify(results, null, 2));

    emit('calculate', results);
};

const gaussianElimination = (A, b) => {
    const n = A.length;

    for (let i = 0; i < n; i++) {
        // Find pivot
        let maxEl = Math.abs(A[i][i]);
        let maxRow = i;
        for (let k = i + 1; k < n; k++) {
            if (Math.abs(A[k][i]) > maxEl) {
                maxEl = Math.abs(A[k][i]);
                maxRow = k;
            }
        }

        // Swap maximum row with current row
        [A[i], A[maxRow]] = [A[maxRow], A[i]];
        [b[i], b[maxRow]] = [b[maxRow], b[i]];

        // Make all rows below this one 0 in current column
        for (let k = i + 1; k < n; k++) {
            const c = -A[k][i] / A[i][i];
            for (let j = i; j < n; j++) {
                if (i === j) {
                    A[k][j] = 0;
                } else {
                    A[k][j] += c * A[i][j];
                }
            }
            b[k] += c * b[i];
        }
    }

    // Solve equation Ax=b using back substitution
    const x = new Array(n).fill(0);
    for (let i = n - 1; i >= 0; i--) {
        x[i] = b[i] / A[i][i];
        for (let k = i - 1; k >= 0; k--) {
            b[k] -= A[k][i] * x[i];
        }
    }
    return x;
};

const calculate = () => {
    try {
        performCalculations();
    } catch (error) {
        console.error("Error in calculation:", error);
        console.error("Error details:", error.message, error.stack);
    }
};
</script>

<template>
    <div>
        <h2 class="text-2xl font-bold mb-6">Gleichungsverfahren</h2>
        <button
            @click="calculate"
            class="mt-4 p-2 bg-green-500 text-white rounded hover:bg-blue-600"
        >
            Berechnen
        </button>
    </div>
</template>
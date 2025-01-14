<script setup>
import { computed } from 'vue';

const props = defineProps({
    preAuxiliaryCostCenters: Array,
    primaryOverheadCosts: Array,
    allocationMatrix: Object
});

const emit = defineEmits(['calculate']);

const sortedCostCenters = computed(() => {
    return [...props.preAuxiliaryCostCenters].sort((a, b) => a.order - b.order);
});

const performCalculations = () => {
    console.log("Starting calculations");
    console.log("Input data:", JSON.stringify(props, null, 2));

    const results = {};

    // Initialize results object
    sortedCostCenters.value.forEach((cc) => {
        results[cc.id] = {
            name: cc.name,
            primaryCosts: cc.value,
            allocations: {},
            secondaryCosts: 0,
            totalCosts: cc.value,
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

    // Calculate allocations
    sortedCostCenters.value.forEach((currentCC, index) => {
        console.log(`Processing cost center: ${currentCC.name}`);

        const currentCCId = currentCC.id.toString();
        const totalUnits = Object.values(props.allocationMatrix[currentCCId]).reduce((sum, value) => sum + value, 0);

        console.log(`Total units for ${currentCC.name}: ${totalUnits}`);

        if (totalUnits > 0) {
            Object.entries(props.allocationMatrix[currentCCId]).forEach(([targetId, units]) => {
                const allocationAmount = results[currentCCId].totalCosts * (units / totalUnits);
                console.log(`Allocating ${allocationAmount} to ${targetId}`);

                results[currentCCId].allocations[targetId] = allocationAmount;

                if (targetId.startsWith('oc')) {
                    results[targetId].secondaryCosts += allocationAmount;
                    results[targetId].totalCosts += allocationAmount;
                } else {
                    results[targetId].secondaryCosts += allocationAmount;
                    results[targetId].totalCosts += allocationAmount;
                }
            });

            results[currentCCId].totalCosts = 0;
        }

        console.log(`After processing ${currentCC.name}:`, JSON.stringify(results, null, 2));
    });

    console.log("Final results:", JSON.stringify(results, null, 2));

    emit('calculate', results);
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
        <h2 class="text-2xl font-bold mb-6">Stufenleiterverfahren</h2>
        <button
            @click="calculate"
            class="mt-4 p-2 bg-green-500 text-white rounded hover:bg-blue-600"
        >
            Berechnen
        </button>
    </div>
</template>
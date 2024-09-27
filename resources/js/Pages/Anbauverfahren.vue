<script setup>
import { computed } from 'vue';

const props = defineProps({
    preAuxiliaryCostCenters: Array,
    primaryOverheadCosts: Array,
    allocationMatrix: Object
});

const emit = defineEmits(['calculate']);

const performCalculations = () => {
    console.log("PreAuxiliaryCostCenters:", props.preAuxiliaryCostCenters);
    console.log("primaryOverheadCosts", props.primaryOverheadCosts);
    console.log("allocationMatrix", props.allocationMatrix);

    const results = {};

    // Initialize results object
    props.preAuxiliaryCostCenters.forEach((cc) => {
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

    // Calculate allocations
    props.preAuxiliaryCostCenters.forEach((cc) => {
        const totalUnits = Object.values(props.allocationMatrix[cc.id]).reduce((sum, value) => sum + value, 0);

        Object.entries(props.allocationMatrix[cc.id]).forEach(([targetId, units]) => {
            if (totalUnits > 0) {
                const allocationAmount = cc.value * (units / totalUnits);
                results[cc.id].allocations[targetId] = allocationAmount;

                if (targetId.startsWith('oc')) {
                    results[targetId].secondaryCosts += allocationAmount;
                    results[targetId].totalCosts += allocationAmount;
                } else {
                    results[targetId].secondaryCosts += allocationAmount;
                }
            }
        });

        // Set total costs to 0 after allocation
        results[cc.id].totalCosts = 0;
    });

    console.log(results);
    emit('calculate', results);
};

const calculate = () => {
    performCalculations();
};
</script>

<template>
    <div>
        <h2 class="text-2xl font-bold mb-6">Anbauverfahren</h2>
        
        <button
            @click="calculate"
            class="mt-4 p-2 bg-green-500 text-white rounded hover:bg-green-600"
        >
            Berechnen
        </button>
    </div>
</template>
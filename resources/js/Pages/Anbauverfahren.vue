<script setup>
import { computed } from 'vue';

const props = defineProps({
    preAuxiliaryCostCenters: Array,
    primaryOverheadCosts: Array,
    allocationMatrix: Object
});

const emit = defineEmits(['calculate']);

const performCalculations = () => {
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
        const totalUnits = props.primaryOverheadCosts.reduce((sum, oc) => 
            sum + (props.allocationMatrix[cc.id]?.[oc.id] || 0), 0);

        props.primaryOverheadCosts.forEach((oc) => {
            const units = props.allocationMatrix[cc.id]?.[oc.id] || 0;
            if (totalUnits > 0) {
                const allocationAmount = cc.value * (units / totalUnits);
                results[cc.id].allocations[`oc${oc.id}`] = allocationAmount;
                results[`oc${oc.id}`].secondaryCosts += allocationAmount;
                results[`oc${oc.id}`].totalCosts += allocationAmount;
            }
        });
    });

    // Set Vor-Hilfskostenstellen total costs to 0 after allocation
    props.preAuxiliaryCostCenters.forEach((cc) => {
        results[cc.id].totalCosts = 0;
    });

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
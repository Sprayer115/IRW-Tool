<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref, computed, watch } from "vue";

// Fixed costs
const internalFixedCost = ref(0);
const externalFixedCost = ref(0);

// Variable costs
const externalVariableCost = ref(0);
const internalAmount = ref(0);
const internalVariableCosts = ref(0);

// Units and max units
const units = ref(1);
const maxUnitsValue = ref(100000);

// Watch for changes in maxUnitsValue and adjust units if necessary
watch(maxUnitsValue, (newMax) => {
    if (units.value > newMax) {
        units.value = newMax;
    }
});

// Computed properties
const internalVariableCost = computed(() => {
    return internalVariableCosts.value / internalAmount.value;
});

const totalInternalCost = computed(() => {
    return internalFixedCost.value + internalVariableCost.value * units.value;
});

const totalExternalCost = computed(() => {
    return externalFixedCost.value + externalVariableCost.value * units.value;
});

const costDifference = computed(() => {
    return totalInternalCost.value - totalExternalCost.value;
});

const decision = computed(() => {
    return costDifference.value > 0
        ? "Kaufen"
        : costDifference.value == 0
        ? "Kaufen/Selbst herstellen"
        : "Selbst herstellen";
});

const breakEvenPoint = computed(() => {
    if (
        internalVariableCost.value === externalVariableCost.value
    ) {
        return "N/A";
    }
    const fixedCostDifference =
        externalFixedCost.value - internalFixedCost.value;
    const variableCostDifference =
        internalVariableCost.value - externalVariableCost.value;
    return Math.ceil(fixedCostDifference / variableCostDifference);
});

const setUnit = () => {
    units.value = internalAmount.value;
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Make-or-Buy Kalkulator" />

        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Make-or-Buy Kalkulator
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="make-or-buy-container">
                            <h2 class="title">Make-or-Buy-Entscheidung</h2>
                            <div class="input-area">
                                <div class="input-group">
                                    <label for="internalFixedCost"
                                        >Fix Plankosten:</label
                                    >
                                    <input
                                        v-model.number="internalFixedCost"
                                        type="number"
                                        id="internalFixedCost"
                                        class="input-field"
                                    />
                                    <span class="tooltip-container">
                                        <sup class="information">i</sup>
                                        <span class="tooltip-text"
                                            >Fixkosten für die interne
                                            Produktion(Summe aller
                                            Kostenarten)</span
                                        >
                                    </span>
                                </div>

                                <div class="input-group">
                                    <label for="internalVariableCost"
                                        >Variable Plankosten:</label
                                    >
                                    <input
                                        v-model.number="internalVariableCosts"
                                        type="number"
                                        id="internalVariableCost"
                                        class="input-field"
                                    />
                                    <span class="tooltip-container">
                                        <sup class="information">i</sup>
                                        <span class="tooltip-text"
                                            >Variable Plankosten für alle
                                            Einheiten (Summe aller
                                            Kostenarten)</span
                                        >
                                    </span>
                                </div>

                                <div class="input-group">
                                    <label for="internalAmount"
                                        >Anzahl Einheiten:</label
                                    >
                                    <input
                                        v-model.number="internalAmount"
                                        type="number"
                                        id="internalAmount"
                                        class="input-field"
                                        v-on:change="setUnit()"
                                    />
                                    <span class="tooltip-container">
                                        <sup class="information">i</sup>
                                        <span class="tooltip-text"
                                            >Anzahl Einheiten, für welche die
                                            variablen Plankosten gelten</span
                                        >
                                    </span>
                                </div>

                                <div class="input-group">
                                    <label for="externalFixedCost"
                                        >Anschaffungskosten:</label
                                    >
                                    <input
                                        v-model.number="externalFixedCost"
                                        type="number"
                                        id="externalFixedCost"
                                        class="input-field"
                                    />
                                    <span class="tooltip-container">
                                        <sup class="information">i</sup>
                                        <span class="tooltip-text"
                                            >Fixkosten für den externen
                                            Kauf</span
                                        >
                                    </span>
                                </div>

                                <div class="input-group">
                                    <label for="externalVariableCost"
                                        >Variable Kosten bei Kauf (pro
                                        Einheit):</label
                                    >
                                    <input
                                        v-model.number="externalVariableCost"
                                        type="number"
                                        id="externalVariableCost"
                                        class="input-field"
                                    />
                                    <span class="tooltip-container">
                                        <sup class="information">i</sup>
                                        <span class="tooltip-text"
                                            >Variable Kosten pro Einheit für
                                            externen Kauf</span
                                        >
                                    </span>
                                </div>

                                <div
                                    class="input-group flex items-center justify-between"
                                >
                                    <div class="flex-grow mr-4">
                                        <label for="units" class="block mb-1"
                                            >Anzahl der Einheiten:</label
                                        >
                                        <div class="flex items-center">
                                            <input
                                                v-model.number="units"
                                                type="number"
                                                :min="1"
                                                :max="maxUnitsValue"
                                                id="units"
                                                class="w-20 p-1 border rounded mr-2"
                                            />
                                            <input
                                                v-model.number="units"
                                                type="range"
                                                :min="1"
                                                :max="maxUnitsValue"
                                                class="flex-grow"
                                            />
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <label for="maxUnitsValue" class="mr-2"
                                            >Max:</label
                                        >
                                        <select
                                            v-model.number="maxUnitsValue"
                                            id="maxUnitsValue"
                                            class="p-1 border rounded w-32"
                                        >
                                            <option :value="1000">1,000</option>
                                            <option :value="10000">
                                                10,000
                                            </option>
                                            <option :value="100000">
                                                100,000
                                            </option>
                                            <option :value="1000000">
                                                1,000,000
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="result-area">
                                <h3 class="result-title">
                                    Ergebnis der Make-or-Buy-Entscheidung
                                </h3>
                                <p class="result-item">
                                    Make
                                    <span class="tooltip-container">
                                        <sup class="information">i</sup>
                                        <span class="tooltip-text"
                                            >Fix Plankosten + variable
                                            Plankosten</span
                                        >
                                    </span>
                                    :
                                    <span class="highlight">{{
                                        totalInternalCost
                                    }}</span>
                                </p>

                                <p class="result-item">
                                    Buy
                                    <span class="tooltip-container">
                                        <sup class="information">i</sup>
                                        <span class="tooltip-text"
                                            >Anzahl Einheiten * Kosten pro
                                            Einheit</span
                                        >
                                    </span>
                                    :
                                    <span class="highlight">{{
                                        totalExternalCost
                                    }}</span>
                                </p>

                                <p class="result-item">
                                    Kostendifferenz:
                                    <span class="highlight">{{
                                        costDifference
                                    }}</span>
                                </p>
                                <p class="result-item">
                                    Empfehlung:
                                    <span class="highlight">{{
                                        decision
                                    }}</span>
                                </p>
                                <p class="result-item">
                                    Kritische Menge (Einheiten):
                                    <span class="highlight">{{
                                        breakEvenPoint
                                    }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.make-or-buy-container {
    margin-top: 20px !important;
    max-width: 500px;
    margin: 0 auto;
    padding: 20px;
    background-color: #bfdbfe;
    border-radius: 5px;
    color: #374151;
}

.title {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
}

.input-area {
    margin-bottom: 20px;
}

.input-group {
    margin-bottom: 10px;
}

label {
    display: block;
    font-weight: bold;
}

.input-field {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.result-area {
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
}

.result-title {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 10px;
}

.result-item {
    margin-bottom: 5px;
}

.highlight {
    font-weight: bold;
    color: #007bff;
}

.tooltip-container {
    position: relative;
    display: inline-block;
    cursor: pointer;
}

.information {
    border: 1px solid;
    border-radius: 50%;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    width: 10px;
    height: 10px;
    font-size: 8px;
    margin-left: 1px;
}

.tooltip-text {
    visibility: hidden;
    background-color: #000;
    color: #fff;
    text-align: center;
    border-radius: 5px;
    padding: 5px;
    position: absolute;
    z-index: 1;
    bottom: 150%;
    left: 50%;
    transform: translateX(-50%);
    opacity: 0;
    transition: opacity 0.5s ease-in-out;
    white-space: nowrap;
}

.tooltip-container:hover .tooltip-text {
    visibility: visible;
    opacity: 1;
    transition-delay: 0.1s;
}

.input-group {
    margin-bottom: 10px;
}

/* Add these new styles */
.flex {
    display: flex;
}

.items-center {
    align-items: center;
}

.justify-between {
    justify-content: space-between;
}

.flex-grow {
    flex-grow: 1;
}

.mr-4 {
    margin-right: 1rem;
}

.mr-2 {
    margin-right: 0.5rem;
}

.p-1 {
    padding: 0.25rem;
}

.border {
    border-width: 1px;
}

.rounded {
    border-radius: 0.25rem;
}
.w-32 {
    width: 8rem;
}
</style>

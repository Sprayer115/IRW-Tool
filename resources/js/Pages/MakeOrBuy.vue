<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref, computed, onMounted } from "vue";
import axios from "axios";
/**
 * Interne Produktionskosten
 * @type {Ref<number>}
 */
const internalCost = ref(0);

/**
 * Externe Beschaffungskosten
 * @type {Ref<number>}
 */
const externalCost = ref(0);

/**
 * Opportunitätskosten
 * @type {Ref<number>}
 */
const opportunityCost = ref(0);

/**
 * Qualitätsunterschied
 * @type {Ref<number>}
 */
const qualityDifference = ref(0);

/**
 * Flexibilitätsauswirkung
 * @type {Ref<number>}
 */
const flexibilityImpact = ref(0);

/**
 * Empfohlene Entscheidung
 * @type {Ref<string>}
 */
const decision = ref("");

/**
 * Kostendifferenz
 * @type {Ref<number>}
 */
const costDifference = ref(0);

/**
 * Bereinigte Kostendifferenz
 * @type {Ref<number>}
 */
const adjustedCostDifference = ref(0);

/**
 * Berechnet die Make-or-Buy-Entscheidung basierend auf den eingegebenen Werten
 */
function calculateDecision() {
    costDifference.value = internalCost.value - externalCost.value;

    adjustedCostDifference.value =
        costDifference.value +
        opportunityCost.value +
        qualityDifference.value +
        flexibilityImpact.value;

    if (adjustedCostDifference.value < 0) {
        decision.value = "Kaufen";
    } else {
        decision.value = "Selbst herstellen";
    }
}
</script>
<template>
    <div>
        <Head title="Abweichungsanalyse"> </Head>
<div style="color:red">
    TODO:
    - Remove Opportunitätskosten and not used values
    - Add a second "Tab" for calculation with not fixed external cost and more by x cost
</div>
        <AuthenticatedLayout>
            <template #header>
                <h2
                    class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
                >
                    Abweichungsanalyse
                </h2>
            </template>
            <div class="make-or-buy-container">
                <h2 class="title">Make-or-Buy-Entscheidung</h2>
                <div class="input-area">
                    <div class="input-group">
                        <label for="internalCost"
                            >Interne Produktionskosten:</label
                        >
                        <input
                            type="number"
                            v-model="internalCost"
                            id="internalCost"
                            class="input-field"
                        />
                        <span class="tooltip-container">
                            <sup class="information">i</sup>
                            <span class="tooltip-text"
                                >Kosten für die interne Produktion des
                                Artikels</span
                            >
                        </span>
                    </div>

                    <div class="input-group">
                        <label for="externalCost"
                            >Externe Beschaffungskosten:</label
                        >
                        <input
                            type="number"
                            v-model="externalCost"
                            id="externalCost"
                            class="input-field"
                        />
                        <span class="tooltip-container">
                            <sup class="information">i</sup>
                            <span class="tooltip-text"
                                >Kosten für den Kauf des Artikels von einem
                                externen Lieferanten</span
                            >
                        </span>
                    </div>

                    <div class="input-group">
                        <label for="opportunityCost"
                            >Opportunitätskosten:</label
                        >
                        <input
                            type="number"
                            v-model="opportunityCost"
                            id="opportunityCost"
                            class="input-field"
                        />
                        <span class="tooltip-container">
                            <sup class="information">i</sup>
                            <span class="tooltip-text"
                                >Potenzieller entgangener Nutzen durch die Wahl
                                einer Option gegenüber einer anderen</span
                            >
                        </span>
                    </div>

                    <div class="input-group">
                        <label for="qualityDifference"
                            >Qualitätsunterschied:</label
                        >
                        <input
                            type="number"
                            v-model="qualityDifference"
                            id="qualityDifference"
                            class="input-field"
                        />
                        <span class="tooltip-container">
                            <sup class="information">i</sup>
                            <span class="tooltip-text"
                                >Unterschied in der Qualität zwischen dem intern
                                produzierten und dem extern gekauften
                                Artikel</span
                            >
                        </span>
                    </div>

                    <div class="input-group">
                        <label for="flexibilityImpact"
                            >Flexibilitätsauswirkung:</label
                        >
                        <input
                            type="number"
                            v-model="flexibilityImpact"
                            id="flexibilityImpact"
                            class="input-field"
                        />
                        <span class="tooltip-container">
                            <sup class="information">i</sup>
                            <span class="tooltip-text"
                                >Auswirkung auf die Flexibilität durch die
                                Entscheidung für Make oder Buy</span
                            >
                        </span>
                    </div>

                    <button @click="calculateDecision" class="calculate-button">
                        Entscheidung berechnen
                    </button>
                </div>

                <div class="result-area">
                    <h3 class="result-title">
                        Ergebnis der Make-or-Buy-Entscheidung
                    </h3>
                    <p class="result-item">
                        Empfohlene Entscheidung:
                        <span class="highlight">{{ decision }}</span>
                    </p>
                    <p class="result-item">
                        Kostendifferenz:
                        <span class="highlight">{{ costDifference }}</span>
                    </p>
                    <p class="result-item">
                        Bereinigte Kostendifferenz:
                        <span class="highlight">{{
                            adjustedCostDifference
                        }}</span>
                    </p>
                </div>
            </div>
        </AuthenticatedLayout>
    </div>
</template>



<style scoped>
.make-or-buy-container {
    margin-top: 20px !important;
    max-width: 500px;
    margin: 0 auto;
    padding: 20px;
    background-color: #c4b5fd;
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

.calculate-button {
    display: block;
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
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
</style>

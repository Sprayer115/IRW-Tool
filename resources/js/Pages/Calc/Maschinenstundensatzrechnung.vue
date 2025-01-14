<script setup>
import { ref, computed, onMounted } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";


// Input fields
const anschaffungskosten = ref(0);
const wiederbeschaffungskosten = ref(0);
const nutzungsdauer = ref(1);
const zinssatz = ref(0);
const raumflaeche = ref(0);
const raumkostenProQm = ref(0);
const energieverbrauch = ref(0);
const energiekostenProKwh = ref(0);
const instandhaltungskostenProzent = ref(0);
const instandhaltungskostenFix = ref(0);
const useFixedInstandhaltungskosten = ref(false);
const hilfsstoffe = ref(0);
const personalkosten = ref(0);

// New input fields for Maschinenlaufzeit calculation
const arbeitsTageProJahr = ref(220); // Default value: 220 working days per year
const stundenProTag = ref(8); // Default value: 8 hours per day
const instandhaltungsProzent = ref(0);

// Computed properties for calculations
const abschreibungsBasis = computed(() =>
    wiederbeschaffungskosten.value > 0
        ? wiederbeschaffungskosten.value
        : anschaffungskosten.value
);
const abschreibung = computed(
    () => abschreibungsBasis.value / nutzungsdauer.value
);
const zinsen = computed(
    () =>
        (((wiederbeschaffungskosten.value > 0
            ? wiederbeschaffungskosten.value
            : anschaffungskosten.value) /
            2) *
            zinssatz.value) /
        100
);
const raumkosten = computed(() => raumflaeche.value * raumkostenProQm.value);
const instandhaltungskosten = computed(() => {
    if (useFixedInstandhaltungskosten.value) {
        return instandhaltungskostenFix.value;
    } else {
        return (
            (anschaffungskosten.value * instandhaltungskostenProzent.value) /
            100
        );
    }
});

// New computed property for Maschinenlaufzeit
const maschinenlaufzeit = computed(() => {
    const totalHours = arbeitsTageProJahr.value * stundenProTag.value;
    return totalHours * (1 - instandhaltungsProzent.value / 100);
});

const energiekosten = computed(
    () =>
        energieverbrauch.value *
        maschinenlaufzeit.value *
        energiekostenProKwh.value
);

const fixkosten = computed(
    () => abschreibung.value + zinsen.value + raumkosten.value
);
const variableKosten = computed(
    () =>
        energiekosten.value +
        instandhaltungskosten.value +
        hilfsstoffe.value +
        personalkosten.value
);
const gesamtkosten = computed(() => fixkosten.value + variableKosten.value);
const maschinenstundensatz = computed(
    () => gesamtkosten.value / maschinenlaufzeit.value
);

// Aktualisierte Hilfsfunktion zur Formatierung der Zahlen
const formatNumber = (num) => {
    return num
        .toFixed(2)
        .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        .replace(".", ",");
};

// Hilfsfunktion zur Erstellung von Brüchen
const createFraction = (numerator, denominator) => {
    return `<span class="fraction"><span class="numerator">${numerator}</span><span class="denominator"> / ${denominator}</span></span>`;
};

// Aktualisierte berechnete Eigenschaften für detaillierte Berechnungsanzeige
const abschreibungFormel = computed(() => {
    const basis = wiederbeschaffungskosten.value > 0 ? "WBK" : "AK";
    return `Abschreibung = ${basis} / ND = ${createFraction(
        formatNumber(abschreibungsBasis.value),
        nutzungsdauer.value
    )} = ${formatNumber(abschreibung.value)} €/Jahr`;
});

const zinsenFormel = computed(() => {
    const basis = wiederbeschaffungskosten.value > 0 ? "WBK" : "AK";
    return `Zinsen = (${basis} / 2) * ZS / 100 = ${createFraction(
        `(${formatNumber(abschreibungsBasis.value)} / 2) * ${zinssatz.value}`,
        "100"
    )} = ${formatNumber(zinsen.value)} €/Jahr`;
});

const raumkostenFormel = computed(() => {
    return `Raumkosten = RF * RK = ${formatNumber(
        raumflaeche.value
    )} * ${formatNumber(raumkostenProQm.value)} = ${formatNumber(
        raumkosten.value
    )} €/Jahr`;
});

const maschinenlaufzeitFormel = computed(() => {
    const totalHours = arbeitsTageProJahr.value * stundenProTag.value;
    return `Maschinenlaufzeit = ATJ * SPT * (1 - IP / 100) = ${formatNumber(
        arbeitsTageProJahr.value
    )} * ${formatNumber(stundenProTag.value)} * (1 - ${createFraction(
        instandhaltungsProzent.value,
        "100"
    )}) = ${formatNumber(maschinenlaufzeit.value)} Stunden/Jahr`;
});

const energiekostenFormel = computed(() => {
    return `Energiekosten = EV * ML * EPK = ${formatNumber(
        energieverbrauch.value
    )} * ${formatNumber(maschinenlaufzeit.value)} * ${formatNumber(
        energiekostenProKwh.value
    )} = ${formatNumber(energiekosten.value)} €/Jahr`;
});

const instandhaltungskostenFormel = computed(() => {
    if (useFixedInstandhaltungskosten.value) {
        return `Instandhaltungskosten = ${formatNumber(
            instandhaltungskostenFix.value
        )} €/Jahr`;
    } else {
        return `Instandhaltungskosten = AK * IKP / 100 = ${createFraction(
            `${formatNumber(anschaffungskosten.value)} * ${
                instandhaltungskostenProzent.value
            }`,
            "100"
        )} = ${formatNumber(instandhaltungskosten.value)} €/Jahr`;
    }
});

const fixkostenFormel = computed(() => {
    return `Fixkosten = Abschreibung + Zinsen + Raumkosten = ${formatNumber(
        abschreibung.value
    )} + ${formatNumber(zinsen.value)} + ${formatNumber(
        raumkosten.value
    )} = ${formatNumber(fixkosten.value)} €/Jahr`;
});

const variableKostenFormel = computed(() => {
    return `Variable Kosten = Energiekosten + Instandhaltungskosten + Hilfsstoffe + Personalkosten = ${formatNumber(
        energiekosten.value
    )} + ${formatNumber(instandhaltungskosten.value)} + ${formatNumber(
        hilfsstoffe.value
    )} + ${formatNumber(personalkosten.value)} = ${formatNumber(
        variableKosten.value
    )} €/Jahr`;
});

const gesamtkostenFormel = computed(() => {
    return `Gesamtkosten = Fixkosten + Variable Kosten = ${formatNumber(
        fixkosten.value
    )} + ${formatNumber(variableKosten.value)} = ${formatNumber(
        gesamtkosten.value
    )} €/Jahr`;
});

const maschinenstundensatzFormel = computed(() => {
    return `Maschinenstundensatz = Gesamtkosten / Maschinenlaufzeit = ${createFraction(
        formatNumber(gesamtkosten.value),
        formatNumber(maschinenlaufzeit.value)
    )} = ${formatNumber(maschinenstundensatz.value)} €/Stunde`;
});

// Function to handle form submission
const calculateMaschinenstundensatz = () => {
    console.log("Maschinenstundensatz berechnet:", maschinenstundensatz.value);
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Maschinenstundensatzrechnung" />

        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Maschinenstundensatzrechnung
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white2 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="maschinenstundensatz-container">
                            <img
                                src="/storage/Maschinenstundensatzrechnung.jpeg"
                                alt="Maschinenstundensatzrechnung"
                                class="w-full mb-6"
                            />

                            <form
                                @submit.prevent="calculateMaschinenstundensatz"
                                class="grid grid-cols-2 gap-4"
                            >
                                <!-- Existing input fields -->
                                <div class="input-group">
                                    <label for="anschaffungskosten"
                                        >Anschaffungskosten (€)*</label
                                    >
                                    <input
                                        v-model.number="anschaffungskosten"
                                        type="number"
                                        id="anschaffungskosten"
                                        required
                                    />
                                </div>

                                <div class="input-group">
                                    <label for="wiederbeschaffungskosten"
                                        >Wiederbeschaffungskosten (€)</label
                                    >
                                    <input
                                        v-model.number="
                                            wiederbeschaffungskosten
                                        "
                                        type="number"
                                        id="wiederbeschaffungskosten"
                                    />
                                </div>

                                <div class="input-group">
                                    <label for="nutzungsdauer"
                                        >Voraussichtliche Nutzungsdauer
                                        (Jahre)*</label
                                    >
                                    <input
                                        v-model.number="nutzungsdauer"
                                        type="number"
                                        id="nutzungsdauer"
                                        required
                                        min="1"
                                    />
                                </div>

                                <div class="input-group">
                                    <label for="zinssatz">Zinssatz (%)</label>
                                    <input
                                        v-model.number="zinssatz"
                                        type="number"
                                        id="zinssatz"
                                    />
                                </div>

                                <div class="input-group">
                                    <label for="raumflaeche"
                                        >Raumfläche (m²)</label
                                    >
                                    <input
                                        v-model.number="raumflaeche"
                                        type="number"
                                        id="raumflaeche"
                                    />
                                </div>

                                <div class="input-group">
                                    <label for="raumkostenProQm"
                                        >Raumkosten (€/m²/Jahr)</label
                                    >
                                    <input
                                        v-model.number="raumkostenProQm"
                                        type="number"
                                        id="raumkostenProQm"
                                    />
                                </div>

                                <div class="input-group">
                                    <label for="energieverbrauch"
                                        >Energieverbrauch (kW/h)</label
                                    >
                                    <input
                                        v-model.number="energieverbrauch"
                                        type="number"
                                        id="energieverbrauch"
                                    />
                                </div>

                                <div class="input-group">
                                    <label for="energiekostenProKwh"
                                        >Energiekosten (€/kWh)</label
                                    >
                                    <input
                                        v-model.number="energiekostenProKwh"
                                        type="number"
                                        step="0.01"
                                        id="energiekostenProKwh"
                                    />
                                </div>

                                <div class="input-group">
                                    <label for="instandhaltungskosten"
                                        >Instandhaltungskosten
                                        <span
                                            v-if="useFixedInstandhaltungskosten"
                                            >(€/Jahr)</span
                                        >
                                        <span v-else>(%)</span></label
                                    >
                                    <div class="flex items-center">
                                        <input
                                            v-model="
                                                useFixedInstandhaltungskosten
                                            "
                                            type="checkbox"
                                            id="useFixedInstandhaltungskosten"
                                            class="mr-2"
                                        />
                                        <label
                                            for="useFixedInstandhaltungskosten"
                                            >Fixer Betrag</label
                                        >
                                    </div>
                                    <input
                                        v-if="useFixedInstandhaltungskosten"
                                        v-model.number="
                                            instandhaltungskostenFix
                                        "
                                        type="number"
                                        step="0.1"
                                        id="instandhaltungskostenFix"
                                        placeholder="€/Jahr"
                                    />
                                    <input
                                        v-else
                                        v-model.number="
                                            instandhaltungskostenProzent
                                        "
                                        type="number"
                                        id="instandhaltungskostenProzent"
                                        step="0.1"
                                        placeholder="% der Anschaffungskosten"
                                    />
                                </div>

                                <div class="input-group">
                                    <label for="hilfsstoffe"
                                        >Hilfsstoffe (€/Jahr)</label
                                    >
                                    <input
                                        v-model.number="hilfsstoffe"
                                        type="number"
                                        id="hilfsstoffe"
                                    />
                                </div>

                                <div class="input-group">
                                    <label for="personalkosten"
                                        >Personalkosten (€/Jahr)</label
                                    >
                                    <input
                                        v-model.number="personalkosten"
                                        type="number"
                                        id="personalkosten"
                                    />
                                </div>

                                <!-- New input fields for Maschinenlaufzeit calculation -->
                                <div class="input-group">
                                    <label for="arbeitsTageProJahr"
                                        >Arbeitstage pro Jahr</label
                                    >
                                    <input
                                        v-model.number="arbeitsTageProJahr"
                                        type="number"
                                        id="arbeitsTageProJahr"
                                        min="1"
                                    />
                                </div>

                                <div class="input-group">
                                    <label for="stundenProTag"
                                        >Stunden pro Tag</label
                                    >
                                    <input
                                        v-model.number="stundenProTag"
                                        type="number"
                                        id="stundenProTag"
                                        min="0"
                                        max="24"
                                    />
                                </div>

                                <div class="input-group">
                                    <label for="instandhaltungsProzent"
                                        >Instandhaltungs-/Ruhezeit (%)</label
                                    >
                                    <input
                                        v-model.number="instandhaltungsProzent"
                                        type="number"
                                        id="instandhaltungsProzent"
                                        min="0"
                                        max="100"
                                    />
                                </div>

                                <div class="col-span-2">
                                    <button
                                        type="submit"
                                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                                    >
                                        Berechnen
                                    </button>
                                </div>
                            </form>

                            <div
                                v-if="maschinenstundensatz > 0"
                                class="mt-8 p-4 rounded"
                            >
                                <h3 class="text-lg font-bold mb-4">
                                    Berechnungsergebnisse:
                                </h3>

                                <div class="mb-4">
                                    <h4 class="font-bold">
                                        Detaillierte Berechnungen:
                                        <span class="tooltip-container">
                                            <sup class="information">i</sup>
                                            <span class="tooltip-text">
                                                Abkürzungen in den Formeln:<br /><br />
                                                AK: Anschaffungskosten<br />
                                                WBK: Wiederbeschaffungskosten<br />
                                                ND: Nutzungsdauer<br />
                                                ZS: Zinssatz<br />
                                                RF: Raumfläche<br />
                                                RK: Raumkosten pro
                                                Quadratmeter<br />
                                                ATJ: Arbeitstage pro Jahr<br />
                                                SPT: Stunden pro Tag<br />
                                                IP: Instandhaltungsprozent<br />
                                                EV: Energieverbrauch<br />
                                                ML: Maschinenlaufzeit<br />
                                                EPK: Energiekosten pro kWh<br />
                                                IKP:
                                                Instandhaltungskostenprozent
                                            </span>
                                        </span>
                                    </h4>
                                    <p
                                        class="whitespace-pre-wrap"
                                        v-html="abschreibungFormel"
                                    ></p>
                                    <p
                                        class="whitespace-pre-wrap"
                                        v-html="zinsenFormel"
                                    ></p>
                                    <p
                                        class="whitespace-pre-wrap"
                                        v-html="raumkostenFormel"
                                    ></p>
                                    <p
                                        class="whitespace-pre-wrap"
                                        v-html="maschinenlaufzeitFormel"
                                    ></p>
                                    <p
                                        class="whitespace-pre-wrap"
                                        v-html="energiekostenFormel"
                                    ></p>
                                    <p
                                        class="whitespace-pre-wrap"
                                        v-html="instandhaltungskostenFormel"
                                    ></p>
                                    <p
                                        class="whitespace-pre-wrap"
                                        v-html="fixkostenFormel"
                                    ></p>
                                    <p
                                        class="whitespace-pre-wrap"
                                        v-html="variableKostenFormel"
                                    ></p>
                                    <p
                                        class="whitespace-pre-wrap"
                                        v-html="gesamtkostenFormel"
                                    ></p>
                                    <p
                                        class="whitespace-pre-wrap font-bold"
                                        v-html="maschinenstundensatzFormel"
                                    ></p>
                                </div>

                                <h4 class="font-bold mt-4">Zusammenfassung:</h4>
                                <p>
                                    <strong>Abschreibung:</strong>
                                    {{ formatNumber(abschreibung) }} €/Jahr
                                </p>
                                <p>
                                    <strong>Zinsen:</strong>
                                    {{ formatNumber(zinsen) }} €/Jahr
                                </p>
                                <p>
                                    <strong>Raumkosten:</strong>
                                    {{ formatNumber(raumkosten) }} €/Jahr
                                </p>
                                <p>
                                    <strong>Energiekosten:</strong>
                                    {{ formatNumber(energiekosten) }} €/Jahr
                                </p>
                                <p>
                                    <strong>Instandhaltungskosten:</strong>
                                    {{ formatNumber(instandhaltungskosten) }}
                                    €/Jahr
                                </p>
                                <p>
                                    <strong>Fixkosten:</strong>
                                    {{ formatNumber(fixkosten) }} €/Jahr
                                </p>
                                <p>
                                    <strong>Variable Kosten:</strong>
                                    {{ formatNumber(variableKosten) }} €/Jahr
                                </p>
                                <p>
                                    <strong>Gesamtkosten:</strong>
                                    {{ formatNumber(gesamtkosten) }} €/Jahr
                                </p>
                                <p>
                                    <strong>Maschinenlaufzeit:</strong>
                                    {{ formatNumber(maschinenlaufzeit) }}
                                    Stunden/Jahr
                                </p>
                                <p class="text-xl font-bold mt-4">
                                    <strong>Maschinenstundensatz:</strong>
                                    {{ formatNumber(maschinenstundensatz) }}
                                    €/Stunde
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
.maschinenstundensatz-container {
    max-width: 800px;
    margin: 0 auto;
}

.input-group {
    display: flex;
    flex-direction: column;
}

label {
    font-weight: bold;
    margin-bottom: 0.5rem;
}

input {
    padding: 0.5rem;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button {
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #4a5568;
}
.whitespace-pre-wrap {
    white-space: pre-wrap;
}

.tooltip-text {
    visibility: hidden;
    background-color: #000;
    color: #fff;
    text-align: left;
    border-radius: 5px;
    padding: 10px;
    position: absolute;
    z-index: 1;
    left: 50%;
    transform: translateX(-50%);
    opacity: 0;
    transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
    white-space: normal;
    width: 300px;
    max-height: none;
    line-height: 1.4;
}

.tooltip-text.top {
    bottom: 150%;
}

.tooltip-text.bottom {
    top: 150%;
}

.tooltip-container:hover .tooltip-text {
    visibility: visible;
    opacity: 1;
    transition-delay: 0.2s;
}

.tooltip-container:not(:hover) .tooltip-text {
    transition-delay: 0s;
}

.fraction {
    display: inline-block;
    vertical-align: middle;
    margin: 0 0.2em 0.4ex;
    text-align: center;
}

.fraction > span {
    display: block;
    padding-top: 0.15em;
}

.fraction span.numerator {
    border-bottom: 1px solid;
}

.fraction span.denominator {
    border-top: 1px solid;
}
</style>

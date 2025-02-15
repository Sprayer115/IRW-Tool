<!-- Kostenstellen/Abgrenzung/Info.vue -->
<template>
    <div class="page">
        <h1 class="text-2xl font-bold mb-4">Make-or-Buy Entscheidung</h1>
        
        <div class="content-section mb-6">
            <h2 class="text-xl font-bold mb-3">Was ist eine Make-or-Buy Entscheidung?</h2>
            <p class="mb-4">
                Die Make-or-Buy Entscheidung (Eigenfertigungs- oder Fremdbezugsentscheidung) ist ein wichtiges 
                Instrument des internen Rechnungswesens. Sie hilft Unternehmen bei der Entscheidung, ob ein Produkt 
                oder eine Komponente selbst hergestellt oder von externen Lieferanten bezogen werden soll.
            </p>
        </div>

        <div class="content-section mb-6">
            <h2 class="text-xl font-bold mb-3">Entscheidungskriterien</h2>
            <ul class="list-disc pl-6 mb-4">
                <li class="mb-2">
                    <strong>Quantitative Faktoren:</strong> 
                    <ul class="list-disc pl-6 mt-2">
                        <li>Herstellkosten vs. Beschaffungskosten</li>
                        <li>Variable und fixe Kosten</li>
                        <li>Kapazitätsauslastung</li>
                        <li>Opportunitätskosten</li>
                    </ul>
                </li>
                <li class="mb-2">
                    <strong>Qualitative Faktoren:</strong>
                    <ul class="list-disc pl-6 mt-2">
                        <li>Qualitätskontrolle</li>
                        <li>Know-how Sicherung</li>
                        <li>Lieferantenabhängigkeit</li>
                        <li>Flexibilität</li>
                    </ul>
                </li>
            </ul>
        </div>

        <div class="content-section mb-6">
            <h2 class="text-xl font-bold mb-3">Kostenvergleichsrechnung</h2>
            <p class="mb-4">
                Bei der Kostenvergleichsrechnung werden folgende Aspekte berücksichtigt:
            </p>
            <ul class="list-disc pl-6">
                <li class="mb-2">
                    <strong>Eigenfertigung:</strong>
                    <ul class="list-disc pl-6 mt-2">
                        <li>Fertigungsmaterial</li>
                        <li>Fertigungslöhne</li>
                        <li>Fertigungsgemeinkosten</li>
                        <li>Sondereinzelkosten der Fertigung</li>
                    </ul>
                </li>
                <li class="mb-2">
                    <strong>Fremdbezug:</strong>
                    <ul class="list-disc pl-6 mt-2">
                        <li>Einkaufspreis</li>
                        <li>Transportkosten</li>
                        <li>Lagerkosten</li>
                        <li>Qualitätskontrollkosten</li>
                    </ul>
                </li>
            </ul>
        </div>

        <div class="content-section">
            <h2 class="text-xl font-bold mb-3">Entscheidungsregeln</h2>
            <p class="mb-4">
                Die Entscheidung basiert auf folgenden Grundregeln:
            </p>
            <ul class="list-disc pl-6">
                <li class="mb-2">Fremdbezug, wenn: Fremdbezugskosten < Eigenfertigungskosten</li>
                <li class="mb-2">Eigenfertigung, wenn: Eigenfertigungskosten < Fremdbezugskosten</li>
                <li class="mb-2">Bei Gleichheit: Berücksichtigung qualitativer Faktoren</li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    name: 'MakeOrBuyInfo'
}
</script>

<style scoped>
.page {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.content-section {
    background-color: white;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

h1, h2 {
    color: #1a202c;
}

ul {
    margin-left: 1.5rem;
}

li {
    margin-bottom: 0.5rem;
}

strong {
    color: #2b6cb0;
}
</style>
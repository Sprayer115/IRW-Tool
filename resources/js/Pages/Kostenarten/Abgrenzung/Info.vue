<!-- Kostenstellen/Abgrenzung/Info.vue -->
<template>
    <div class="page">
        <h1 class="text-2xl font-bold mb-4">Die Abgrenzungsrechnung</h1>
        
        <div class="content-section mb-6">
            <h2 class="text-xl font-bold mb-3">Was ist die Abgrenzungsrechnung?</h2>
            <p class="mb-4">
                Die Abgrenzungsrechnung ist ein wichtiger Bestandteil des internen Rechnungswesens. Sie dient dazu, 
                aus den Aufwendungen der Finanzbuchhaltung die relevanten Kosten für die Kostenrechnung zu ermitteln.
            </p>
        </div>

        <div class="content-section mb-6">
            <h2 class="text-xl font-bold mb-3">Die drei Abgrenzungsarten</h2>
            <ul class="list-disc pl-6 mb-4">
                <li class="mb-2">
                    <strong>Zeitliche Abgrenzung:</strong> Anpassung der Aufwendungen an die Periode, 
                    in der sie wirtschaftlich entstanden sind
                </li>
                <li class="mb-2">
                    <strong>Sachliche Abgrenzung:</strong> Unterscheidung zwischen betriebsbedingten 
                    und neutralen Aufwendungen
                </li>
                <li class="mb-2">
                    <strong>Wertmäßige Abgrenzung:</strong> Bewertungsunterschiede zwischen Aufwand 
                    und Kosten (Zusatz- und Anderskosten)
                </li>
            </ul>
        </div>

        <div class="content-section mb-6">
            <h2 class="text-xl font-bold mb-3">Beispiele für Abgrenzungen</h2>
            <ul class="list-disc pl-6">
                <li class="mb-2">
                    <strong>Zeitlich:</strong> Vorausgezahlte Versicherungsprämien, nachträgliche Wartungskosten
                </li>
                <li class="mb-2">
                    <strong>Sachlich:</strong> Spenden, Bußgelder (neutrale Aufwendungen)
                </li>
                <li class="mb-2">
                    <strong>Wertmäßig:</strong>
                    <ul class="list-disc pl-6 mt-2">
                        <li>Kalkulatorische Abschreibungen (Anders-Kosten)</li>
                        <li>Kalkulatorische Zinsen (Zusatz-Kosten)</li>
                        <li>Kalkulatorischer Unternehmerlohn (Zusatz-Kosten)</li>
                    </ul>
                </li>
            </ul>
        </div>

        <div class="content-section">
            <h2 class="text-xl font-bold mb-3">Bedeutung für die Kostenrechnung</h2>
            <p class="mb-4">
                Die Abgrenzungsrechnung ist fundamental für die Kostenrechnung, da sie sicherstellt, dass:
            </p>
            <ul class="list-disc pl-6">
                <li class="mb-2">nur betriebsbedingte Kosten berücksichtigt werden</li>
                <li class="mb-2">Kosten der richtigen Periode zugeordnet werden</li>
                <li class="mb-2">alle relevanten Kosten (auch kalkulatorische) einbezogen werden</li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    name: 'AbgrenzungInfo'
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
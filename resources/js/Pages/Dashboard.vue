<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link as NavLink } from '@inertiajs/vue3';
</script>

<template>
    <div>
        <Head title="Dashboard" />

        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white2 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- First Column -->
                                <div class="space-y-4 flex flex-col">
                                    <NavLink :href="route('abgrenzungsrechnung.index')" :active="route().current('abgrenzungsrechnung.index')" class="nav-link-container">
                                        <div class="bg-white2 dark:bg-gray-700 rounded-lg p-4 shadow-md h-full w-full">
                                            <h3 class="text-lg font-semibold mb-2 dashboard-link-title">Abgrenzungsrechnung</h3>
                                            <p class="text-gray-600 dark:text-gray-300">Berechnung von Periodenabgrenzungen für eine korrekte Buchhaltung.</p>
                                        </div>
                                    </NavLink>
                                    <NavLink :href="route('GanzeAbweichungsanalyse')" :active="route().current('GanzeAbweichungsanalyse')" class="nav-link-container">
                                        <div class="bg-white2 dark:bg-gray-700 rounded-lg p-4 shadow-md h-full w-full">
                                            <h3 class="text-lg font-semibold mb-2 dashboard-link-title">Abweichungsanalyse</h3>
                                            <p class="text-gray-600 dark:text-gray-300">Analyse von Abweichungen zwischen Ist- und Sollwerten.</p>
                                        </div>
                                    </NavLink>
                                    <NavLink :href="route('makeOrBuy')" :active="route().current('makeOrBuy')" class="nav-link-container">
                                        <div class="bg-white2 dark:bg-gray-700 rounded-lg p-4 shadow-md h-full w-full">
                                            <h3 class="text-lg font-semibold mb-2 dashboard-link-title">Make or Buy</h3>
                                            <p class="text-gray-600 dark:text-gray-300">Entscheidungshilfe für Eigenfertigung oder Fremdbezug.</p>
                                        </div>
                                    </NavLink>
                                    <NavLink :href="route('breakEven.index')" :active="route().current('breakEven.index')" class="nav-link-container">
                                        <div class="bg-white2 dark:bg-gray-700 rounded-lg p-4 shadow-md h-full w-full">
                                            <h3 class="text-lg font-semibold mb-2 dashboard-link-title">Break Even</h3>
                                            <p class="text-gray-600 dark:text-gray-300">Berechnung des Gewinnschwellenpunkts.</p>
                                        </div>
                                    </NavLink>
                                </div>

                                <!-- Second Column -->
                                <div class="space-y-4 flex flex-col">
                                    <NavLink :href="route('InnerbetrieblicheLeistungsverrechnung')" :active="route().current('InnerbetrieblicheLeistungsverrechnung')" class="nav-link-container">
                                        <div class="bg-white2 dark:bg-gray-700 rounded-lg p-4 shadow-md h-full w-full">
                                            <h3 class="text-lg font-semibold mb-2 dashboard-link-title">Innerbetriebliche Leistungsverrechnung</h3>
                                            <p class="text-gray-600 dark:text-gray-300">Verrechnung von Leistungen zwischen Abteilungen.</p>
                                        </div>
                                    </NavLink>
                                    <NavLink :href="route('Maschinenstundensatzrechnung')" :active="route().current('Maschinenstundensatzrechnung')" class="nav-link-container">
                                        <div class="bg-white2 dark:bg-gray-700 rounded-lg p-4 shadow-md h-full w-full">
                                            <h3 class="text-lg font-semibold mb-2 dashboard-link-title">Maschinenstundensatzrechnung</h3>
                                            <p class="text-gray-600 dark:text-gray-300">Berechnung der Kosten pro Maschinenstunde.</p>
                                        </div>
                                    </NavLink>
                                    <NavLink :href="route('OptimalesProduktionsProgramm')" :active="route().current('OptimalesProduktionsProgramm')" class="nav-link-container">
                                        <div class="bg-white2 dark:bg-gray-700 rounded-lg p-4 shadow-md h-full w-full">
                                            <h3 class="text-lg font-semibold mb-2 dashboard-link-title">Optimales ProduktionsProgramm</h3>
                                            <p class="text-lg font-semibold mb-2  ml-2">Deckungsbeitrag</p>
                                            <p class="text-gray-600 dark:text-gray-300 ml-6">Berechnung des Beitrags zur Deckung der Fixkosten.</p>
                                            <p class="text-lg font-semibold mb-2  ml-2">Preisuntergrenze</p>
                                            <p class="text-gray-600 dark:text-gray-300 ml-6">Ermittlung der minimalen Preisgrenze für Produkte oder Dienstleistungen.</p>
                                        </div>
                                    </NavLink>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </div>
</template>

<style scoped>
.grid {
    display: grid;
    gap: 1.5rem;
}

.space-y-4 > * + * {
    margin-top: 1rem;
}

.bg-white2.dark\:bg-gray-700 {
    transition: all 0.3s ease;
}

.nav-link-container {
    display: flex;
    text-decoration: none;
    color: inherit;
    width: 100%; /* Ensure full width */
}

.nav-link-container:hover .bg-white2.dark\:bg-gray-700 {
    transform: translateY(-3px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.dashboard-link-title {
    font-size: 1.125rem;
    margin-bottom: 0.5rem;
    color: inherit;
}

p {
    font-size: 0.875rem;
}

@media (min-width: 768px) {
    .grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* For light mode */
.bg-white2 .dashboard-link-title {
    color: rgb(31, 32, 33);
}

/* Ensure all NavLink containers have the same height and width */
.space-y-4 {
    display: flex;
    flex-direction: column;
}

.space-y-4 > * {
    flex: 1 1 auto;
    width: 100%; /* Ensure full width */
}

.bg-white2.dark\:bg-gray-700 {
    display: flex;
    flex-direction: column;
    height: 100%;
    width: 100%; /* Ensure full width */
}
</style>
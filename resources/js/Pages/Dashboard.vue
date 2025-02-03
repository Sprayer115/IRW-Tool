<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link as NavLink } from '@inertiajs/vue3';
import { ref } from 'vue';

const activeSection = ref(null);
const hoverSection = ref(null);

const handleClick = (section) => {
    activeSection.value = section;
};

// SVG helper functions
const createHorizontalArrow = (startX, y, length) => {
    const arrowWidth = 20;
    const arrowHeight = 15;
    return `M ${startX} ${y} 
            H ${startX + length - arrowWidth}
            L ${startX + length - arrowWidth} ${y - arrowHeight/2} 
            L ${startX + length} ${y}
            L ${startX + length - arrowWidth} ${y + arrowHeight/2}
            L ${startX + length - arrowWidth} ${y}`;
};

const createVerticalArrow = (x, startY, length) => {
    const arrowWidth = 15;
    const arrowHeight = 20;
    return `M ${x} ${startY} 
            V ${startY + length - arrowHeight}
            L ${x - arrowWidth/2} ${startY + length - arrowHeight} 
            L ${x} ${startY + length}
            L ${x + arrowWidth/2} ${startY + length - arrowHeight}
            L ${x} ${startY + length - arrowHeight}`;
};
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
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <!-- Cost Navigation Diagram -->
                            <div class="relative w-full max-w-4xl mx-auto">
                                <svg viewBox="0 0 900 450" class="w-full">
                                    <!-- Background -->
                                    <rect x="0" y="0" width="900" height="450" fill="#ffffff" />
                                    
                                    <!-- Finanzbuchhaltung -->
                                    <g 
                                        @click="$inertia.visit(route('finanzbuchhaltung'))"
                                        @mouseenter="hoverSection = 'finanzbuchhaltung'"
                                        @mouseleave="hoverSection = null"
                                        class="cursor-pointer"
                                    >
                                        <rect
                                            x="50"
                                            y="100"
                                            width="130"
                                            height="180"
                                            :class="{
                                                'opacity-90': hoverSection === 'finanzbuchhaltung',
                                                'opacity-100': hoverSection !== 'finanzbuchhaltung'
                                            }"
                                            class="transition-opacity"
                                            fill="#2c3e50"
                                        />
                                        <text x="65" y="180" fill="white" class="text-sm font-medium">
                                            <tspan x="65" dy="0">Finanz-</tspan>
                                            <tspan x="65" dy="20">buchhaltung</tspan>
                                        </text>
                                    </g>

                                    <!-- Kostenarten -->
                                    <g 
                                        @click="$inertia.visit(route('kostenarten'))"
                                        @mouseenter="hoverSection = 'kostenarten'"
                                        @mouseleave="hoverSection = null"
                                        class="cursor-pointer"
                                    >
                                        <rect
                                            x="270"
                                            y="100"
                                            width="130"
                                            height="180"
                                            :class="{
                                                'opacity-90': hoverSection === 'kostenarten',
                                                'opacity-100': hoverSection !== 'kostenarten'
                                            }"
                                            class="transition-opacity"
                                            fill="#e6edf2"
                                        />
                                        <text x="285" y="190" fill="#2c3e50" class="text-sm font-medium">
                                            Kostenarten
                                        </text>
                                    </g>

                                    <!-- Kostenstellen -->
                                    <g 
                                        @click="$inertia.visit(route('kostenstellen'))"
                                        @mouseenter="hoverSection = 'kostenstellen'"
                                        @mouseleave="hoverSection = null"
                                        class="cursor-pointer"
                                    >
                                        <rect
                                            x="490"
                                            y="130"
                                            height="140"
                                            width="120"
                                            :class="{
                                                'opacity-90': hoverSection === 'kostenstellen',
                                                'opacity-100': hoverSection !== 'kostenstellen'
                                            }"
                                            class="transition-opacity"
                                            fill="#00a19c"
                                        />
                                        <text x="505" y="170" fill="white" class="text-sm font-medium">
                                            <tspan x="505" dy="0">Kostenstellen</tspan>
                                            <tspan x="505" dy="20">(Gemeinkosten)</tspan>
                                        </text>
                                    </g>

                                    <!-- Kostenträger -->
                                    <g 
                                        @click="$inertia.visit(route('kostentraeger'))"
                                        @mouseenter="hoverSection = 'kostentraeger'"
                                        @mouseleave="hoverSection = null"
                                        class="cursor-pointer"
                                    >
                                        <rect
                                            x="710"
                                            y="100"
                                            width="130"
                                            height="180"
                                            :class="{
                                                'opacity-90': hoverSection === 'kostentraeger',
                                                'opacity-100': hoverSection !== 'kostentraeger'
                                            }"
                                            class="transition-opacity"
                                            fill="#006758"
                                        />
                                        <text x="725" y="190" fill="white" class="text-sm font-medium">
                                            Kostenträger
                                        </text>
                                    </g>

                                    <!-- Arrows -->
                                    <!-- Direct Costs Arrow -->
                                    <path
                                        :d="createHorizontalArrow(400, 120, 290)"
                                        stroke="#2c3e50"
                                        stroke-width="10"
                                        fill="#2c3e50"
                                    />
                                    <text x="450" y="100" fill="#2c3e50" class="text-xs font-medium">
                                        Direkte Kosten (Einzelkosten)
                                    </text>

                                    <!-- Normal Arrows -->
                                    <path
                                        :d="createHorizontalArrow(180, 190, 70)"
                                        stroke="#2c3e50"
                                        stroke-width="10"
                                        fill="#2c3e50"
                                    />
                                    <path
                                        :d="createHorizontalArrow(400, 190, 70)"
                                        stroke="#2c3e50"
                                        stroke-width="10"
                                        fill="#2c3e50"
                                    />
                                    <path
                                        :d="createHorizontalArrow(620, 190, 70)"
                                        stroke="#2c3e50"
                                        stroke-width="10"
                                        fill="#2c3e50"
                                    />

                                    <!-- Operating Result Box -->
                                    <rect
                                        x="490"
                                        y="370"
                                        width="350"
                                        height="30"
                                        fill="#1a237e"
                                        class="opacity-90"
                                    />
                                    <text x="590" y="390" fill="white" class="text-sm text-center font-medium">
                                        Betriebsergebnis
                                    </text>
                                    
                                    <!-- Vertical Arrows -->
                                    <path
                                        :d="createVerticalArrow(555, 280, 70)"
                                        stroke="#2c3e50"
                                        stroke-width="10"
                                        fill="#2c3e50"
                                    />
                                    <path
                                        :d="createVerticalArrow(775, 280, 70)"
                                        stroke="#2c3e50"
                                        stroke-width="10"
                                        fill="#2c3e50"
                                    />
                                </svg>
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

.nav-link-container {
    display: flex;
    text-decoration: none;
    color: inherit;
    width: 100%;
}

.nav-link-container:hover .bg-white.dark\:bg-gray-700 {
    transform: translateY(-3px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

@media (min-width: 768px) {
    .grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>

                            <!--
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                
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
                        </div> -->
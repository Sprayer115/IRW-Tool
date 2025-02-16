<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';



const showingNavigationDropdown = ref(false);
const props = defineProps({
  hideNavbar: {
    type: Boolean,
    default: false
  }
});
</script>

<template>
    <div>
    <div class="min-h-screen bg-slate-100 dark:bg-gray-900">
      <!-- Primary Navigation Menu -->
      <nav v-if="!props.hideNavbar" class="bg-white2 dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
                <!-- Primary Navigation Menu -->
                <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16 mb-4">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <img src='/images/SiteLogo2.png' class="block h-16 mt-4 w-auto fill-current text-gray-800 dark:text-gray-400"/>
                                </Link>
                            </div>

                            <!-- Navigation Links (normale Nav) -->
                            <div class="normal-nav hidden custom-nav-spacing pt-4 items-center xl:-my-px xl:ms-10 2xl:-my-px 2xl:ms-10">
                                <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                    Dashboard
                                </NavLink>

                                <NavLink :href="route('finanzbuchhaltung')" :active="route().current('finanzbuchhaltung')">
                                    Finanzbuchhaltung
                                </NavLink>

                                <!-- Kostenabrechnung -->
                                <div class="flex items-center">
                                    <Dropdown align="right" width="96">
                                        <template #trigger>
                                            <span class="inline-flex rounded-md">
                                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                                    Kostenartenrechnung
                                                    <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>
                                        <template #content>
                                            <DropdownLink :href="route('kostenarten', { page: 'info' })" class="whitespace-normal">
                                                Infoseite
                                            </DropdownLink>
                                            <DropdownLink :href="route('kostenarten', { page: 'abgrenzung' })" class="whitespace-normal">
                                                Abgrenzungsrechnung
                                            </DropdownLink>
                                        </template>
                                    </Dropdown>
                                </div>

                                <!-- Kostenstellenrechnung -->
                                <div class="flex items-center">
                                    <Dropdown align="right" width="96">
                                        <template #trigger>
                                            <span class="inline-flex rounded-md">
                                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                                    Kostenstellenrechnung
                                                    <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>
                                        <template #content>
                                            <DropdownLink :href="route('kostenstellen', { page: 'info' })" class="whitespace-normal">
                                                Infoseite
                                            </DropdownLink>
                                            <DropdownLink :href="route('kostenstellen', { page: 'iblv' })" class="whitespace-normal">
                                                Innerbetriebliche Leistungsverrechnung
                                            </DropdownLink>
                                            <DropdownLink :href="route('kostenstellen', { page: 'msr' })" class="whitespace-normal">
                                                Maschinenstundenrechnungen
                                            </DropdownLink>
                                            <DropdownLink :href="route('kostenstellen', { page: 'pkr' })" class="whitespace-normal">
                                                Prozesskostenrechnung
                                            </DropdownLink>
                                        </template>
                                    </Dropdown>
                                </div>

                                <!-- Kostenträgerrechnung -->
                                <div class="flex items-center">
                                    <Dropdown align="right" width="96">
                                        <template #trigger>
                                            <span class="inline-flex rounded-md">
                                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                                    Kostenträgerrechnung
                                                    <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>
                                        <template #content>
                                            <DropdownLink :href="route('kostentraeger', { page: 'info' })" class="whitespace-normal">
                                                Infoseite
                                            </DropdownLink>
                                            <DropdownLink :href="route('kostentraeger', { page: 'zuschlag' })" class="whitespace-normal">
                                                Zuschlagssatzberechnung
                                            </DropdownLink>
                                            <DropdownLink :href="route('kostentraeger', { page: 'verteilung' })" class="whitespace-normal">
                                                Kostenverteilung
                                            </DropdownLink>
                                        </template>
                                    </Dropdown>
                                </div>

                                <!-- Deckungsbeitragsrechnung -->
                                <div class="flex items-center">
                                    <Dropdown align="right" width="96">
                                        <template #trigger>
                                            <span class="inline-flex rounded-md">
                                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                                    Deckungsbeitragsrechnung
                                                    <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>
                                        <template #content>
                                            <DropdownLink :href="route('deckungsbeitrag', { page: 'einstufig' })" class="whitespace-normal">
                                                Einstufige DB
                                            </DropdownLink>
                                            <DropdownLink :href="route('deckungsbeitrag', { page: 'mehrstufig' })" class="whitespace-normal">
                                                Mehrstufige DB
                                            </DropdownLink>
                                            <DropdownLink :href="route('deckungsbeitrag', { page: 'preisuntergrenze' })" class="whitespace-normal">
                                                Preisuntergrenzenrechnung
                                            </DropdownLink>
                                            <DropdownLink :href="route('deckungsbeitrag', { page: 'break-even' })" class="whitespace-normal">
                                                Break-Even-Analyse
                                            </DropdownLink>
                                            <DropdownLink :href="route('deckungsbeitrag', { page: 'optimierung' })" class="whitespace-normal">
                                                Optimales Produktionsprogramm
                                            </DropdownLink>
                                            <DropdownLink :href="route('deckungsbeitrag', { page: 'make-or-buy' })" class="whitespace-normal">
                                                Make-or-Buy Entscheidungen
                                            </DropdownLink>
                                        </template>
                                    </Dropdown>
                                </div>

                                <!-- Plankostenrechnung -->
                                <NavLink :href="route('plankosten')" :active="route().current('plankosten')">
                                    Plankostenrechnung
                                </NavLink>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ms-6  pt-4">
                            <!-- Settings Dropdown -->
                            <div class="ms-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center p-2 border border-transparent text-sm leading-4 font-medium rounded-full text-gray-500 dark:text-gray-400 bg-white2 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
                                            >
                                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 
                                                    0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>
                                    <template #content>
                                        <DropdownLink :href="route('profile.edit')">Profile</DropdownLink>
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger Menü -->
                        <div class="hamburger-nav me-2 flex items-center">
                            <button
                                @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none transition duration-150 ease-in-out"
                            >
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }" class="2xl:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <!-- Hauptnavigation -->
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </ResponsiveNavLink>
                        
                        <ResponsiveNavLink :href="route('finanzbuchhaltung')" :active="route().current('finanzbuchhaltung')">
                            Finanzbuchhaltung
                        </ResponsiveNavLink>

                        <div class="border-t border-gray-200 dark:border-gray-600 my-4"></div>

                        <!-- Kostenartenrechnung -->
                        <div class="px-3 py-2 text-base font-bold text-gray-600 dark:text-gray-300">
                            Kostenartenrechnung
                        </div>
                        <ResponsiveNavLink :href="route('kostenarten', { page: 'info' })">
                            Infoseite
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('kostenarten', { page: 'abgrenzung' })">
                            Abgrenzungsrechnung
                        </ResponsiveNavLink>

                        <div class="border-t border-gray-200 dark:border-gray-600 my-4"></div>

                        <!-- Kostenstellenrechnung -->
                        <div class="px-3 py-2 text-base font-bold text-gray-600 dark:text-gray-300">
                            Kostenstellenrechnung
                        </div>
                        <ResponsiveNavLink :href="route('kostenstellen', { page: 'info' })">
                            Infoseite
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('kostenstellen', { page: 'iblv' })">
                            Innerbetriebliche Leistungsverrechnung
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('kostenstellen', { page: 'msr' })">
                            Maschinenstundenrechnungen
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('kostenstellen', { page: 'pkr' })">
                            Prozesskostenrechnung
                        </ResponsiveNavLink>

                        <div class="border-t border-gray-200 dark:border-gray-600 my-4"></div>

                        <!-- Kostenträgerrechnung -->
                        <div class="px-3 py-2 text-base font-bold text-gray-600 dark:text-gray-300">
                            Kostenträgerrechnung
                        </div>
                        <ResponsiveNavLink :href="route('kostentraeger', { page: 'info' })">
                            Infoseite
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('kostentraeger', { page: 'zuschlag' })">
                            Zuschlagssatzberechnung
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('kostentraeger', { page: 'verteilung' })">
                            Kostenverteilung
                        </ResponsiveNavLink>

                        <div class="border-t border-gray-200 dark:border-gray-600 my-4"></div>

                        <!-- Deckungsbeitragsrechnung -->
                        <div class="px-3 py-2 text-base font-bold text-gray-600 dark:text-gray-300">
                            Deckungsbeitragsrechnung
                        </div>
                        <ResponsiveNavLink :href="route('deckungsbeitrag', { page: 'einstufig' })">
                            Einstufige DB
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('deckungsbeitrag', { page: 'mehrstufig' })">
                            Mehrstufige DB
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('deckungsbeitrag', { page: 'preisuntergrenze' })">
                            Preisuntergrenzenrechnung
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('deckungsbeitrag', { page: 'break-even' })">
                            Break-Even-Analyse
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('deckungsbeitrag', { page: 'optimierung' })">
                            Optimales Produktionsprogramm
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('deckungsbeitrag', { page: 'make-or-buy' })">
                            Make-or-Buy Entscheidungen
                        </ResponsiveNavLink>

                        <div class="border-t border-gray-200 dark:border-gray-600 my-4"></div>

                        <!-- Plankostenrechnung -->
                        <div class="px-3 py-2 text-base font-bold text-gray-600 dark:text-gray-300">
                            Plankostenrechnung
                        </div>
                        <ResponsiveNavLink :href="route('plankosten')" :active="route().current('plankosten')">
                            Plankostenrechnung
                        </ResponsiveNavLink>
                    </div>

                    
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white2 dark:bg-gray-800 shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>

<style scoped>
/* Standard: falls der Breakpoint unter 1400px liegt, kannst Du hier ggf. einen anderen space-x-Wert setzen */
.custom-nav-spacing {
  @apply space-x-4;
}

/* Wenn der Bildschirm zwischen 1400px und 1599px breit ist, verwende space-x-2 */
@media (min-width: 1400px) and (max-width: 1599px) {
  .custom-nav-spacing {
    @apply space-x-2;
  }
}

/* Ab 1600px: space-x-6 */
@media (min-width: 1600px) {
  .custom-nav-spacing {
    @apply space-x-6;
  }
}

/* Steuerung der Sichtbarkeit der normalen Navigation und des Hamburger-Menüs */
@media (max-width: 1399px) {
  .normal-nav {
    display: none !important;
  }
  .hamburger-nav {
    display: flex !important;
  }
}

@media (min-width: 1400px) {
  .normal-nav {
    display: flex !important;
  }
  .hamburger-nav {
    display: none !important;
  }
}
</style>

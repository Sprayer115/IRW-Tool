<script setup>
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import Anbauverfahren from "@/Pages/Anbauverfahren.vue";
import Stufenleiterverfahren from "@/Pages/Stufenleiterverfahren.vue";
import Gleichungsverfahren from "@/Pages/Gleichungsverfahren.vue";

const activeComponent = ref("Anbauverfahren");

const components = {
    Anbauverfahren,
    Stufenleiterverfahren,
    Gleichungsverfahren,
};

const setActiveComponent = (component) => {
    activeComponent.value = component;
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Innerbetriebliche Leistungsverrechnung" />

        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Innerbetriebliche Leistungsverrechnung
            </h2>
            <hr class="my-2 border-gray-300 dark:border-gray-600" />
            <nav class="">
                <ul class="flex space-x-4">
                    <li
                        v-for="component in Object.keys(components)"
                        :key="component"
                    >
                        <button
                            @click="setActiveComponent(component)"
                            :class="[
                                'px-4 py-2 bg-transparent transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2',
                                activeComponent === component
                                    ? 'text-blue-500 font-semibold'
                                    : 'text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white',
                            ]"
                        >
                            {{ component }}
                        </button>
                    </li>
                </ul>
            </nav>
        </template>

        <div class="py-12">
            <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white2 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <component
                            :is="components[activeComponent]"
                        ></component>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
/* Remove default focus styles */
button:focus {
    outline: none;
}

/* Custom focus styles for keyboard navigation */
button:focus-visible {
    outline: 2px solid transparent;
    outline-offset: 2px;
    --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
    --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color);
    box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);
    --tw-ring-opacity: 1;
    --tw-ring-color: rgb(59 130 246 / var(--tw-ring-opacity));
}
</style>
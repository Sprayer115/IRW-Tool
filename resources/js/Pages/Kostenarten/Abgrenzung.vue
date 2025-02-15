<!-- Kostenarten/Abgrenzung.vue -->
<template>
    <div class="py-12 bg-white dark:bg-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex">
            <!-- Side Navigation Panel -->
            <div class="w-1/6">
                <h3 class="font-bold mb-4">Seiten</h3>
                <nav>
                    <ul class="flex flex-col space-y-4">
                        <li v-for="component in Object.keys(registeredComponents)" :key="component">
                            <button
                                @click="setActiveComponent(component)"
                                :class="[
                                    'px-4 py-2 bg-transparent transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2',
                                    activeComponent === component
                                        ? 'text-blue-500 font-semibold'
                                        : 'text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white'
                                ]"
                            >
                                <div v-if="component === 'Calculator'">
                                    <i class="fas fa-calculator mr-2"></i>
                                </div>
                                <div v-else>
                                    {{ component }}
                                </div>
                            </button>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- Main Content Area -->
            <div class="w-3/4 pl-8">
                <component
                    :is="registeredComponents[activeComponent]"
                ></component>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from "vue";
import Info from "@/Pages/Kostenarten/Abgrenzung/Info.vue";
import Calculator from "@/Pages/Calc/Abgrenzungsrechnung.vue";

export default {
    name: 'Abgrenzung',
    components: {
        Info,
        Calculator
    },

    setup() {
        const activeComponent = ref("Info");
        const registeredComponents = { Info, Calculator };

        const setActiveComponent = (component) => {
            activeComponent.value = component;
        };

        return {
            activeComponent,
            setActiveComponent,
            registeredComponents,
        };
    },
};
</script>
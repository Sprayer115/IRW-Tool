<script setup>
import { ref, computed, onMounted, markRaw } from 'vue';
import { topicConfigs } from './../topicConfig';

const props = defineProps({
    topicId: {
        type: String,
        required: true
    },
    initialPage: {
        type: Number,
        default: 1
    },
    pageProps: {
        type: Object,
        default: () => ({})
    }
});

const emit = defineEmits(['page-changed']);

const currentPage = ref(props.initialPage);
const pageComponents = ref([]);
const currentComponent = ref(null);

onMounted(async () => {
    const topic = topicConfigs[props.topicId];
    if (!topic) {
        console.error(`Topic ${props.topicId} not found`);
        return;
    }
    
    try {
        const { components } = await topic.pages();
        const loadedComponents = await Promise.all(components);
        pageComponents.value = loadedComponents.map(comp => markRaw(comp.default));
        currentComponent.value = pageComponents.value[currentPage.value - 1];
    } catch (error) {
        console.error('Error loading pages:', error);
    }
});

const totalPages = computed(() => pageComponents.value.length);

const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
        currentComponent.value = pageComponents.value[currentPage.value - 1];
        emit('page-changed', {
            page: currentPage.value,
            direction: 'next'
        });
    }
};

const previousPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--;
        currentComponent.value = pageComponents.value[currentPage.value - 1];
        emit('page-changed', {
            page: currentPage.value,
            direction: 'previous'
        });
    }
};
</script>

<template>
    <div class="relative min-h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Main content container - removed px padding -->
        <div class="h-full bg-gray-100 dark:bg-gray-900">
            <!-- Page content - adjusted padding and removed white background -->
            <div class="bg-gray-100 dark:bg-gray-900">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <Suspense>
                        <div class="bg-gray-100 dark:bg-gray-900 rounded-lg shadow-md dark:shadow-gray-950/50 p-6">
                            <component 
                                v-if="currentComponent"
                                :is="currentComponent"
                                v-bind="pageProps"
                            />
                        </div>
                        <template #fallback>
                            <div class="text-gray-600 dark:text-gray-400">Loading page content...</div>
                        </template>
                    </Suspense>
                </div>
            </div>
        </div>

        <!-- Navigation Controls - Fixed at bottom left -->
        <div class="fixed bottom-8 left-8 flex items-center space-x-4 bg-gray-800 rounded-lg shadow-lg px-4 py-2">
            <button 
                @click="previousPage" 
                :disabled="currentPage === 1"
                class="w-8 h-8 flex items-center justify-center rounded-full 
                       text-gray-400
                       hover:bg-gray-700
                       disabled:opacity-50 disabled:cursor-not-allowed
                       transition-colors duration-200"
                :class="{ 'opacity-50 cursor-not-allowed': currentPage === 1 }"
            >
                <svg 
                    xmlns="http://www.w3.org/2000/svg" 
                    class="h-5 w-5" 
                    viewBox="0 0 20 20" 
                    fill="currentColor"
                >
                    <path 
                        fill-rule="evenodd" 
                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" 
                        clip-rule="evenodd" 
                    />
                </svg>
            </button>
            
            <span class="text-sm font-medium text-gray-400">
                {{ currentPage }}/{{ totalPages }}
            </span>
            
            <button 
                @click="nextPage" 
                :disabled="currentPage === totalPages"
                class="w-8 h-8 flex items-center justify-center rounded-full 
                       text-gray-400
                       hover:bg-gray-700
                       disabled:opacity-50 disabled:cursor-not-allowed
                       transition-colors duration-200"
                :class="{ 'opacity-50 cursor-not-allowed': currentPage === totalPages }"
            >
                <svg 
                    xmlns="http://www.w3.org/2000/svg" 
                    class="h-5 w-5" 
                    viewBox="0 0 20 20" 
                    fill="currentColor"
                >
                    <path 
                        fill-rule="evenodd" 
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" 
                        clip-rule="evenodd" 
                    />
                </svg>
            </button>
        </div>
    </div>
</template>
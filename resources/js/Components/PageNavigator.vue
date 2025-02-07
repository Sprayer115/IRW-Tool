<script setup>
import { ref, computed, onMounted, markRaw } from 'vue';
import { topicConfigs } from './../topicConfig';
import { usePage } from '@inertiajs/vue3';

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

const page = usePage();
const currentRoute = computed(() => page.props.value); // Zugriff auf aktuelle Route
const urlPage = computed(() => page.props.page || 'info');

const getPageNumber = (pageName) => {
    const pages = topicConfigs[props.topicId].pages().components;
    const pageNames = Object.keys(pages);
    return pageNames.indexOf(pageName) + 1;
};

onMounted(async () => {
    try {
        const topic = topicConfigs[props.topicId];
        if (!topic) throw new Error(`Topic ${props.topicId} not found`);

        const { components } = topic.pages();
        const pageNames = Object.keys(components);
        
        // Verbesserte Seiteninitialisierung
        const pageIndex = pageNames.indexOf(urlPage.value);
        currentPage.value = pageIndex !== -1 ? pageIndex + 1 : 1;

        // Komponenten sequentiell laden
        const loadedComponents = await Promise.all(
            pageNames.map(async (pageName) => {
                try {
                    const module = await components[pageName]();
                    return markRaw(module.default);
                } catch (err) {
                    console.error(`Failed to load component ${pageName}:`, err);
                    return null;
                }
            })
        );

        // Null-Werte filtern
        pageComponents.value = loadedComponents.filter(Boolean);
        currentComponent.value = pageComponents.value[currentPage.value - 1];
    } catch (error) {
        console.error('Error loading pages:', error);
    }
});

const totalPages = computed(() => pageComponents.value.length);

const topicOrder = Object.keys(topicConfigs);
const currentTopicIndex = computed(() => topicOrder.indexOf(props.topicId));

const isLastPage = computed(() => currentPage.value === totalPages.value);
const hasNextTopic = computed(() => currentTopicIndex.value < topicOrder.length - 1);

const navigateToNextTopic = () => {
    if (hasNextTopic.value) {
        const nextTopic = topicOrder[currentTopicIndex.value + 1];
        window.location.href = `/${nextTopic}`;
    }
};

const hasPreviousTopic = computed(() => currentTopicIndex.value > 0);

const navigateToPreviousTopic = () => {
    if (hasPreviousTopic.value) {
        const previousTopic = topicOrder[currentTopicIndex.value - 1];
        window.location.href = `/${previousTopic}`;
    }
};

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
    <div v-if="currentComponent" class="relative min-h-screen bg-slate-100 dark:bg-gray-900">
        <!-- Main content container -->
        <div class="h-full">
            
            <!-- Page content -->
            <div>
                <div class="p-6 text-slate-800 dark:text-slate-200">
                    <Suspense>
                        <div class="bg-slate-200 dark:bg-slate-700 rounded-lg shadow-md dark:shadow-gray-950/50 p-6">

                            <component 
                                v-if="currentComponent"
                                :is="currentComponent"
                                v-bind="pageProps"
                                class="text-slate-700 dark:text-slate-200"
                            />
                        </div>
                        <template #fallback>
                            <div class="text-slate-600 dark:text-slate-400">Loading page content...</div>
                        </template>
                    </Suspense>
                </div>
            </div>
        </div>

        <!-- Navigation Controls -->
        <div class="fixed bottom-8 left-8 flex items-center space-x-4 bg-slate-600 rounded-lg shadow-lg px-4 py-2">
            <button 
                v-if="currentPage > 1"
                @click="previousPage" 
                class="w-8 h-8 flex items-center justify-center rounded-full 
                       text-slate-200
                       hover:bg-slate-500
                       transition-colors duration-200"
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
            
            <button 
                v-else-if="hasPreviousTopic"
                @click="navigateToPreviousTopic"
                class="px-3 py-1 rounded-full 
                       text-slate-200
                       hover:bg-slate-500
                       transition-colors duration-200"
            >
                <<
            </button>
            
            <span class="text-sm font-medium text-slate-200">
                {{ currentPage }}/{{ totalPages }}
            </span>
            
            <button 
                v-if="!isLastPage"
                @click="nextPage" 
                :disabled="currentPage === totalPages"
                class="w-8 h-8 flex items-center justify-center rounded-full 
                       text-slate-200
                       hover:bg-slate-500
                       disabled:opacity-40 disabled:cursor-not-allowed
                       transition-colors duration-200"
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
            
            <button 
                v-else-if="hasNextTopic"
                @click="navigateToNextTopic"
                class="px-3 py-1 rounded-full 
                       text-slate-200
                       hover:bg-slate-500
                       transition-colors duration-200"
            >
                >>
            </button>
        </div>
    </div>
</template>
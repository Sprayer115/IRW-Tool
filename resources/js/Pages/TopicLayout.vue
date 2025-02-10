<script setup>
import { ref,computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageNavigator from '@/Components/PageNavigator.vue';

const props = defineProps({
    topicId: {
        type: String,
        required: true
    },
    title: {
        type: String,
        required: true
    }
});

const formattedTopicId = computed(() => {
    return props.topicId.charAt(0).toUpperCase() + props.topicId.slice(1);
});

const handlePageChange = (data) => {
    console.log('Page changed:', data);
    // Handle page change logic here
};
</script>

<template>
    <AppLayout>
        <Head :title="title" />
        <header class="bg-slate-50 dark:bg-gray-800 shadow-md">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    <slot name="header">{{ formattedTopicId }}</slot>
                </h2>
            </div>
        </header>
        <div class="py-12">

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-900 overflow-hidden sm:rounded-lg">
                    <Suspense>
                        <PageNavigator 
                            :topic-id="topicId"
                            @page-changed="handlePageChange"
                        />
                        
                        <template #fallback>
                            <div>Loading...</div>
                        </template>
                    </Suspense>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
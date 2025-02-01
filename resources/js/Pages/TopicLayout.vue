<script setup>
import { ref } from 'vue';
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

const handlePageChange = (data) => {
    console.log('Page changed:', data);
    // Handle page change logic here
};
</script>

<template>
    <AppLayout>
        <Head :title="title" />

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
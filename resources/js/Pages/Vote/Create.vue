<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CreateVoteForm from './Partials/CreateVoteForm.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    question: {
        type: String,
    },
    options: {
        type: Array
    },
    alreadyVoted: {
        type: Boolean
    }
});
</script>

<template>

    <Head title="Vote" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Vote</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow rounded-lg">
                    <CreateVoteForm v-if="!alreadyVoted" :must-verify-email="mustVerifyEmail" :question="question"
                        :options="options" />

                    <div v-else>
                        <div class="p-4 text-sm text-gray-800 rounded-lg bg-gray-50" role="alert">
                            <span class="font-medium">Vote unavailable!</span> Your already voted.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

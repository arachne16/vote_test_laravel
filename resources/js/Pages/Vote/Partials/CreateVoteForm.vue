<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import RadioItem from '@/Components/RadioItem.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

const props = defineProps({
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
        type: Array,
    }
});

const user = usePage().props.auth.user;

const form = useForm({
    answer: props.options[0] ?? undefined,
    question: props.question,
});

const test = false;
</script>

<template>
    <div v-if="user.email_verified_at === null && test">
        <p class="text-sm mt-2 text-gray-800">
            You unable to vote until your email address is unverified.
            <Link :href="route('verification.send')" method="post" as="button"
                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Click here to re-send the verification email.
            </Link>
        </p>

        <div v-show="status === 'verification-link-sent'" class="mt-2 font-medium text-sm text-green-600">
            A new verification link has been sent to your email address.
        </div>
    </div>
    <div v-else-if="form.wasSuccessful">
        <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
            leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
            <div class="p-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
                <span class="font-medium">Success</span> We will record your vote, if you not yet voted. Thanks!
            </div>
        </Transition>
    </div>
    <div v-else>
        <header>
            <h2 class="text-lg font-medium text-gray-900">{{ question }}</h2>
        </header>
        <form @submit.prevent="form.post(route('vote.store'))" class="mt-6 space-y-6">

            <div class="overflow-hidden shadow-sm sm:rounded-lg space-y-4 py-1">
                <RadioItem v-for="(option, index) in options" :key="index" :value="option" v-model="form.answer" />
            </div>
            <PrimaryButton class="ms-4 mt-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Vote
            </PrimaryButton>

        </form>
    </div>
</template>

<script setup>
import { computed, ref } from 'vue';

const props = defineProps({
    value: {
        type: String,
        default: ''
    },
    modelValue: {
        type: String,
        default: ''
    }
})

const input = ref(null);

const isChecked = computed(() => {
    return props.modelValue === props.value;
});

const select = () => {
    input.value.click();
}

defineEmits(['update:modelValue']);
</script>

<template>
    <div class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700" @click="select">
        <input type="radio" :value="value" name="bordered-radio" ref="input"
            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2"
            :checked="isChecked" @change="$emit('update:modelValue', $event.target.value)">
        <label class="w-full py-4 ms-2 text-sm font-medium text-slate-900">{{ value }}</label>
    </div>
</template>
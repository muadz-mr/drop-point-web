<script setup>
import { onMounted, ref } from "vue";

const props = defineProps(["modelValue", "options", "valueParameter", "descriptionParameter"]);

defineEmits(["update:modelValue"]);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute("autofocus")) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });

const optionValue = (option) => {
    return option[props.valueParameter];
};

const optionDescription = (option) => {
    return option[props.descriptionParameter];
};
</script>

<template>
    <select
        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        ref="input"
    >
        <option
            v-for="option in options"
            :key="option.id"
            :value="optionValue(option)"
        >
            {{ optionDescription(option) }}
        </option>
    </select>
</template>

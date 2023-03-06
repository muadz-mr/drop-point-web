<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
    disabled: {
        type: Boolean,
        default: false,
    }
});
</script>

<template>
    <button
        :type="type"
        :disabled="disabled"
        class="inline-flex items-center px-4 py-2 bg-teal-700 dark:bg-teal-300 border border-teal-900 dark:border-teal-400 rounded-md font-semibold text-xs text-gray-50 dark:text-gray-800 uppercase tracking-widest shadow-sm hover:text-teal-900 hover:bg-teal-50 dark:hover:text-teal-50 dark:hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150"
    >
        <slot />
    </button>
</template>

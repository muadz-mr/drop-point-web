<script setup>
import RefreshButton from "@/Components/RefreshButton.vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    refreshRouteName: {
        type: String,
    },
});

const refresh = () => {
    router.get(route(props.refreshRouteName));
};
</script>

<template>
    <div
        class="w-full flex flex-col justify-center items-center p-4 bg-white shadow dark:shadow-gray-900 rounded-lg sm:rounded-xl dark:bg-gray-700/60"
    >
        <p
            class="text-base tracking-wide font-medium text-gray-800 dark:text-white"
        >
            <slot />
        </p>

        <RefreshButton
            class="min-w-max mt-3"
            @click="refresh"
        >
            Refresh
        </RefreshButton>
    </div>
</template>

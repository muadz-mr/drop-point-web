<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({ links: Array });
</script>

<template>
    <div v-if="links.length > 0" class="flex justify-end w-full">
        <div class="flex flex-wrap -mr-2 -mb-1">
            <template v-for="(link, index) in links" :key="index">
                <div
                    v-if="link.url === null"
                    class="pagination-btn"
                    v-html="link.label"
                />
                <Link
                    v-else
                    class="pagination-btn"
                    :class="{ active: link.active }"
                    :href="link.url"
                    v-html="link.label"
                />
            </template>
        </div>
    </div>
</template>

<style scoped>
.pagination-btn {
    @apply mr-2 mb-1 px-4 py-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 hover:text-gray-700 dark:hover:bg-gray-700 dark:hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150;
}

.active {
    @apply bg-indigo-500 text-white dark:bg-white dark:text-gray-800;
}
</style>

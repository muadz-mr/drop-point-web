<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ConfirmationDialog from "@/Components/ConfirmationDialog.vue";
import DangerButton from "@/Components/DangerButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Pagination from "@/Components/Pagination.vue";
import NoData from "@/Components/NoData.vue";
import CreateForm from "./Partials/CreateForm.vue";
import EditForm from "./Partials/EditForm.vue";
import { Head } from "@inertiajs/vue3";
// import { usePagination } from "@/composables/pagination";
import { ref, computed } from "vue";

const props = defineProps({ collectors: Object });
const items = computed(() => props.collectors.data);
const paginationLinks = computed(() => props.collectors?.links);
// const { data, pagination } = usePagination(props.collectors);
let showConfirmationDialog = ref(false);
let showEditDialog = ref(false);
let showAddDialog = ref(false);
let selectedItem = ref(null);

const showDialog = (type, data) => {
    if (type === "delete") {
        showConfirmationDialog.value = true;
    } else if (type === "edit") {
        showEditDialog.value = true;
    } else if (type === "add") {
        showAddDialog.value = true;
        selectedItem = null;
        return;
    }

    selectedItem = data;
};

const closeDialog = () => {
    showConfirmationDialog.value = false;
    showEditDialog.value = false;
    showAddDialog.value = false;
};
</script>

<template>
    <Head title="Collectors" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Collectors
            </h2>
        </template>

        <div class="pt-6 pb-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
                >
                    <section
                        class="w-full p-4 flex justify-end bg-gray-50 dark:bg-gray-900 rounded-lg"
                    >
                        <SecondaryButton
                            type="button"
                            class="min-w-max"
                            @click="showDialog('add')"
                        >
                            Add New
                        </SecondaryButton>
                    </section>

                    <!-- List of card here -->
                    <section class="pt-4 flex flex-wrap gap-4">
                        <div
                            v-if="items.length > 0"
                            class="w-full p-4 bg-white shadow dark:shadow-gray-900 rounded-lg sm:rounded-xl dark:bg-gray-700 sm:flex sm:flex-row sm:items-center sm:justify-between sm:gap-4"
                            v-for="collector in items"
                            :key="collector.id"
                        >
                            <div class="flex flex-col justify-center w-full">
                                <p
                                    class="text-xl font-medium text-gray-800 dark:text-white"
                                >
                                    {{ collector.name }}
                                </p>
                                <p class="pt-1 text-xs text-gray-400">
                                    {{
                                        collector.phone_no
                                            ? collector.phone_no
                                            : "No phone number provided"
                                    }}
                                </p>
                            </div>
                            <div
                                class="flex items-center justify-end gap-4 mt-4 sm:mt-0"
                            >
                                <DangerButton
                                    class="min-w-max"
                                    @click="showDialog('delete', collector)"
                                    >Delete</DangerButton
                                >

                                <PrimaryButton
                                    type="button"
                                    class="min-w-max"
                                    @click="showDialog('edit', collector)"
                                >
                                    Edit
                                </PrimaryButton>
                            </div>
                        </div>

                        <NoData v-else refresh-route-name="collectors.index">No Data Available</NoData>
                    </section>

                    <Pagination class="mt-12" :links="paginationLinks" />
                </div>

                <ConfirmationDialog
                    delete-route-name="collectors.destroy"
                    :item-id="selectedItem?.id"
                    :identifier="selectedItem?.name"
                    :show="showConfirmationDialog"
                    @close="closeDialog"
                />

                <CreateForm :show="showAddDialog" @close="closeDialog" />

                <EditForm
                    :item="selectedItem"
                    :show="showEditDialog"
                    @close="closeDialog"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>

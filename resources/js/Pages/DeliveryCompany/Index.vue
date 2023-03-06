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
import { usePagination } from "@/composables/pagination";
import { ref, computed } from "vue";

const props = defineProps({ companies: Object });
const items = computed(() => props.companies.data);
const paginationLinks = computed(() => props.companies.links);
// const { data, pagination } = usePagination(props.companies);
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
    <Head title="Delivery Companies" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Delivery Companies
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
                            @click="showDialog('add', company)"
                        >
                            Add New
                        </SecondaryButton>
                    </section>

                    <section class="pt-4 flex flex-wrap gap-4">
                        <!-- List of card -->
                        <div
                            v-if="items.length > 0"
                            class="w-full p-4 bg-white shadow dark:shadow-gray-900 rounded-lg sm:rounded-xl dark:bg-gray-700 sm:flex sm:flex-row sm:items-center sm:justify-between sm:gap-4"
                            v-for="company in items"
                            :key="company.id"
                        >
                            <div class="flex flex-col justify-center w-full">
                                <p
                                    class="text-xl font-medium text-gray-800 dark:text-white"
                                >
                                    {{ company.name }}
                                </p>
                                <p class="pt-1 text-xs text-gray-400">
                                    {{ company.slug }}
                                </p>
                            </div>
                            <div
                                class="flex items-center justify-end gap-4 mt-4 sm:mt-0"
                            >
                                <DangerButton
                                    class="min-w-max"
                                    @click="showDialog('delete', company)"
                                    >Delete</DangerButton
                                >

                                <PrimaryButton
                                    type="button"
                                    class="min-w-max"
                                    @click="showDialog('edit', company)"
                                >
                                    Edit
                                </PrimaryButton>
                            </div>
                        </div>
                        <!-- END of list of card -->

                        <NoData
                            v-else
                            refresh-route-name="delivery-companies.index"
                            >No Data Available</NoData
                        >
                    </section>

                    <Pagination class="mt-12" :links="paginationLinks" />
                </div>

                <ConfirmationDialog
                    delete-route-name="delivery-companies.destroy"
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

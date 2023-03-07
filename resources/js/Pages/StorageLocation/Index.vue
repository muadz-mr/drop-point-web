<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ConfirmationDialog from "@/Components/ConfirmationDialog.vue";
import DangerButton from "@/Components/DangerButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import IconButton from "@/Components/IconButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Pagination from "@/Components/Pagination.vue";
import NoData from "@/Components/NoData.vue";
import InputLabel from "@/Components/InputLabel.vue";
import CreateForm from "./Partials/CreateForm.vue";
import EditForm from "./Partials/EditForm.vue";
import { Head } from "@inertiajs/vue3";
// import { usePagination } from "@/composables/pagination";
import { ref, computed } from "vue";
import { ChevronDoubleDownIcon } from "@heroicons/vue/20/solid";

const props = defineProps({ storageLocations: Object, status: Array });
const items = computed(() => props.storageLocations.data);
const statusOptions = computed(() => props.status);
const paginationLinks = computed(() => props.storageLocations?.links);
// const { data, pagination } = usePagination(props.storageLocations);
let showConfirmationDialog = ref(false);
let showEditDialog = ref(false);
let showAddDialog = ref(false);
let selectedItem = ref(null);
let showDetail = ref(false);

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

const getStorageLocationStatusDescription = (storageLocationStatus) => {
    const status = statusOptions.value.filter((status) => {
        return storageLocationStatus == status.value;
    });

    return status[0].description;
};
</script>

<template>
    <Head title="Storage Locations" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Storage Locations
            </h2>
        </template>

        <div class="pt-6 pb-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
                >
                    <section
                        class="w-full p-4 flex justify-end bg-gray-50 dark:bg-gray-700/25 rounded-lg"
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
                            class="w-full p-4 bg-white shadow dark:shadow-gray-900 rounded-lg dark:bg-gray-700 lg:flex lg:flex-row lg:items-center lg:gap-4"
                            v-for="storageLocation in items"
                            :key="storageLocation.id"
                        >
                            <div class="flex flex-col justify-center">
                                <p
                                    class="text-xl font-medium text-gray-800 dark:text-white"
                                >
                                    {{ storageLocation.name }}
                                </p>
                                <p class="pt-1 text-sm text-gray-400">
                                    {{
                                        getStorageLocationStatusDescription(
                                            storageLocation.status
                                        )
                                    }}
                                </p>
                            </div>

                            <!-- Data Contents -->
                            <div
                                class="flex flex-col overflow-hidden lg:overflow-visible lg:flex-row gap-2 lg:gap-4 h-0 lg:p-4 lg:h-auto rounded-md bg-gray-50 dark:bg-gray-800/25"
                                :class="{
                                    'h-auto mt-4 p-4 lg:mt-0': showDetail,
                                }"
                            >
                                <div class="info">
                                    <p class="info__header">Building</p>
                                    <p class="info__content">
                                        {{
                                            storageLocation.building
                                                ? storageLocation.building
                                                : "-"
                                        }}
                                    </p>
                                </div>

                                <div class="info">
                                    <p class="info__header">Building Level</p>
                                    <p class="info__content">
                                        {{
                                            storageLocation.building_level
                                                ? storageLocation.building_level
                                                : "-"
                                        }}
                                    </p>
                                </div>

                                <div class="info">
                                    <p class="info__header">Room</p>
                                    <p class="info__content">
                                        {{
                                            storageLocation.room
                                                ? storageLocation.room
                                                : "-"
                                        }}
                                    </p>
                                </div>

                                <div class="info">
                                    <p class="info__header">Shelf</p>
                                    <p class="info__content">
                                        {{
                                            storageLocation.shelf
                                                ? storageLocation.shelf
                                                : "-"
                                        }}
                                    </p>
                                </div>

                                <div class="info">
                                    <p class="info__header">Space</p>
                                    <p class="info__content">
                                        {{
                                            storageLocation.space
                                                ? storageLocation.space
                                                : "-"
                                        }}
                                    </p>
                                </div>
                            </div>
                            <!-- End of Data Contents -->

                            <div
                                class="flex sm:items-center justify-end gap-4 mt-4 lg:mt-0 lg:ml-auto"
                            >
                                <IconButton
                                    class="min-w-max lg:hidden"
                                    @click="showDetail = !showDetail"
                                >
                                    <Transition
                                        class="transition ease-out duration-500"
                                    >
                                        <ChevronDoubleDownIcon
                                            class="h-5 w-5 transform"
                                            :class="{
                                                'rotate-180':
                                                    showDetail == true,
                                            }"
                                        />
                                    </Transition>
                                </IconButton>

                                <DangerButton
                                    class="min-w-max"
                                    @click="
                                        showDialog('delete', storageLocation)
                                    "
                                    >Delete</DangerButton
                                >

                                <PrimaryButton
                                    type="button"
                                    class="min-w-max"
                                    @click="showDialog('edit', storageLocation)"
                                >
                                    Edit
                                </PrimaryButton>
                            </div>
                        </div>

                        <NoData
                            v-else
                            refresh-route-name="storage-locations.index"
                            >No Data Available</NoData
                        >
                    </section>

                    <Pagination class="mt-12" :links="paginationLinks" />
                </div>

                <ConfirmationDialog
                    delete-route-name="storage-locations.destroy"
                    :item-id="selectedItem?.id"
                    :identifier="selectedItem?.name"
                    :show="showConfirmationDialog"
                    @close="closeDialog"
                />

                <CreateForm
                    :show="showAddDialog"
                    :status-options="statusOptions"
                    @close="closeDialog"
                />

                <EditForm
                    :item="selectedItem"
                    :show="showEditDialog"
                    :status-options="statusOptions"
                    @close="closeDialog"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.info {
    @apply flex lg:flex-col justify-between lg:justify-start min-w-max;
}

.info__header {
    @apply text-base font-medium text-gray-800 dark:text-white;
}

.info__content {
    @apply pt-1 text-sm text-gray-400;
}
</style>

<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import SelectInput from "@/Components/SelectInput.vue";
import TextInput from "@/Components/TextInput.vue";
import UploadFileInput from "@/Components/UploadFileInput.vue";
import { useForm } from "@inertiajs/vue3";
import { ref, computed } from "vue";

const props = defineProps({
    show: Boolean,
    deliveryCompanies: Array,
    units: Array,
    statusOptions: Array,
    storageLocations: Array,
});
const emit = defineEmits(["close"]);
const packageNoInput = ref(null);

const form = useForm({
    delivery_company_id: null,
    package_no: null,
    recipient_phone_no: null,
    recipient_unit_id: null,
    storage_location_id: null,
    status: null,
    one_time_storage_fee: null,
    image_path: null,
});

const createData = () => {
    form.post(route("packages.store"), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => {
            if (
                form.package_no == "" ||
                form.package_no == undefined ||
                !form.package_no
            ) {
                packageNoInput.value.focus();
            }
        },
    });
};

const closeModal = () => {
    emit("close");
    form.clearErrors();
    form.reset();
};

const allowToProceed = computed(
    () =>
        form.delivery_company_id &&
        form.status &&
        form.recipient_unit_id &&
        form.storage_location_id
);
</script>

<template>
    <section class="space-y-6">
        <Modal :show="show" @close="closeModal" :closeable="false">
            <div class="p-6">
                <h2
                    class="text-lg font-medium text-gray-900 dark:text-gray-100"
                >
                    Add Record
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Please enter package information:
                </p>

                <div class="mt-6">
                    <InputLabel
                        for="delivery-company"
                        value="Delivery Company"
                        class="sr-only"
                    />

                    <SelectInput
                        id="delivery-company"
                        v-model="form.delivery_company_id"
                        class="mt-1 block w-full"
                        :options="deliveryCompanies"
                        value-parameter="id"
                        description-parameter="name"
                    />

                    <InputError
                        :message="form.errors.delivery_company_id"
                        class="mt-2"
                    />
                </div>

                <div class="mt-4">
                    <InputLabel
                        for="package-no"
                        value="Package No"
                        class="sr-only"
                    />

                    <TextInput
                        id="package-no"
                        ref="packageNoInput"
                        v-model="form.package_no"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Package No"
                    />

                    <InputError
                        :message="form.errors.package_no"
                        class="mt-2"
                    />
                </div>

                <div class="mt-4">
                    <InputLabel
                        for="recipient-phone-no"
                        value="Recipient Phone No"
                        class="sr-only"
                    />

                    <div class="flex gap-2 items-center">
                        <span class="mt-1 ml-2 dark:text-gray-300">+6</span>
                        <TextInput
                            id="recipient-phone-no"
                            v-model="form.recipient_phone_no"
                            type="tel"
                            class="mt-1 block w-full"
                            placeholder="Recipient Phone No (011xxxxxxxx)"
                        />
                    </div>

                    <InputError
                        :message="form.errors.recipient_phone_no"
                        class="mt-2"
                    />
                </div>

                <div class="mt-4">
                    <InputLabel
                        for="recipient-unit"
                        value="Recipient Unit"
                        class="sr-only"
                    />

                    <SelectInput
                        id="recipient-unit"
                        v-model="form.recipient_unit_id"
                        class="mt-1 block w-full"
                        :options="units"
                        value-parameter="id"
                        description-parameter="block"
                    />

                    <InputError
                        :message="form.errors.recipient_unit_id"
                        class="mt-2"
                    />
                </div>

                <div class="mt-4">
                    <InputLabel
                        for="storage-location"
                        value="Storage Location"
                        class="sr-only"
                    />

                    <SelectInput
                        id="storage-location"
                        v-model="form.storage_location_id"
                        class="mt-1 block w-full"
                        :options="storageLocations"
                        value-parameter="id"
                        description-parameter="name"
                    />

                    <InputError
                        :message="form.errors.storage_location_id"
                        class="mt-2"
                    />
                </div>

                <div class="mt-4">
                    <InputLabel for="status" value="Status" class="sr-only" />

                    <SelectInput
                        id="status"
                        v-model="form.status"
                        class="mt-1 block w-full"
                        :options="statusOptions"
                        value-parameter="value"
                        description-parameter="description"
                    />

                    <InputError :message="form.errors.status" class="mt-2" />
                </div>

                <div class="mt-4">
                    <InputLabel
                        for="one-time-storage-fee"
                        value="One Time Storage Fee"
                        class="sr-only"
                    />

                    <div class="flex gap-2 items-center">
                        <span class="mt-1 ml-2 dark:text-gray-300">RM</span>
                        <TextInput
                            id="one-time-storage-fee"
                            v-model="form.one_time_storage_fee"
                            type="number"
                            min="0"
                            class="mt-1 block w-full"
                            placeholder="One Time Storage Fee (1)"
                        />
                    </div>

                    <InputError
                        :message="form.errors.one_time_storage_fee"
                        class="mt-2"
                    />
                </div>

                <div class="mt-4">
                    <InputLabel for="image" value="Image" class="sr-only" />

                    <UploadFileInput
                        @load:filepond="form.image_path = filePath"
                        @remove:filepond="form.image_path = null"
                        target="packages"
                    />

                    <InputError
                        :message="form.errors.image_path"
                        class="mt-2"
                    />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal">
                        Cancel
                    </SecondaryButton>

                    <PrimaryButton
                        class="ml-3"
                        :class="{
                            'opacity-25': form.processing || !allowToProceed,
                        }"
                        :disabled="form.processing || !allowToProceed"
                        @click="createData"
                    >
                        Save
                    </PrimaryButton>
                </div>
            </div>
        </Modal>
    </section>
</template>

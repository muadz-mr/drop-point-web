<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import SelectInput from "@/Components/SelectInput.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";

const props = defineProps({ show: Boolean, statusOptions: Array });
const emit = defineEmits(["close"]);
const nameInput = ref(null);

const form = useForm({
    name: null,
    building: null,
    building_level: null,
    room: null,
    shelf: null,
    space: null,
    status: 0,
});

const createData = () => {
    form.post(route("storage-locations.store"), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => {
            if (form.name == '' || form.name == undefined || !form.name) {
                nameInput.value.focus();
            }
        },
    });
};

const closeModal = () => {
    emit("close");
    form.clearErrors();
    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <Modal :show="show" @close="closeModal">
            <div class="p-6">
                <h2
                    class="text-lg font-medium text-gray-900 dark:text-gray-100"
                >
                    Add Record
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Please enter storage location information:
                </p>

                <div class="mt-6">
                    <InputLabel
                        for="name"
                        value="Storage Name"
                        class="sr-only"
                    />

                    <TextInput
                        id="name"
                        ref="nameInput"
                        v-model="form.name"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Storage Name"
                        @keyup.enter="createData"
                    />

                    <InputError :message="form.errors.name" class="mt-2" />
                </div>

                <div class="mt-4">
                    <InputLabel
                        for="building"
                        value="Building"
                        class="sr-only"
                    />

                    <TextInput
                        id="building"
                        v-model="form.building"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Building"
                    />

                    <InputError :message="form.errors.building" class="mt-2" />
                </div>

                <div class="mt-4">
                    <InputLabel
                        for="building-level"
                        value="Building Level"
                        class="sr-only"
                    />

                    <TextInput
                        id="building-level"
                        v-model="form.building_level"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Building Level"
                    />

                    <InputError
                        :message="form.errors.building_level"
                        class="mt-2"
                    />
                </div>

                <div class="mt-4">
                    <InputLabel for="room" value="Room" class="sr-only" />

                    <TextInput
                        id="room"
                        v-model="form.room"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Room"
                    />

                    <InputError :message="form.errors.room" class="mt-2" />
                </div>

                <div class="mt-4">
                    <InputLabel for="shelf" value="Shelf" class="sr-only" />

                    <TextInput
                        id="shelf"
                        v-model="form.shelf"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Shelf"
                    />

                    <InputError :message="form.errors.shelf" class="mt-2" />
                </div>

                <div class="mt-4">
                    <InputLabel for="space" value="Space" class="sr-only" />

                    <TextInput
                        id="space"
                        v-model="form.space"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Space"
                    />

                    <InputError :message="form.errors.space" class="mt-2" />
                </div>

                <div class="mt-4">
                    <InputLabel for="status" value="Status" class="sr-only" />

                    <SelectInput
                        id="status"
                        v-model="form.status"
                        class="mt-1 block w-full"
                        :options="statusOptions"
                    />

                    <InputError :message="form.errors.status" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal">
                        Cancel
                    </SecondaryButton>

                    <PrimaryButton
                        class="ml-3"
                        :class="{ 'opacity-25': form.processing || !form.name }"
                        :disabled="form.processing || !form.name"
                        @click="createData"
                    >
                        Save
                    </PrimaryButton>
                </div>
            </div>
        </Modal>
    </section>
</template>

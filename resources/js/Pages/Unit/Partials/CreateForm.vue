<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({ show: Boolean });
const emit = defineEmits(["close"]);
const blockInput = ref(null);

const form = useForm({
    block: null,
    level: null,
    number: null,
});

const createData = () => {
    form.post(route("units.store"), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => {
            if (form.block == "" || form.block == undefined || !form.block) {
                blockInput.value.focus();
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
                    Please enter unit information:
                </p>

                <div class="mt-6">
                    <InputLabel
                        for="block"
                        value="Unit Block"
                        class="sr-only"
                    />

                    <TextInput
                        id="block"
                        ref="blockInput"
                        v-model="form.block"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Unit Block"
                    />

                    <InputError :message="form.errors.block" class="mt-2" />
                </div>

                <div class="mt-4">
                    <InputLabel for="level" value="Level" class="sr-only" />

                    <TextInput
                        id="level"
                        v-model="form.level"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Unit Level"
                    />

                    <InputError :message="form.errors.level" class="mt-2" />
                </div>

                <div class="mt-4">
                    <InputLabel
                        for="number"
                        value="Unit Number"
                        class="sr-only"
                    />

                    <TextInput
                        id="number"
                        v-model="form.number"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Unit Number"
                    />

                    <InputError :message="form.errors.number" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal">
                        Cancel
                    </SecondaryButton>

                    <PrimaryButton
                        class="ml-3"
                        :class="{ 'opacity-25': form.processing || !form.block }"
                        :disabled="form.processing || !form.block"
                        @click="createData"
                    >
                        Save
                    </PrimaryButton>
                </div>
            </div>
        </Modal>
    </section>
</template>

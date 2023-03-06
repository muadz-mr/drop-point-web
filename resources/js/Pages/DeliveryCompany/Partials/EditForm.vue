<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import { ref, watch } from "vue";

const props = defineProps({ show: Boolean, item: Object });
const emit = defineEmits(["close"]);
const nameInput = ref(null);

const form = useForm({
    name: "",
});

watch(
    () => props.show,
    () => {
        if (props.show) {
            form.name = props.item.name;
        }
    }
);

const editData = () => {
    form.patch(route("delivery-companies.update", props.item.id), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => nameInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    emit("close");
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
                    Edit Record
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ item ? item.name : "-" }}
                </p>

                <div class="mt-6">
                    <InputLabel
                        for="name"
                        value="Company Name"
                        class="sr-only"
                    />

                    <TextInput
                        id="name"
                        ref="nameInput"
                        v-model="form.name"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Company Name"
                        @keyup.enter="editData"
                    />

                    <InputError :message="form.errors.name" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal">
                        Cancel
                    </SecondaryButton>

                    <PrimaryButton
                        class="ml-3"
                        :class="{ 'opacity-25': form.processing || !form.name }"
                        :disabled="form.processing || !form.name"
                        @click="editData"
                    >
                        Save
                    </PrimaryButton>
                </div>
            </div>
        </Modal>
    </section>
</template>

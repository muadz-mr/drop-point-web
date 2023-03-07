<script setup>
import DangerButton from "@/Components/DangerButton.vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import { ref, watch } from "vue";

const props = defineProps({
    show: Boolean,
    deleteRouteName: String,
    itemId: Number,
    identifier: String,
});
const emit = defineEmits(["close"]);

const form = useForm({
    id: "",
});

watch(
    () => props.show,
    () => {
        if (props.show) {
            form.id = props.itemId;
        }
    }
);

const deleteData = () => {
    form.delete(route(props.deleteRouteName, props.itemId), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
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
        <Modal :show="props.show" @close="closeModal" :closeable="false">
            <div class="p-6">
                <h2
                    class="text-lg font-medium text-gray-900 dark:text-gray-100"
                >
                    Delete Record
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Are you sure you want to delete {{ props.identifier }}?
                </p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal">
                        Cancel
                    </SecondaryButton>

                    <DangerButton
                        class="ml-3"
                        :class="{ 'opacity-25': form.processing || !form.id }"
                        :disabled="form.processing || !form.id"
                        @click="deleteData"
                    >
                        Delete
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>

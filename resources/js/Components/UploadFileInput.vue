<script setup>
import { ref } from "vue";
import vueFilePond from "vue-filepond";
import "filepond/dist/filepond.min.css";

// Import image preview plugin styles
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";

// Import the plugin code
import FilePondPluginFilePoster from "filepond-plugin-file-poster";

// Import the plugin styles
import "filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css";

// Import image preview and file type validation plugins
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";

const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview,
    FilePondPluginFilePoster
);

const props = defineProps(["target", "previousFile"]);
const emit = defineEmits([
    "init:filepond",
    "load:filepond",
    "revert:filepond",
    "remove:filepond",
]);

const filePath = ref("");
const files = ref([]);
const handleFilePondInit = () => {
    console.log("filepond init");
    if (props.previousFile) {
        files.value = [
            {
                source: `/${previousFile}`,
                options: {
                    type: "local",
                    metadata: {
                        poster: `/${previousFile}`,
                    },
                },
            },
        ];
    } else {
        files.value = [];
    }
};
const handleFilePondLoad = (response) => {
    const parsedResponse = JSON.parse(response);
    filePath.value = parsedResponse.data;
    emit("load:filepond", filePath);
};
const handleFilePondRevert = async (uniqueId, load, error) => {
    emit("revert:filepond");
    await axios.post("/uploads/revert", {
        image_path: filePath.value,
    });
    load();
};
const handleFilePondRemove = (source, load, error) => {
    emit("remove:filepond");
    load();
};
</script>

<template>
    <FilePond
        name="imageFilepond"
        ref="pond"
        :allow-multiple="false"
        accepted-file-types="image/png, image/jpeg"
        :server="{
            url: '',
            timeout: 7000,
            process: {
                url: `/uploads?target=${target}`,
                method: 'POST',
                withCredentials: false,
                headers: {
                    'X-CSRF-TOKEN': $page.props.csrf_token,
                },
                onload: handleFilePondLoad,
                onerror: () => {},
            },
            remove: handleFilePondRemove,
            revert: handleFilePondRevert,
        }"
        :files="files"
        @init="handleFilePondInit"
    ></FilePond>
    {{ files }}
</template>

<style lang="scss" scoped></style>

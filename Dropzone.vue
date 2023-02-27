<script setup>
import {defineProps, ref} from "vue";

const props = defineProps({
    files: Array
})

// Pre-loaded data
const files = ref(props.files);
// const files = ref([{name: 'File1.jpg', id: 0}, {name: "File2.png", id: 1}]);

// for class toggle
const active = ref(false);

function remove (index) {
    files.value.splice(index, 1);
}

const drop = (e) => {
    Object.keys(e.dataTransfer.files).forEach(function(key) {
        files.value.push({name: e.dataTransfer.files[key].name});
    })
};

const selectedFile = () => {
    Object.keys(document.querySelector(".input1").files).forEach(function(key) {
        files.value.push({name: document.querySelector(".input1").files[key].name});
    })
};

const toggleActive = () => {
    active.value = !active.value;
};
</script>

<template>
    <div class="max-w-xl flex-col text-left text-lg font-medium text-gray-500">
        <div  @drop.prevent="drop" @change="selectedFile">
            <div
                @dragenter.prevent="toggleActive"
                @dragleave.prevent="toggleActive"
                @dragover.prevent
                @drop.prevent="toggleActive"
                :class="{ 'bg-green-300 text-slate-200 border-white-300': active }"
                class="h-full overflow-auto p-8 w-full h-full flex flex-col border-2 border-gray-300 border-dashed rounded-lg appearance-none cursor-pointer hover:border-gray-400 focus:outline-none"
            >
                <span class="flex flex-wrap justify-center items-center space-x-2">Перенесите Ваш файл</span>
                <span class="flex flex-wrap justify-center items-center space-x-2">ИЛИ</span>
                <label for="dropzoneFile" :class="{ 'bg-green-300 text-slate-200': active }"
                       class="flex flex-wrap justify-center text-blue-600 underline space-x-2 ">Выберите файл</label>
                <input type="file" id="dropzoneFile" class="hidden input1" multiple/>
            </div>
        </div>
        <div v-for="(file, index) in files" :key="file" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b-2">
            <span>Файл: {{ file.name }}</span>
            <button
                class="ml-2"
                type="button"
                @click="remove(index)"
                title="Удалить файл"
            >
                <b>×</b>
            </button>
        </div>
    </div>
</template>


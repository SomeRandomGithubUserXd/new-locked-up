<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import FileInput from "@/Components/Common/FileInput.vue";
import {watch} from "vue";

const props = defineProps({
    modelValue: {
        required: true,
        type: Object,
        default: {
            // imageSrc: [String, File],
            header: String,
            shortDescription: String
        }
    }
})

watch(() => props.modelValue, value => {

}, {deep: true})

const emit = defineEmits(['remove'])
</script>

<template>
    <div>
        <form class="flex flex-col shadow p-3 bg-gray-100 rounded" @submit.prevent>
            <div>
                <input-label for="file" value="Иконка"/>
                <input
                    id="file"
                    type="file"
                />
            </div>
            <div class="mt-3">
                <InputLabel for="header" value="Заголовок"/>
                <TextInput
                    id="header"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue.header"
                    required
                    autofocus
                    autocomplete="header"
                />
            </div>
            <div class="mt-3">
                <InputLabel for="short_description" value="Краткое описание"/>
                <textarea
                    id="short_description"
                    v-model="modelValue.shortDescription"
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </textarea>
            </div>
            <div>
                <button type="button"
                        @click.prevent="emit('remove', modelValue)"
                        class="w-full mt-3 flex justify-center py-2 px-4 border border-transparent rounded-md shadow-xl text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Удалить
                </button>
            </div>
        </form>
    </div>
</template>

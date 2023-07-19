<script setup>
import {useForm} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import {ref} from "vue";
import {getAttribute as getAttributeInstance} from "@/Traits/LocaleTrait";
import SwitchLangGroup from "@/Components/Quest/SwitchLangGroup.vue";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
import Checkbox from "@/Components/Checkbox.vue";
import Editor from '@tinymce/tinymce-vue'

const props = defineProps({
    modelValue: {
        required: false,
        default: useForm({})
    },
    questList: Array
})

const locale = ref('ru')

const emit = defineEmits(['submit'])
const getAttribute = (name) => {
    return getAttributeInstance(name, locale.value)
}
</script>

<template>
    <form class="space-y-6" @submit.prevent="emit('submit')">
        <switch-lang-group class="mr-3" v-model="locale" @click.stop/>
        <div class="flex flex-col gap-3">
            <label for="is_published">
                <checkbox id="is_published"
                          v-model:checked="modelValue.is_published"/>
                <span class="ml-2 text-sm text-gray-600">Опубликована</span>
            </label>
        </div>
        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6">
                <input-label for="alias" :value="`URL (${locale})`"/>
                <TextInput
                    id="alias"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue[getAttribute('alias')]"

                />
                <InputError class="mt-2" :message="modelValue.errors[getAttribute('alias')]"/>
            </div>
            <div class="col-span-6 sm:col-span-2">
                <input-label for="meta_title" :value="`Title страницы (${locale})`"/>
                <TextInput
                    id="meta_title"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue[getAttribute('meta_title')]"

                />
                <InputError class="mt-2" :message="modelValue.errors[getAttribute('meta_title')]"/>
            </div>
            <div class="col-span-6 sm:col-span-2">
                <input-label for="meta_description" :value="`Description страницы (${locale})`"/>
                <TextInput
                    id="meta_description"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue[getAttribute('meta_description')]"

                />
                <InputError class="mt-2" :message="modelValue.errors[getAttribute('meta_description')]"/>
            </div>
            <div class="col-span-6 sm:col-span-2">
                <input-label for="meta_keywords" :value="`Keywords (${locale})`"/>
                <TextInput
                    id="meta_keywords"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue[getAttribute('meta_keywords')]"

                />
                <InputError class="mt-2" :message="modelValue.errors[getAttribute('meta_keywords')]"/>
            </div>
            <div class="col-span-6 sm:col-span-2">
                <input-label for="og_title" :value="`OG Title (${locale})`"/>
                <TextInput
                    id="og_title"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue[getAttribute('og_title')]"

                />
                <InputError class="mt-2" :message="modelValue.errors[getAttribute('og_title')]"/>
            </div>
            <div class="col-span-6 sm:col-span-2">
                <input-label for="og_type" :value="`OG Type`"/>
                <TextInput
                    id="og_type"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue.og_type"

                />
                <InputError class="mt-2" :message="modelValue.errors.og_type"/>
            </div>
            <div class="col-span-6 sm:col-span-2">
                <input-label for="og_description" :value="`OG Description (${locale})`"/>
                <TextInput
                    id="og_description"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue[getAttribute('og_description')]"

                />
                <InputError class="mt-2" :message="modelValue.errors[getAttribute('og_description')]"/>
            </div>
            <div class="col-span-6 sm:col-span-6">
                <input-label for="title" :value="`Заголовок в карточке (${locale})`"/>
                <TextInput
                    id="title"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue[getAttribute('title')]"

                />
                <InputError class="mt-2" :message="modelValue.errors[getAttribute('title')]"/>
            </div>
            <div class="col-span-6 sm:col-span-6">
                <input-label for="announce" :value="`Текст в карточке (${locale})`"/>
                <textarea
                    id="announce"
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    type="text"
                    v-model="modelValue[getAttribute('announce')]"
                ></textarea>
                <InputError class="mt-2" :message="modelValue.errors[getAttribute('announce')]"/>
            </div>
            <div class="col-span-6 sm:col-span-6">
                <input-label for="badge" :value="`Бейдж (${locale})`"/>
                <textarea
                    id="badge"
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    type="text"
                    v-model="modelValue[getAttribute('badge')]"
                ></textarea>
                <InputError class="mt-2" :message="modelValue.errors[getAttribute('badge')]"/>
            </div>
            <div class="col-span-6 sm:col-span-6">
                <input-label for="h1" :value="`H1 (${locale})`"/>
                <TextInput
                    id="h1"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue[getAttribute('h1')]"

                />
                <InputError class="mt-2" :message="modelValue.errors[getAttribute('h1')]"/>
            </div>
            <div class="col-span-6 sm:col-span-6">
                <input-label for="text" :value="`Текст (${locale})`"/>
                <textarea
                    id="text"
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    type="text"
                    v-model="modelValue[getAttribute('text')]"
                ></textarea>
                <InputError class="mt-2" :message="modelValue.errors[getAttribute('text')]"/>
            </div>
            <div class="col-span-6 sm:col-span-6">
                <input-label for="conditions_header" :value="`Заголовок условий (${locale})`"/>
                <TextInput
                    id="conditions_header"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue[getAttribute('conditions_header')]"

                />
                <InputError class="mt-2" :message="modelValue.errors[getAttribute('conditions_header')]"/>
            </div>
            <div class="col-span-6 sm:col-span-6">
                <input-label for="conditions_text" :value="`Условия (${locale})`"/>
                <Editor
                    id="conditions_text"
                    lang="ru"
                    v-model="modelValue[getAttribute('conditions_text')]"
                    api-key="no-api-key"
                />
                <InputError class="mt-2" :message="modelValue.errors[getAttribute('conditions_text')]"/>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <input-label for="book_button_text" :value="`Текст кнопки 'забронировать' (${locale})`"/>
                <TextInput
                    id="book_button_text"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue[getAttribute('book_button_text')]"

                />
                <InputError class="mt-2" :message="modelValue.errors[getAttribute('book_button_text')]"/>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <input-label for="book_button_link" :value="`Ссылка кнопки 'забронировать' (${locale})`"/>
                <TextInput
                    id="book_button_link"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue[getAttribute('book_button_link')]"

                />
                <InputError class="mt-2" :message="modelValue.errors[getAttribute('book_button_link')]"/>
            </div>
            <div class="col-span-6 sm:col-span-6">
                <input-label for="instruction_text" :value="`Инструкция (${locale})`"/>
                <Editor
                    id="full_description"
                    lang="ru"
                    v-model="modelValue[getAttribute('instruction_text')]"
                    api-key="no-api-key"
                />
                <InputError class="mt-2" :message="modelValue.errors[getAttribute('instruction_text')]"/>
            </div>
            <div class="col-span-6 sm:col-span-6">
                <input-label for="seo_text" :value="`Текст после инструкции (${locale})`"/>
                <textarea
                    id="seo_text"
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    type="text"
                    v-model="modelValue[getAttribute('seo_text')]"
                ></textarea>
                <InputError class="mt-2" :message="modelValue.errors[getAttribute('seo_text')]"/>
            </div>
            <div class="col-span-6 sm:col-span-6">
                <input-label for="quests_title" :value="`Заголовок блока квестов (${locale})`"/>
                <TextInput
                    id="quests_title"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue[getAttribute('quests_title')]"

                />
                <InputError class="mt-2" :message="modelValue.errors[getAttribute('quests_title')]"/>
            </div>
            <div class="col-span-6 sm:col-span-6">
                <InputLabel for="quests" value="Квесты"/>
                <div class="mt-1">
                    <v-select class="scrollable-select" v-model="modelValue.quests_attached"
                              multiple=""
                              label="name_ru"
                              :reduce="option => option.id"
                              :options="props.questList"/>
                    <InputError class="mt-2" :message="modelValue.errors.quests_attached"/>
                </div>
            </div>
            <div class="col-span-6 sm:col-span-6">
                <input-label for="file" value="OG Изображение"/>
                <input
                    id="file"
                    type="file"
                />
            </div>
            <div class="col-span-6 sm:col-span-6">
                <input-label for="file" value="Изображение"/>
                <input
                    id="file"
                    type="file"
                />
            </div>
        </div>
        <div class="mt-5">
            <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Сохранить
            </button>
        </div>
    </form>
</template>

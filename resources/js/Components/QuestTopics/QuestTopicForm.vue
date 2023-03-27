<script setup>
import {useForm} from "@inertiajs/vue3";
import {getAttribute as getAttributeInstance} from "@/Traits/LocaleTrait";
import {ref} from "vue";
import SwitchLangGroup from "@/Components/Quest/SwitchLangGroup.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import Editor from '@tinymce/tinymce-vue'
import Checkbox from "@/Components/Checkbox.vue";

const props = defineProps({
    modelValue: {
        required: false,
        default: useForm({})
    }
})

const emit = defineEmits(['submit'])

const locale = ref('ru')

const getAttribute = (name) => {
    return getAttributeInstance(name, locale.value)
}
</script>

<template>
    <form class="space-y-6" @submit.prevent="emit('submit')">
        <switch-lang-group class="mr-3" v-model="locale" @click.stop/>
        <div>
            <label for="active">
                <Checkbox id="active"
                          v-model:checked="modelValue.active"/>
                <span class="ml-2 text-sm text-gray-600">Активна</span>
            </label>
        </div>
        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="name" :value="`Название (${locale})`"/>
                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue[getAttribute('name')]"
                    autofocus
                />
                <InputError class="mt-2" :message="modelValue.errors[getAttribute('name')]"/>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="title" :value="`Meta Title (${locale})`"/>
                <TextInput
                    id="title"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue[getAttribute('title')]"
                />
                <InputError class="mt-2" :message="modelValue.errors[getAttribute('title')]"/>
            </div>
            <div class="col-span-6 sm:col-span-6">
                <InputLabel for="description" :value="`Meta Description (${locale})`"/>
                <textarea
                    id="description"
                    v-model="modelValue[getAttribute('description')]"
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </textarea>
                <InputError class="mt-2" :message="modelValue.errors[getAttribute('description')]"/>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="keywords" :value="`Meta Keywords (${locale})`"/>
                <TextInput
                    id="keywords"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue[getAttribute('keywords')]"
                />
                <InputError class="mt-2" :message="modelValue.errors[getAttribute('keywords')]"/>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="og_title" :value="`OG Title (${locale})`"/>
                <TextInput
                    id="og_title"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue[getAttribute('og_title')]"
                />
                <InputError class="mt-2" :message="modelValue.errors[getAttribute('og_title')]"/>
            </div>
            <div class="col-span-6 sm:col-span-6">
                <InputLabel for="og_description" :value="`OG Description (${locale})`"/>
                <textarea
                    id="og_description"
                    v-model="modelValue[getAttribute('og_description')]"
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </textarea>
                <InputError class="mt-2" :message="modelValue.errors[getAttribute('og_description')]"/>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="og_type" :value="`OG Type`"/>
                <TextInput
                    id="og_type"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue.og_type"
                />
                <InputError class="mt-2" :message="modelValue.errors.og_type"/>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="og_url" :value="`OG URL`"/>
                <TextInput
                    id="og_url"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue.og_url"
                />
                <InputError class="mt-2" :message="modelValue.errors.og_url"/>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="h1" :value="`H1 (${locale})`"/>
                <TextInput
                    id="h1"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue[getAttribute('h1')]"
                />
                <InputError class="mt-2" :message="modelValue.errors[getAttribute('h1')]"/>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="position" :value="`Порядок`"/>
                <TextInput
                    id="position"
                    type="number"
                    class="mt-1 block w-full"
                    v-model="modelValue.position"
                />
                <InputError class="mt-2" :message="modelValue.errors.position"/>
            </div>
            <div class="col-span-6 sm:col-span-6">
                <InputLabel for="full_description" :value="`SEO (${locale})`"/>
                <div class="mt-1">
                    <Editor
                        id="seo"
                        lang="ru"
                        v-model="modelValue[getAttribute('seo')]"
                        api-key="no-api-key"
                    />
                </div>
                <InputError class="mt-2"
                            :message="modelValue.errors[getAttribute('seo')]"/>
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

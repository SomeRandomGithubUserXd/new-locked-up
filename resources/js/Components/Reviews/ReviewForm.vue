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
    },
    questList: Array
})

const emit = defineEmits(['submit'])
</script>

<template>
    <form class="space-y-6" @submit.prevent="emit('submit')">
        <div>
            <label for="is_approved">
                <checkbox id="is_approved"
                          v-model:checked="modelValue.is_approved"/>
                <span class="ml-2 text-sm text-gray-600">Одобрен</span>
            </label>
        </div>
        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-2">
                <InputLabel for="name" value="Имя"/>
                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue.name"
                    autofocus
                />
                <InputError class="mt-2" :message="modelValue.errors.name"/>
            </div>
            <div class="col-span-6 sm:col-span-2">
                <InputLabel for="date" value="Дата"/>
                <TextInput
                    id="date"
                    type="date"
                    class="mt-1 block w-full"
                    v-model="modelValue.review_date"
                />
                <InputError class="mt-2" :message="modelValue.errors.review_date"/>
            </div>
            <div class="col-span-6 sm:col-span-2">
                <InputLabel for="rate" value="Оценка"/>
                <TextInput
                    id="rate"
                    type="number"
                    min="1"
                    max="5"
                    class="mt-1 block w-full"
                    v-model="modelValue.rate"
                />
                <InputError class="mt-2" :message="modelValue.errors.rate"/>
            </div>
            <div class="col-span-6 sm:col-span-6">
                <InputLabel for="review" value="Содержание"/>
                <div class="mt-1">
                            <textarea
                                id="review"
                                v-model="modelValue.review"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </textarea>
                </div>
                <InputError class="mt-2"
                            :message="modelValue.errors.review"/>
            </div>
            <div class="col-span-6 sm:col-span-3 flex flex-col">
                <InputLabel for="quest_id" value="Квест"/>
                <select v-model="modelValue.quest_id"
                        id="quest_id"
                        class="appearance-none mt-auto block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">>
                    <option :value="quest.id" v-for="quest in props.questList">
                        {{ quest.name_ru }}
                    </option>
                </select>
                <InputError class="mt-2" :message="modelValue.errors.quest_id"/>
            </div>
            <div class="col-span-6 sm:col-span-3 flex flex-col">
                <InputLabel for="lang" value="Язык"/>
                <select v-model="modelValue.language"
                        id="lang"
                        class="appearance-none mt-auto block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">>
                    <option value="ru">
                        Русский
                    </option>
                    <option value="en">
                        English
                    </option>
                </select>
                <InputError class="mt-2" :message="modelValue.errors.language"/>
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

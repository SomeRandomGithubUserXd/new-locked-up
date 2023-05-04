<script setup>
import {router, useForm} from "@inertiajs/vue3";
import {computed, ref} from "vue";
import {getAttribute as getAttributeInstance} from "@/Traits/LocaleTrait";
import SwitchLangGroup from "@/Components/Quest/SwitchLangGroup.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import Checkbox from "@/Components/Checkbox.vue";
import DataTable from "@/Components/Common/DataTable.vue";

const props = defineProps({
    modelValue: {
        required: false,
        type: Object,
        default: useForm({})
    },
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
        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-6">
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
            <div class="col-span-6 sm:col-span-6">
                <InputLabel for="time" :value="`Время`"/>
                <TextInput
                    id="time"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue.time"
                />
                <InputError class="mt-2" :message="modelValue.errors.time"/>
            </div>
            <div class="col-span-6 sm:col-span-6">
                <InputLabel for="price_workday" :value="`Цена (будни)`"/>
                <TextInput
                    id="price_workday"
                    type="number"
                    class="mt-1 block w-full"
                    v-model="modelValue.price_workday"
                />
                <InputError class="mt-2" :message="modelValue.errors.price_workday"/>
            </div>
            <div class="col-span-6 sm:col-span-6">
                <InputLabel for="price_weekend" :value="`Цена (выходные)`"/>
                <TextInput
                    id="price_weekend"
                    type="number"
                    class="mt-1 block w-full"
                    v-model="modelValue.price_weekend"
                />
                <InputError class="mt-2" :message="modelValue.errors.price_weekend"/>
            </div>
            <div class="col-span-6 sm:col-span-6">
                <InputLabel for="description" :value="`Описание (${locale})`"/>
                <textarea
                    id="description"
                    v-model="modelValue[getAttribute('description')]"
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </textarea>
                <InputError class="mt-2" :message="modelValue.errors[getAttribute('description')]"/>
            </div>
            <div class="col-span-6 sm:col-span-6">
                <InputLabel for="program" :value="`Программа (${locale})`"/>
                <textarea
                    id="program"
                    v-model="modelValue[getAttribute('program')]"
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </textarea>
                <InputError class="mt-2" :message="modelValue.errors[getAttribute('program')]"/>
            </div>
            <div class="col-span-6 sm:col-span-6">
                <InputLabel for="class_name" :value="`Класс`"/>
                <TextInput
                    id="class_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue.class_name"
                />
                <InputError class="mt-2" :message="modelValue.errors.class_name"/>
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

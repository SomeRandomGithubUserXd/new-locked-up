<script setup>
import {useForm} from "@inertiajs/vue3";
import {ref} from "vue";
import {getAttribute as getAttributeInstance} from "@/Traits/LocaleTrait";
import SwitchLangGroup from "@/Components/Quest/SwitchLangGroup.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import Checkbox from "@/Components/Checkbox.vue";

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
    getAttributeInstance(name, locale.value)
}
</script>

<template>
    <form class="space-y-6" @submit.prevent="emit('submit')">
        <switch-lang-group class="mr-3" v-model="locale" @click.stop/>
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
                <InputLabel for="address" :value="`Адрес (${locale})`"/>
                <TextInput
                    id="address"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue[getAttribute('address')]"
                />
                <InputError class="mt-2" :message="modelValue.errors[getAttribute('address')]"/>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="longitude" value="Долгота"/>
                <TextInput
                    id="longitude"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue.longitude"
                />
                <InputError class="mt-2" :message="modelValue.errors.longitude"/>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="latitude" value="Широта"/>
                <TextInput
                    id="latitude"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue.latitude"
                />
                <InputError class="mt-2" :message="modelValue.errors.latitude"/>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="phone" value="Телефон"/>
                <TextInput
                    id="phone"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue.phone"
                />
                <InputError class="mt-2" :message="modelValue.errors.phone"/>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="phone" value="email"/>
                <TextInput
                    id="phone"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue.email"
                />
                <InputError class="mt-2" :message="modelValue.errors.email"/>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <label for="show_at_kids_page">
                    <Checkbox id="show_at_kids_page"
                              v-model:checked="modelValue.show_at_kids_page"/>
                    <span class="ml-2 text-sm text-gray-600">Показывать на странице "детям"</span>
                </label>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <label for="show_at_corporate_parties_page">
                    <Checkbox id="show_at_corporate_parties_page"
                              v-model:checked="modelValue.show_at_corporate_parties_page"/>
                    <span class="ml-2 text-sm text-gray-600">Показывать на странице "корпоративы"</span>
                </label>
            </div>
        </div>
    </form>
</template>

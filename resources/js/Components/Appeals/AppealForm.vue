<script setup>
import {useForm} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";

const props = defineProps({
    modelValue: {
        required: false,
        type: Object,
        default: useForm({})
    },
    statuses: Array,
    sources: Array,
    forms: Array,
})

const emit = defineEmits(['submit'])

</script>

<template>
    <form class="space-y-6" @submit.prevent="emit('submit')">
        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-2">
                <InputLabel for="name" value="Имя"/>
                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue.name"
                />
                <InputError class="mt-2" :message="modelValue.errors.name"/>
            </div>
            <div class="col-span-6 sm:col-span-2">
                <InputLabel for="phone" value="Телефон"/>
                <TextInput
                    id="phone"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue.phone"
                />
                <InputError class="mt-2" :message="modelValue.errors.phone"/>
            </div>
            <div class="col-span-6 sm:col-span-2">
                <InputLabel for="email" value="E-Mail"/>
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="modelValue.email"
                />
                <InputError class="mt-2" :message="modelValue.errors.email"/>
            </div>
        </div>
        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-2">
                <label for="quest" class="block text-sm font-medium text-gray-700">
                    Статус </label>
                <div class="mt-1">
                    <select
                        id="quest"
                        v-model="modelValue.status"
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option v-for="status in props.statuses">
                            {{ status }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-span-6 sm:col-span-2">
                <label for="quest" class="block text-sm font-medium text-gray-700">
                    Источник </label>
                <div class="mt-1">
                    <select
                        id="quest"
                        v-model="modelValue.source"
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option v-for="source in props.sources">
                            {{ source }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-span-6 sm:col-span-2">
                <label for="quest" class="block text-sm font-medium text-gray-700">
                    Форма </label>
                <div class="mt-1">
                    <select
                        id="quest"
                        v-model="modelValue.form"
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option v-for="form in props.forms">
                            {{ form }}
                        </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-6">
                <label for="comment" class="block text-sm font-medium text-gray-700"> Комментарий </label>
                <div class="mt-1">
                    <textarea
                        id="comment"
                        v-model="modelValue.comment"
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </textarea>
                </div>
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

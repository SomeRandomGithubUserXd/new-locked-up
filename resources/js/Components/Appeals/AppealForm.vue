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

const emit = defineEmits(['submit', 'abort'])

</script>

<template>
    <form class="space-y-6" @submit.prevent="emit('submit')">
        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6">
                <h2 class="text-xl font-bold">Данные заказчика</h2>
            </div>
            <div class="col-span-6 sm:col-span-5">
                <InputLabel for="name" value="Имя"/>
                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue.name"
                />
                <InputError class="mt-2" :message="modelValue?.errors?.name"/>
            </div>
            <div class="col-span-6 sm:col-span-2">
                <InputLabel for="phone" value="Телефон"/>
                <TextInput
                    id="phone"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue.phone"
                />
                <InputError class="mt-2" :message="modelValue?.errors?.phone"/>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="email" value="E-Mail"/>
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="modelValue.email"
                />
                <InputError class="mt-2" :message="modelValue?.errors?.email"/>
            </div>
        </div>
        <div class="grid grid-cols-6 gap-6 mt-5">
            <div class="col-span-6 mt-5">
                <h2 class="text-xl font-bold">Дополнительная информация</h2>
            </div>
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
            <div class="col-span-6 sm:col-span-3">
                <label for="comment" class="block text-sm font-medium text-gray-700"> Комментарий </label>
                <div class="mt-1">
                    <textarea
                        id="comment"
                        v-model="modelValue.comment"
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </textarea>
                </div>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <label for="comment" class="block text-sm font-medium text-gray-700"> Комментарий администратора </label>
                <div class="mt-1">
                    <textarea
                        id="comment"
                        v-model="modelValue.admin_comment"
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </textarea>
                </div>
            </div>
        </div>
        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
            <button type="button"
                    @click.prevent="emit('abort')"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-red-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-red-700 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-md">
                Отменить
            </button>
            <button type="submit"
                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mr-3 sm:w-auto sm:text-md">
                Сохранить изменения
            </button>
        </div>
    </form>
</template>

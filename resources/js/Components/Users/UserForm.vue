<script setup>
import {useForm} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";

const props = defineProps({
    modelValue: {
        required: false,
        default: useForm({})
    },
    userRoles: Array,
    locations: Array
})

const emit = defineEmits(['submit'])
</script>

<template>
    <form class="space-y-6" @submit.prevent="emit('submit')">
        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="username" value="Имя пользователя"/>
                <TextInput
                    id="username"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue.username"
                    autofocus
                />
                <InputError class="mt-2" :message="modelValue.errors.username"/>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="email" value="E-Mail"/>
                <TextInput
                    id="email"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue.email"
                />
                <InputError class="mt-2" :message="modelValue.errors.email"/>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="password" value="Пароль (оставить пустым, чтобы не менять)"/>
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="modelValue.password"
                />
                <InputError class="mt-2" :message="modelValue.errors.password"/>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="password_confirmation" value="Подтвердите пароль"/>
                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="modelValue.password_confirmation"
                />
                <InputError class="mt-2" :message="modelValue.errors.password_confirmation"/>
            </div>
            <div class="col-span-6 sm:col-span-6 flex flex-col">
                <InputLabel for="role" value="Роль"/>
                <select v-model="modelValue.role"
                        id="role"
                        class="appearance-none mt-auto block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">>
                    <option :value="role.key" v-for="role in props.userRoles">
                        {{ role.name }}
                    </option>
                </select>
                <InputError class="mt-2" :message="modelValue.errors.role"/>
            </div>
            <div class="col-span-6 sm:col-span-6 flex flex-col">
                <InputLabel for="locations" value="Лоакции"/>
                <div class="mt-1">
                    <v-select class="scrollable-select" v-model="modelValue.location_ids"
                              multiple=""
                              label="name_ru"
                              :reduce="option => option.id"
                              :options="props.locations"/>
                    <InputError class="mt-2" :message="modelValue.errors.location_ids"/>
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

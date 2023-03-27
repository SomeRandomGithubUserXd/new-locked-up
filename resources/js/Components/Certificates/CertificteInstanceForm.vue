<script setup>
import {useForm} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";

const props = defineProps({
    modelValue: {
        required: false,
        default: useForm({})
    },
    statuses: Array
})

const emit = defineEmits(['submit'])
</script>

<template>
    <form class="space-y-6" @submit.prevent="emit('submit')">
        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-2">
                <InputLabel for="number" value="Номер"/>
                <TextInput
                    id="text"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue.number"
                    required
                />
                <InputError class="mt-2" :message="modelValue.errors.number"/>
            </div>
            <div class="col-span-6 sm:col-span-2">
                <InputLabel for="price" value="Номинал"/>
                <TextInput
                    id="price"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue.price"
                    required
                />
                <InputError class="mt-2" :message="modelValue.errors.price"/>
            </div>
            <div class="col-span-6 sm:col-span-2">
                <InputLabel for="status" value="Статус"/>
                <select v-model="modelValue.status"
                        id="status"
                        required
                        class="appearance-none mt-auto block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">>
                    <option :value="status.key" v-for="status in props.statuses">
                        {{ status.name }}
                    </option>
                </select>
                <InputError class="mt-2" :message="modelValue.errors.status"/>
            </div>
        </div>
        <button type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Сохранить
        </button>
    </form>
</template>

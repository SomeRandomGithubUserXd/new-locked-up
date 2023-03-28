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
})

const emit = defineEmits(['submit'])
</script>

<template>
    <form class="space-y-6" @submit.prevent="emit('submit')">
        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="h1" value="Заголовок"/>
                <TextInput
                    id="h1"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue.username"
                    autofocus
                />
                <InputError class="mt-2" :message="modelValue.errors.username"/>
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

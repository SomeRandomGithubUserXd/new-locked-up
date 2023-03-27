<script setup>
import {useForm} from "@inertiajs/vue3";
import SwitchLangGroup from "@/Components/Quest/SwitchLangGroup.vue";
import {ref} from "vue";
import Checkbox from "@/Components/Checkbox.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import {getAttribute as getAttributeInstance} from "@/Traits/LocaleTrait";

const props = defineProps({
    modelValue: {
        required: false,
        default: useForm({})
    }
})

const locale = ref('ru')

const getAttribute = (name) => {
    return getAttributeInstance(name, locale.value)
}

const emit = defineEmits(['submit'])
</script>

<template>
    <form class="space-y-6" @submit.prevent="emit('submit')">
        <switch-lang-group class="mr-3" v-model="locale" @click.stop/>
        <div>
            <label for="active">
                <checkbox id="active"
                          v-model:checked="modelValue.active"/>
                <span class="ml-2 text-sm text-gray-600">Активна</span>
            </label>
        </div>
        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-6">
                <input-label for="name" :value="`Название (${locale})`"/>
                <text-input
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue[getAttribute('name')]"
                    autofocus
                />
                <input-error class="mt-2" :message="modelValue.errors[getAttribute('name')]"/>
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

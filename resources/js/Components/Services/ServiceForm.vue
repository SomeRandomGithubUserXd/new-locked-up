<script setup>
import {useForm} from "@inertiajs/vue3";
import {getAttribute as getAttributeInstance} from "@/Traits/LocaleTrait";
import {ref} from "vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import SwitchLangGroup from "@/Components/Quest/SwitchLangGroup.vue";
import Checkbox from "@/Components/Checkbox.vue";

const props = defineProps({
    modelValue: {
        required: false,
        default: useForm({}),
    }
})

const locale = ref('ru')

const emit = defineEmits(['submit'])
const getAttribute = (name) => {
    return getAttributeInstance(name, locale.value)
}
</script>

<template>
    <form class="space-y-6" @submit.prevent="emit('submit')">
        <switch-lang-group class="mr-3" v-model="locale" @click.stop/>
        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-4">
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
            <div class="col-span-6 sm:col-span-1">
                <input-label for="price" value="Цена"/>
                <text-input
                    id="price"
                    type="number"
                    class="mt-1 block w-full"
                    v-model="modelValue.price"
                />
                <input-error class="mt-2" :message="modelValue.errors.price"/>
            </div>
            <div class="col-span-6 sm:col-span-1 flex">
                <div class="mt-auto">
                    <div>
                        <label for="is_inner">
                            <Checkbox id="is_inner"
                                      v-model:checked="modelValue.is_inner"/>
                            <span class="ml-2 text-sm text-gray-600">Внутренняя</span>
                        </label>
                    </div>
                    <div>
                        <label for="is_active">
                            <Checkbox id="is_active"
                                      v-model:checked="modelValue.is_active"/>
                            <span class="ml-2 text-sm text-gray-600">Активная</span>
                        </label>
                    </div>
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

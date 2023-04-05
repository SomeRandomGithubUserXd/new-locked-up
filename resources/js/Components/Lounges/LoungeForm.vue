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
    loungeSchedules: Array
})
console.log(props.loungeSchedules)
const emit = defineEmits(['submit'])

const locale = ref('ru')

const getAttribute = (name) => {
    return getAttributeInstance(name, locale.value)
}
</script>

<template>
    <form class="space-y-6" @submit.prevent="emit('submit')">
        <switch-lang-group class="mr-3" v-model="locale" @click.stop/>
        <div>
            <label for="active">
                <Checkbox id="active"
                          v-model:checked="modelValue.is_active"/>
                <span class="ml-2 text-sm text-gray-600">Активен</span>
            </label>
        </div>
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
                <InputLabel for="lounge_schedule" value="Расписание"/>
                <select v-model="modelValue.lounge_schedule_id"
                        id="lounge_schedule"
                        class="appearance-none mt-auto block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">>
                    <option :value="schedule.id" v-for="schedule in props.loungeSchedules">
                        {{ schedule.name }}
                    </option>
                </select>
                <InputError class="mt-2" :message="modelValue.errors.lounge_schedule_id"/>
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

<script setup>
import {useForm} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
import Checkbox from "@/Components/Checkbox.vue";
import {salesProps} from "@/Traits/SalesTrait";

const props = defineProps({
    modelValue: {
        required: false,
        default: useForm({})
    },
    ...salesProps
})

const emit = defineEmits(['submit'])
</script>

<template>
    <form class="space-y-6" @submit.prevent="emit('submit')">
        <div>
            <label for="weekdays_only">
                <checkbox id="weekdays_only"
                          v-model:checked="modelValue.weekdays_only"/>
                <span class="ml-2 text-sm text-gray-600">Только будние дни</span>
            </label>
        </div>
        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-2">
                <InputLabel for="promo_code" value="Промокод"/>
                <TextInput
                    id="promo_code"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue.promo_code"
                    autofocus
                />
                <InputError class="mt-2" :message="modelValue.errors.promo_code"/>
            </div>
            <div class="col-span-6 sm:col-span-2 flex flex-col">
                <InputLabel for="type" value="Тип"/>
                <select v-model="modelValue.type"
                        id="type"
                        class="appearance-none mt-auto block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">>
                    <option :value="type.key" v-for="type in props.certificateTypes">
                        {{ type.name }}
                    </option>
                </select>
                <InputError class="mt-2" :message="modelValue.errors.type"/>
            </div>
            <div class="col-span-6 sm:col-span-2">
                <InputLabel for="value" value="Значение"/>
                <TextInput
                    id="value"
                    type="number"
                    class="mt-1 block w-full"
                    v-model="modelValue.value"
                />
                <InputError class="mt-2" :message="modelValue.errors.value"/>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="start_date" value="Действует с:"/>
                <TextInput
                    id="start_date"
                    type="date"
                    class="mt-1 block w-full"
                    v-model="modelValue.start_date"
                />
                <InputError class="mt-2" :message="modelValue.errors.start_date"/>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="best_before" value="Действует до:"/>
                <TextInput
                    id="best_before"
                    type="date"
                    class="mt-1 block w-full"
                    v-model="modelValue.best_before"
                />
                <InputError class="mt-2" :message="modelValue.errors.best_before"/>
            </div>
            <div class="col-span-6 sm:col-span-6">
                <InputLabel for="quests" value="Квесты"/>
                <div class="mt-1">
                    <v-select class="scrollable-select" v-model="modelValue.quest_ids"
                              multiple=""
                              label="name_ru"
                              :reduce="option => option.id"
                              :options="props.questList"/>
                    <InputError class="mt-2" :message="modelValue.errors.quest_ids"/>
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

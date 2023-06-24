<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
import {orderProps} from "@/Traits/OrderTrait";
import Checkbox from "@/Components/Checkbox.vue";
import {useForm} from "@inertiajs/vue3";
import {watch} from "vue";

const props = defineProps({
    modelValue: {
        type: Object,
        default: useForm({})
    },
    disabled: {
        required: false,
        type: Boolean,
        default: false,
    },
    isProduction: {
        required: false,
        type: Boolean,
        default: true,
    },
    isLimited: {
        required: false,
        type: Boolean,
        default: false,
    },
    needsExcel: {
        required: false,
        type: Boolean,
        default: true,
    },
    filtersPrepared: {
        required: false,
        type: Array,
        default: [],
    },
    ...orderProps
})

watch(() => props.modelValue.quest_ids, value => {
    for (const item of props.modelValue.quest_ids) {
        if(typeof item === 'object') {
            for (const id of item) {
                props.modelValue.quest_ids.push(id)
            }
            props.modelValue.quest_ids.splice(props.modelValue.quest_ids.indexOf(item), 1)
        }
    }
})

const emit = defineEmits(['submit', 'toExcel', 'reset'])
</script>

<template>
    <form class="space-y-6 mb-5" @submit.prevent="emit('submit')">
        <div class="grid grid-cols-6 gap-6">
            <div v-if="!isProduction" class="col-span-6 sm:col-span-1">
                <InputLabel for="name" value="Название"/>
                <TextInput
                    :disabled="props.disabled"
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue.name"

                />
                <InputError class="mt-2" :message="modelValue.errors.name"/>
            </div>
            <!--            <div v-if="!isLimited" class="col-span-6 sm:col-span-1">-->
            <!--                <InputLabel for="order_id" value="Номер заказа"/>-->
            <!--                <TextInput-->
            <!--                    :disabled="props.disabled"-->
            <!--                    id="order_id"-->
            <!--                    type="text"-->
            <!--                    class="mt-1 block w-full"-->
            <!--                    v-model="modelValue.order_id"-->

            <!--                />-->
            <!--                <InputError class="mt-2" :message="modelValue.errors.order_id"/>-->
            <!--            </div>-->
            <div v-if="!isLimited" class="col-span-6 sm:col-span-1">
                <label for="quest" class="block text-sm font-medium text-gray-700">
                    Сортировка </label>
                <div class="mt-1">
                    <select
                        :disabled="props.disabled"
                        id="quest"
                        v-model="modelValue.order_by"
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">
                            По умолчанию
                        </option>
                        <option value="time_asc">
                            По времени игры &#8593;
                        </option>
                        <option value="time_desc">
                            По времени игры &#8595;
                        </option>
                    </select>
                </div>
            </div>
            <div v-if="!isLimited" class="col-span-6 sm:col-span-2 flex items-end">
                <label class="flex items-center">
                    <Checkbox :disabled="props.disabled" name="with_options_only"
                              v-model:checked="modelValue.with_options_only"/>
                    <span class="ml-2 text-sm text-gray-600">Только с доп. услугами</span>
                </label>
            </div>
        </div>
        <div v-if="!isLimited" class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-3">

                <InputLabel for="date_from" value="Дата (от)"/>

                <a class="text-indigo-600 text-sm" href="#"
                   @click.prevent="modelValue.date_from = null">Очистить</a>
                <TextInput
                    :disabled="props.disabled"
                    id="date_from"
                    type="date"
                    class="mt-1 block w-full"
                    v-model="modelValue.date_from"

                />
                <InputError class="mt-2" :message="modelValue.errors.date_from"/>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="date" value="Дата (до)"/>
                <a class="text-indigo-600 text-sm" href="#"
                   @click.prevent="modelValue.date_to = null">Очистить</a>
                <TextInput
                    :disabled="props.disabled"
                    id="date_to"
                    type="date"
                    class="mt-1 block w-full"
                    v-model="modelValue.date_to"

                />
                <InputError class="mt-2" :message="modelValue.errors.date_to"/>
            </div>
        </div>
        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-2">
                <label for="quest_ids" class="block text-sm font-medium text-gray-700">
                    Квесты </label>
                <div class="mt-1">
                    <v-select :disabled="props.disabled"
                              class="scrollable-select"
                              v-model="modelValue.quest_ids"
                              multiple=""
                              label="name_ru"
                              :reduce="option => option?.id || option.quest_ids"
                              :options="[...props.questList, ...filtersPrepared]"/>
                </div>
            </div>
            <div v-if="!isLimited" class="col-span-6 sm:col-span-2">
                <label for="source_ids" class="block text-sm font-medium text-gray-700">
                    Источники </label>
                <div class="mt-1">
                    <v-select :disabled="props.disabled" class="scrollable-select" v-model="modelValue.source_ids"
                              multiple=""
                              label="name"
                              :reduce="option => option.id"
                              :options="props.sourceList"/>
                </div>
            </div>
            <div v-if="!isLimited" class="col-span-6 sm:col-span-1">
                <label for="quest" class="block text-sm font-medium text-gray-700">
                    Акции </label>
                <div class="mt-1">
                    <v-select :disabled="props.disabled" class="scrollable-select" v-model="modelValue.promo_code_ids"
                              multiple=""
                              label="promocode"
                              :reduce="option => option.id"
                              :options="props.promoCodeList"/>
                </div>
            </div>
            <div v-if="!isLimited" class="col-span-6 sm:col-span-1">
                <label for="status" class="block text-sm font-medium text-gray-700">
                    Статусы </label>
                <div class="mt-1">
                    <v-select :disabled="props.disabled" class="scrollable-select" v-model="modelValue.statuses"
                              multiple=""
                              label="name"
                              :reduce="option => option.key"
                              :options="props.orderStatuses"/>
                </div>
            </div>
        </div>
        <div v-if="isProduction" class="grid grid-cols-6 mt-5 gap-6">
            <div class="col-span-6 sm:col-span-4">
                <button type="submit"
                        class="flex w-full justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Искать
                </button>
            </div>
            <div v-if="props.needsExcel" class="col-span-6 sm:col-span-1">
                <button type="button"
                        @click="emit('toExcel')"
                        class="flex w-full justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Выгрузить в Excel
                </button>
            </div>
            <div class="col-span-6" :class="props.needsExcel ? 'sm:col-span-1' : 'sm:col-span-2'">
                <button type="button"
                        @click="emit('reset')"
                        class="flex w-full justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Сбросить
                </button>
            </div>
        </div>
        <div v-else class="grid grid-cols-6 mt-5 gap-6">
            <div class="col-span-6 sm:col-span-6">
                <button type="submit"
                        class="flex w-full justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Сохранить
                </button>
            </div>
        </div>
    </form>
</template>

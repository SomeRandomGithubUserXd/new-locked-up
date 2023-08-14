<script setup>
import {XMarkIcon} from "@heroicons/vue/20/solid";
import {computed} from "vue";
import {collect} from "collect.js";

const props = defineProps({
    instance: Object,
    loungeList: Array
})

const emit = defineEmits(['remove'])

const loungeName = computed({
    get() {
        return collect(props.loungeList).where('id', '==', props.instance.pivot.lounge_id).first().name_ru
    }, set() {

    }
})
</script>

<template>
    <div class="grid grid-cols-5 gap-x-6 gap-y-3 col-span-10">
        <div class="col-span-10 sm:col-span-3">
            <label for="lounge_option" class="block text-sm font-medium text-gray-700">Лаунж</label>
            <div class="mt-1">
                <select
                    id="lounge_option"
                    disabled
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option selected>
                        {{ loungeName }}
                    </option>
                </select>
            </div>
        </div>
        <div class="col-span-10 sm:col-span-2">
            <label for="lounge_option_time" class="block text-sm font-medium text-gray-700">Время</label>
            <div class="mt-1 flex items-center">
                <select
                    id="lounge_option_time"
                    disabled
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option selected :value="instance.time">
                        {{ instance.time }}
                    </option>
                </select>
                <x-mark-icon class="w-7 h-7 ml-2 text-red-500 cursor-pointer" @click.prevent="emit('remove', props.instance)"/>
            </div>
        </div>
    </div>
</template>

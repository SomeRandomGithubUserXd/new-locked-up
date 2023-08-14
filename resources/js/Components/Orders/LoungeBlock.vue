<script setup>
import {XMarkIcon} from "@heroicons/vue/20/solid";

const props = defineProps({
    instance: Object
})

const emit = defineEmits(['remove'])
</script>

<template>
    <div class="grid grid-cols-4 gap-x-6 gap-y-3">
        <div class="col-span-10 sm:col-span-1">
            <label for="lounge_option_time" class="block text-sm font-medium text-gray-700">Время</label>
            <div class="mt-1">
                <select
                    id="lounge_option_time"
                    disabled
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option selected :value="instance.time">
                        {{instance.time}}
                    </option>
                </select>
            </div>
        </div>
        <div class="col-span-10 sm:col-span-3">
            <label for="lounge_option" class="block text-sm font-medium text-gray-700">Лаунж</label>
            <div class="mt-1 flex items-center">
                <select
                    id="lounge_option"
                    disabled
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option selected :value="props.instance.pivot.lounge">
                        {{props.instance.pivot.lounge.name_ru}}
                    </option>
                </select>
                <x-mark-icon class="w-7 h-7 ml-2 text-red-500 cursor-pointer" @click.prevent="emit('remove')"/>
            </div>
        </div>
    </div>
</template>

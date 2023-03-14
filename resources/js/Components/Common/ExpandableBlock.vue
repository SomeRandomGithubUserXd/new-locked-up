<script setup>
import SlideUpDown from 'vue3-slide-up-down'
import {ChevronDownIcon, ChevronUpIcon} from "@heroicons/vue/24/outline";

const props = defineProps({
    modelValue: Boolean,
    duration: {
        required: false,
        default: 300,
        type: Number
    }
})

const emit = defineEmits(['update:modelValue'])
</script>

<template>
    <div class="shadow-xl rounded-md relative">
        <div @click="emit('update:modelValue', !modelValue)"
             class="w-full cursor-pointer select-none transition-all flex items-center bg-gray-50 p-3"
             :class="{'rounded-md-t border-b': !!modelValue, 'rounded-md': !modelValue}">
            <slot name="header"/>
            <component :is="modelValue ? ChevronUpIcon : ChevronDownIcon" class="ml-auto w-5 h-5"/>
        </div>
        <slide-up-down :model-value="modelValue" :duration="300">
            <div class="w-full flex items-center p-3 rounded-md-b">
                <slot name="content"/>
            </div>
        </slide-up-down>
    </div>
</template>

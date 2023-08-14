<script setup>
import {XMarkIcon} from "@heroicons/vue/20/solid";

const props = defineProps({
    instance: Object
})

const emit = defineEmits(['remove'])
</script>

<template>
    <div class="additional-option">
        {{ props.instance.name_ru }}
        <x-mark-icon @click.prevent="emit('remove', props.instance)" class="w-5 h-5 ml-3 cursor-pointer"/>
    </div>
</template>

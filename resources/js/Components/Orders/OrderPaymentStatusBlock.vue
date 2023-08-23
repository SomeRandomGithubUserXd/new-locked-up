<script setup>
import {computed} from "vue";

const props = defineProps({
    orderStatuses: Array,
    modelValue: Number
})

const statusObject = computed({
    get() {
        return props.orderStatuses[props.modelValue]
    }, set() {
    }
})
</script>

<template>
    <div
        :style="{color: statusObject.color, backgroundColor: statusObject.backgroundColor}"
        style="border-radius: 24px"
        class="py-2 px-3 flex justify-center font-bold">
        {{ statusObject.name }}
    </div>
</template>

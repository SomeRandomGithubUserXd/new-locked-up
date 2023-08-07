<script setup>
import {ref} from "vue";

const props = defineProps({
    meta: Object
})

const statusSelected = props.meta.item.status
</script>

<template>
    <div class="w-full h-full">
        <p class="font-bold">
            №{{props.meta.item.id}}
        </p>
        <select v-model="statusSelected" class="mt-3 custom-select font-bold bg-transparent border-b border-0 focus:ring-0" style="border-radius: 0 !important;">
            <option :value="status.key" v-for="status in props.meta.orderStatuses">
                {{ status.name }}
            </option>
        </select>
    </div>
</template>

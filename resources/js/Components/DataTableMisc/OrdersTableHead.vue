<script setup>
import {ref, watch} from "vue";
import {router} from "@inertiajs/vue3";

const props = defineProps({
    meta: Object
})

const statusSelected = ref(props.meta.item.status)

watch(statusSelected, value => {
    console.log(value)
    router.post(route('orders.change-status', props.meta.item.id), {
        status: value
    }, {
        preserveScroll: true
    })
})
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

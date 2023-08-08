<script setup>
import {computed, ref, watch} from "vue";
import {router} from "@inertiajs/vue3";

const props = defineProps({
    meta: Object
})

const data = computed({
    get() {
        let paid_cash = 0
        let paid_card = 0
        if (props.meta.item.postpaid) {
            if (props.meta.item.postpaid_type === 0) paid_cash += props.meta.item.postpaid
            else paid_card += props.meta.item.postpaid
        }
        if (props.meta.item.pre_paid) {
            if (props.meta.item.pre_paid_type === 0) paid_cash += props.meta.item.pre_paid
            else paid_card += props.meta.item.pre_paid
        }
        paid_card += props.meta.item.paid_through_acquiring || 0
        paid_card += props.meta.item.paid_through_aggregator || 0
        return {
            paid_cash,
            paid_card
        }
    },
    set() {

    }
})
</script>

<template>
    <div class="w-full h-full">
        <div v-if="data.paid_cash" class="paid-tag paid-cash mb-1">
            <span class="font-bold">{{data.paid_cash}}</span>&nbsp;Н
        </div>
        <div v-if="data.paid_card" class="paid-tag paid-card">
            <span class="font-bold">{{data.paid_card}}</span>&nbsp;БН
        </div>
    </div>
</template>

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
        for (const payment of props.meta.item.order_payments) {
            if(payment.payment_option === 0) paid_cash += Number(payment.sum)
            if(payment.payment_option === 1) paid_card += Number(payment.sum)
        }
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
            <span class="font-bold">{{ data.paid_cash }}</span>&nbsp;Н
        </div>
        <div v-if="data.paid_card" class="paid-tag paid-card">
            <span class="font-bold">{{ data.paid_card }}</span>&nbsp;БН
        </div>
    </div>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import OrderForm from "@/Components/Orders/OrderForm.vue";
import {Head, router, useForm} from "@inertiajs/vue3";
import {orderProps} from "@/Traits/OrderTrait";

const order = useForm({
    quest_id: null,
    date: null,
    time: null,
    customer_name: null,
    customer_email: null,
    customer_phone: null,
    source: null,
    option: null,
    promo_code: null,
    certificate: null,
    comment: null,
    players_count: 0,
    options: [],
    fact_payment: 0,
    pre_payed: 0,
    online_payment: 0,
    payed_aggregator: 0,
    fact_payment_type: '',
    pre_payed_type: '',
    status: 0,
});

const props = defineProps(orderProps)

const createOrder = (price_total) => {
    order.transform((data) => ({
        ...data,
        promo_code_id: data.promo_code?.id,
        certificate_id: data.certificate?.id,
        price_total
    })).post(route('orders.store'), {
        onError: (err) => console.log(err)
    })
}
</script>

<template>
    <Head title="Создать заказ"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Создать заказ</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <order-form
                            v-model="order"
                            :quest-list="props.questList"
                            :option-list="props.optionList"
                            :source-list="props.sourceList"
                            :promo-code-list="props.promoCodeList"
                            :certificate-list="props.certificateList"
                            :order-statuses="props.orderStatuses"
                            :quest-options="props.questOptions"
                            @submit="createOrder"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

]<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import OrderForm from "@/Components/Orders/OrderForm.vue";
import {Head, router, useForm} from "@inertiajs/vue3";
import {orderProps} from "@/Traits/OrderTrait";
import {getCurrentUrlParam} from "@/Traits/Tools";

const order = useForm({
    quest_id: getCurrentUrlParam('quest_id'),
    date: getCurrentUrlParam('date'),
    time: getCurrentUrlParam('time'),
    customer_name: null,
    customer_email: null,
    customer_phone: null,
    order_source_id: null,
    option: null,
    promo_code: null,
    certificate_id: null,
    comment: null,
    players_count: 0,
    options: [],
    postpaid: 0,
    pre_paid: 0,
    paid_through_acquiring: 0,
    paid_through_aggregator: 0,
    postpaid_type: '',
    pre_paid_type: '',
    status: 0,
    additional_players_count: 0,
    lounge_id: null,
    lounge_schedule_item_id: null,
});

const props = defineProps(orderProps)

const createOrder = (price, additional_players_cost, additional_options_cost, price_total, price_to_pay, paid_total) => {
    order.transform((data) => ({
        ...data,
        promo_code_id: data.promo_code?.id,
        certificate_id: data.certificate?.id,
        price,
        additional_players_cost,
        additional_options_cost,
        price_total,
        price_to_pay,
        paid_total,
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
            <div class="max-w-7xl max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
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
                            :lounge-list="props.loungeList"
                            @submit="createOrder"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

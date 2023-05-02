<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import OrderForm from "@/Components/Orders/OrderForm.vue";
import {Head, router, useForm} from "@inertiajs/vue3";
import {orderProps} from "@/Traits/OrderTrait";
import {ref} from "vue";

const props = defineProps({
    order: Object,
    ...orderProps
})

const orderToUpdate = useForm(props.order)

const updateOrder = (price_total) => {
    orderToUpdate.transform((data) => ({
        ...data,
        promo_code_id: data.promo_code?.id,
        certificate_id: data.certificate?.id,
        price_total
    })).patch(route('orders.update', props.order.id), {
        onError: (err) => console.log(err)
    })
}
</script>

<template>
    <Head title="Редактировать заказ"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Редактировать заказ</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <order-form
                            v-model="orderToUpdate"
                            :is-editable="true"
                            :quest-list="props.questList"
                            :option-list="props.optionList"
                            :source-list="props.sourceList"
                            :promo-code-list="props.promoCodeList"
                            :certificate-list="props.certificateList"
                            :order-statuses="props.orderStatuses"
                            :quest-options="props.questOptions"
                            :lounge-list="props.loungeList"
                            @submit="updateOrder"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

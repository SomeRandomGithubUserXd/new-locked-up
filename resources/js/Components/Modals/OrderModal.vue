<script setup>
import {DialogOverlay, DialogTitle, TransitionChild, TransitionRoot, Dialog} from "@headlessui/vue";
import OrderForm from "@/Components/Orders/OrderForm.vue";
import {orderProps} from "@/Traits/OrderTrait";
import {watch} from "vue";
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    modelValue: Object,
    ...orderProps

})

const emit = defineEmits(['update:modelValue', 'refreshOrder'])

const closeSelf = () => {
    emit('update:modelValue', {...props.modelValue, show: false})
}

const handleSubmit = (price, additional_players_cost, additional_options_cost, price_total, price_to_pay, paid_total) => {
    const order = useForm(props.modelValue.order)
    if(props.modelValue.mode === 0) {
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
            onError: (err) => console.log(err),
            onSuccess: closeSelf
        })
    } else {
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
        })).patch(route('orders.update', order.id), {
            onError: (err) => console.log(err),
            onSuccess: closeSelf
        })
    }
}

watch(() => props.modelValue, value => {
    // console.log(value)
}, {
    deep: true
})
</script>

<template>
    <TransitionRoot as="template" :show="props.modelValue.show">
        <Dialog as="div" class="fixed z-40 inset-0 overflow-y-auto"
                @close="closeSelf">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0"
                                 enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100"
                                 leave-to="opacity-0">
                    <DialogOverlay class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"/>
                </TransitionChild>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <TransitionChild as="template" enter="ease-out duration-300"
                                 enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                 enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                                 leave-from="opacity-100 translate-y-0 sm:scale-100"
                                 leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div
                        class="inline-block align-bottom bg-white rounded-2xl px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-screen-2xl sm:w-full sm:py-6 sm:px-3">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 px-4 sm:text-left w-full">
                                <DialogTitle as="h2" class="text-2xl font-bold leading-6 text-black">
                                    {{ props.modelValue.mode ? 'Редактирование' : 'Создание' }} заказа
                                    <span class="text-sm text-gray-500 font-medium ml-5">
                                        Дата заказа: {{ props.modelValue.order?.date || 'Нет' }} {{ props.modelValue.order?.time?.time }}
                                    </span>
                                </DialogTitle>
                                <order-form
                                    class="mt-7 w-full"
                                    @refresh-order="emit('refreshOrder', $event)"
                                    :order-payment-statuses="props.orderPaymentStatuses"
                                    :quest-list="props.questList"
                                    :option-list="props.optionList"
                                    :source-list="props.sourceList"
                                    :promo-code-list="props.promoCodeList"
                                    :certificate-list="props.certificateList"
                                    :order-statuses="props.orderStatuses"
                                    :order-payment-types="props.orderPaymentTypes"
                                    :quest-options="props.questOptions"
                                    :lounge-list="props.loungeList"
                                    :model-value="props.modelValue.order"
                                    @abort="closeSelf"
                                    @submit="handleSubmit"
                                />
                            </div>
                        </div>
                    </div>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

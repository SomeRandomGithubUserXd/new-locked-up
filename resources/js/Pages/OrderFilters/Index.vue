<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {onMounted, ref} from "vue";
import {getAlreadypaid, getOrderPriceToPay, orderProps} from "@/Traits/OrderTrait";
import DataTable from "@/Components/Common/DataTable.vue";
import {Head, router, Link, useForm} from '@inertiajs/vue3';
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import {getCurrentUrlParam} from "@/Traits/Tools";
import {PencilIcon} from "@heroicons/vue/24/solid";
import {PlusIcon} from "@heroicons/vue/20/solid";
import OrderFilterModal from "@/Components/Modals/OrderFilterModal.vue";

const props = defineProps({
    filters: Object,
    ...orderProps
})

const tableProps = ref({
    records: [
        {
            name: 'Название',
            getValue: (filterInstance) => {
                return filterInstance.name
            },
            getRowStyle: (item) => {
                return 'white-space: normal !important;width: 65%;white-space: normal !important;'
            },
        },
        {
            name: 'Создан',
            getValue: (appeal) => appeal.created_at
        },
        {
            name: 'Обновлен',
            getValue: (appeal) => appeal.updated_at
        },
    ],
    actions: [
        {
            name: 'Редактировать',
            trigger: (filter) => showOrderFilterModal(filter),
            icon: PencilIcon,
        }
    ],
    pagination: {
        isRequired: true,
    }
})

const orderFilterModal = ref({
    show: false,
    filter: {},
    mode: 0,
})

const showOrderFilterModal = (filter = {
    name: '',
    date_from: '',
    date_to: '',
    quest_ids: [],
    order_id: '',
    source_ids: [],
    statuses: [],
    promo_code_ids: [],
    with_options_only: false,
    order_by: ''
}) => {
    orderFilterModal.value.filter = filter
    orderFilterModal.value.show = true
    orderFilterModal.value.mode = filter?.id ? 1 : 0
}
</script>

<template>
    <Head title="Таблица фильтров заказов"/>
    <order-filter-modal
        :quest-list="props.questList"
        :option-list="props.optionList"
        :source-list="props.sourceList"
        :promo-code-list="props.promoCodeList"
        :certificate-list="props.certificateList"
        :order-statuses="props.orderStatuses"
        :order-payment-types="props.orderPaymentTypes"
        :order-payment-statuses="props.orderPaymentStatuses"
        :quest-options="props.questOptions"
        :lounge-list="props.loungeList"
        v-model="orderFilterModal"/>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex w-full items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Таблица фильтров заказов</h2>
                <div class="ml-auto gap-x-10 flex">
                    <button
                        type="button"
                        @click="showOrderFilterModal()"
                        class="relative inline-flex items-center px-5 py-2 border border-indigo-600 text-sm font-medium rounded-md focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <PlusIcon class="h-5 w-5 mr-2 text-indigo-600 font-bold" aria-hidden="true"/>
                        <span class="text-indigo-600 font-bold">Создать фильтр</span>
                    </button>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <data-table :delete-many-route="route('order-filters.destroy-many')" :table-props="tableProps"
                                    :items-resource="filters"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

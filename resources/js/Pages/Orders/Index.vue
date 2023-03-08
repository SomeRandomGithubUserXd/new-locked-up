<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router, Link, useForm} from '@inertiajs/vue3';
import DataTable from "@/Components/Common/DataTable.vue";
import {onMounted, reactive, ref, watch} from "vue";
import {getAlreadyPayed, getOrderPriceToPay, orderProps} from "@/Traits/OrderTrait";
import {getCurrentUrlParam} from "@/Traits/Tools";
import exportFromJSON from "export-from-json";
import OrderFilter from "@/Components/Orders/OrderFilter.vue";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
import {collect} from "collect.js";

const usingFilter = ref(null);

const props = defineProps({
    orders: Object,
    filters: Array,
    ...orderProps
})

const getOrderStatus = (status) => {
    status = props.orderStatuses[status]
    return `<span style="color: ${status.color}">${status.name}</span>`
}

const edit = (order) => {
    router.get(route('orders.show', order))
}

const deleteMany = (ids) => {
    if (confirm('Вы уверены?')) {
        router.post(route('orders.destroy-many'), {
            ids
        })
    }
}

const tableProps = ref({
    records: [
        {
            name: 'Заказ',
            getValue: (order) => {
                return `№${order.id} <br/> ${getOrderStatus(order.status)} <br/> ${order.created_at}`
            },
        },
        {
            name: 'Квест',
            getValue: (order) => order.quest
        },
        {
            name: 'Время игры',
            getValue: (order) => order.date
        },
        {
            name: 'Заказчик',
            getValue: (order) => {
                if (!order.customer_name || !order.customer_email || !order.customer_phone) return ''
                return `${order.customer_name} <br/> ${order.customer_email} <br/> ${order.customer_phone}`
            }
        },
        {
            name: 'Стоимость',
            getValue: (order) => `${order.price_total} руб.`
        },
        {
            name: 'Оплачено',
            getValue: (order) => {
                return `${getAlreadyPayed(order)} руб.`
            }
        },
        {
            name: 'Осталось оплатить',
            getValue: (order) => {
                return `${getOrderPriceToPay(order.price_total, order)} руб.`
            }
        },
        {
            name: 'Источник',
            getValue: (order) => order.sources?.name
        },
        {
            name: 'Комментарий',
            rowStyle: 'white-space: normal !important',
            getValue: (order) => order?.comment
        },
    ],
    actions: [
        {
            name: 'Редактировать',
            trigger: edit
        }
    ],
    pagination: {
        isRequired: true,
    }
})

const defaultFilter = {
    date_from: null,
    date_to: null,
    quest_ids: [],
    order_id: null,
    source_ids: [],
    statuses: [],
    promo_code_ids: [],
    order_by: null,
    with_options_only: false,
}

const filter = useForm(defaultFilter)

onMounted(() => {
    for (const key in defaultFilter) {
        switch (key) {
            case 'quest_ids':
                filter[key] = getCurrentUrlParam('quest_ids[]', true, Number)
                break;
            case 'source_ids':
                filter[key] = getCurrentUrlParam('source_ids[]', true, Number)
                break;
            case 'promo_code_ids':
                filter[key] = getCurrentUrlParam('promo_code_ids[]', true, Number)
                break;
            case 'statuses':
                filter[key] = getCurrentUrlParam('statuses[]', true, Number)
                break;
            case 'with_options_only':
                filter[key] = getCurrentUrlParam(key) === 'true'
                break;
            default:
                filter[key] = getCurrentUrlParam(key)
                break;
        }
    }
    usingFilter.value = getCurrentUrlParam('filter_id')
})

const search = () => {
    if(usingFilter.value)
    {
        router.get(route('orders.index', {
            filter_id: usingFilter.value,
            ...collect(props.filters).where('id', '==', usingFilter.value).first()
        }))
    } else {
        filter.get(route('orders.index'))
    }
}

const reset = () => {
    filter.reset().get(route('orders.index'))
}

const toExcel = () => {
    const data = props.orders.data.map(order => ({
        ...order,
        sources: order?.sources?.name
    }))
    const fileName = 'orders'
    const exportType = exportFromJSON.types.xls
    exportFromJSON({data, fileName, exportType})
}
</script>

<template>
    <Head title="Таблица заказов"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Таблица заказов</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="font-semibold text-2xl">Фильтр</h2>
                        <div class="grid grid-cols-6 gap-6 my-5">
                            <div class="col-span-6 sm:col-span-2">
                                <label for="quest_ids" class="block text-sm font-medium text-gray-700">
                                    Фильтры
                                </label>
                                <div class="mt-1">
                                    <select
                                        id="quest"
                                        v-model="usingFilter"
                                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option :value="filter.id" v-for="filter in props.filters">
                                            {{ filter.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr class="mb-5"/>
                        <order-filter
                            :disabled="!!usingFilter"
                            :quest-list="props.questList"
                            :option-list="props.optionList"
                            :source-list="props.sourceList"
                            :promo-code-list="props.promoCodeList"
                            :certificate-list="props.certificateList"
                            :order-statuses="props.orderStatuses"
                            :quest-options="props.questOptions"
                            v-model="filter" @submit="search" @to-excel="toExcel" @reset="reset"/>
                        <data-table :create-link="route('orders.create')" @delete-many="deleteMany"
                                    :table-props="tableProps" :items-resource="orders"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style lang="scss">
.scrollable-select {

    .vs__dropdown-toggle {
        height: 50px !important;
    }

    .vs__selected-options {
        flex-wrap: nowrap !important;
        overflow-x: auto;

        .vs__selected {
            white-space: nowrap;
        }
    }
}
</style>

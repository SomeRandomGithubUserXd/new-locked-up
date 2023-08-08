<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router, Link, useForm} from '@inertiajs/vue3';
import DataTable from "@/Components/Common/DataTable.vue";
import {computed, onMounted, reactive, ref, watch} from "vue";
import {getAlreadypaid, getOrderPriceToPay, orderProps} from "@/Traits/OrderTrait";
import {getCurrentUrlParam, numberFormat} from "@/Traits/Tools";
import exportFromJSON from "export-from-json";
import OrderFilter from "@/Components/Orders/OrderFilter.vue";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
import {collect} from "collect.js";
import ExpandableBlock from "@/Components/Common/ExpandableBlock.vue";
import {TrashIcon, PencilIcon, ClockIcon, PlusIcon} from "@heroicons/vue/24/solid";
import CertificateSelect from "@/Components/Orders/CertificateSelect.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import OrdersTableHead from "@/Components/DataTableMisc/OrdersTableHead.vue";
import OrdersTableOptionList from "@/Components/DataTableMisc/OrdersTableOptionList.vue";
import OrdersTablePaymentDetails from "@/Components/DataTableMisc/OrdersTablePaymentDetails.vue";

const usingFilter = ref(null);

const props = defineProps({
    orders: Object,
    filters: Array,
    options: Object,
    ordersMeta: Object,
    ...orderProps
})

const getOrderStatus = (status) => {
    return props.orderStatuses[status]
}

const edit = (order) => {
    router.get(route('orders.show', order))
}

const viewLog = (order) => {
    router.get(route('orders.view-logs', order))
}

const payments = (order) => {
    router.get(route('orders.payments.index', order))
}

const tableProps = ref({
    records: [
        {
            name: 'Заказ',
            getRowStyle: (item) => {
                return 'white-space: normal !important;' + `background-color:${getOrderStatus(item.status).backgroundColor};color: ${getOrderStatus(item.status).color}`
            },
            getValue: (item) => ({
                component: OrdersTableHead,
                meta: {
                    item,
                    orderStatuses: props.orderStatuses
                }
            }),
        },

        {
            name: 'Дата заказа',
            getValue: (order) => {
                return order.created_at
            },
            getRowStyle: (item) => {
                return 'max-width: 150px;text-overflow: ellipsis;overflow: hidden'
            },
        },

        {
            name: 'Квест',
            getValue: (order) => order.quest,
            getRowStyle: (item) => {
                return 'max-width: 100px;white-space: normal !important;'
            },
        },

        {
            name: 'Доп. услуги',
            getValue: (item) => ({
                component: OrdersTableOptionList,
                meta: {
                    item,
                }
            }),
            getRowStyle: (item) => {
                return 'max-width: 100px;white-space: normal !important;'
            },
        },
        {
            name: 'Заказчик',
            getValue: (order) => {
                return `${order?.customer_name} <br/> ${order?.customer_email} <br/> ${order?.customer_phone}`
            },
            getRowStyle: (item) => {
                return 'max-width: 150px;text-overflow: ellipsis;overflow: hidden'
            },
        },
        // {
        //     name: 'Промокод <br/> сертификат',
        //     getValue: (item) => ({
        //         component: CertificateSelect,
        //         meta: {
        //             certificateList: props.certificateList,
        //             item
        //         }
        //     }),
        // },
        {
            name: 'Время игры',
            getValue: (order) => order.date
        },
        {
            name: 'Стоимость',
            getValue: (order) => `${order.price_total} руб.`
        },
        {
            name: 'Оплачено',
            getValue: (item) => ({
                component: OrdersTablePaymentDetails,
                meta: {
                    item,
                }
            }),
        },
        {
            name: 'К оплате',
            getValue: (order) => {
                return `${order.price_to_pay} руб.`
            }
        },
        // {
        //     name: 'Источник',
        //     getValue: (order) => order.source
        // },
        {
            name: 'Комментарий',
            getRowStyle: (item) => {
                return 'white-space: normal !important;max-width: 150px;white-space: normal !important;'
            },
            getValue: (order) => order?.comment
        },
    ],
    actions: [
        //     {
        //         name: 'Оплата',
        //         trigger: payments
        //     },
        {
            name: 'Редактировать',
            icon: PencilIcon,
            trigger: edit
        },
        {
            name: 'Посмотреть лог',
            icon: ClockIcon,
            trigger: viewLog
        },
    ],
    pagination: {
        isRequired: true,
    }
})

const defaultFilter = {
    search_string: null,
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

const sumOptions = (options) => {
    const sums = {
        price: 0,
        orders_count: 0,
    }
    for (const option of options) {
        sums.price += Number(option.price) * Number(option.orders_count)
        sums.orders_count += Number(option.orders_count)
    }
    return sums
}

onMounted(() => {
    for (const key in defaultFilter) {
        switch (key) {
            case 'quest_ids':
                filter[key] = getCurrentUrlParam('quest_ids[]', true, Number)
                console.log(getCurrentUrlParam('quest_ids[]', true, Number))
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
    if (usingFilter.value) {
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
        sources: order?.source?.name
    }))
    const fileName = 'orders'
    const exportType = exportFromJSON.types.xls
    exportFromJSON({data, fileName, exportType})
}

const showSums = ref(true)

const filtersPrepared = computed({
    get() {
        if (!props.filters.length) return []
        return props.filters.map(filter => {
            return {
                quest_ids: filter.quest_ids,
                name_ru: filter.name,
                is_filter: true,
            }
        })
    },
    set() {

    }
})
</script>

<template>
    <Head title="Таблица заказов"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex w-full">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Таблица заказов</h2>
                <div class="ml-auto gap-x-10 flex">
                    <button
                        type="button"
                        class="relative inline-flex items-center px-5 py-2 border border-indigo-600 text-sm font-medium rounded-md focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <PlusIcon class="h-5 w-5 mr-2 text-indigo-600 font-bold" aria-hidden="true"/>
                        <span class="text-indigo-600 font-bold">Создать заказ</span>
                    </button>
                    <button
                        type="button"
                        @click.prevent="toExcel"
                        class="relative inline-flex items-center px-5 py-2 border border-green-600 text-sm font-medium rounded-md focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <span class="text-green-600 font-bold">Выгрузка в Excel</span>
                    </button>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm rounded-3xl">
                    <div class="p-6">
                        <h2 class="font-semibold text-2xl">Фильтр</h2>
                        <!--                        <div class="grid grid-cols-6 gap-6 my-5">-->
                        <!--                            <div class="col-span-6 sm:col-span-2">-->
                        <!--                                <label for="quest_ids" class="block text-sm font-medium text-gray-700">-->
                        <!--                                    Фильтр-->
                        <!--                                </label>-->
                        <!--                                <div class="mt-1">-->
                        <!--                                    <select-->
                        <!--                                        id="quest"-->
                        <!--                                        v-model="usingFilter"-->
                        <!--                                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">-->
                        <!--                                        <option :value="filter.id" v-for="filter in props.filters">-->
                        <!--                                            {{ filter.name }}-->
                        <!--                                        </option>-->
                        <!--                                    </select>-->
                        <!--                                </div>-->
                        <!--                            </div>-->
                        <!--                        </div>-->
                        <!--                        <hr class="mb-5"/>-->
                        <order-filter
                            class="mt-5"
                            :disabled="!!usingFilter"
                            :quest-list="props.questList"
                            :option-list="props.optionList"
                            :source-list="props.sourceList"
                            :promo-code-list="props.promoCodeList"
                            :certificate-list="props.certificateList"
                            :order-statuses="props.orderStatuses"
                            :quest-options="props.questOptions"
                            :filters-prepared="filtersPrepared"
                            v-model="filter" @submit="search" @reset="reset"/>
                        <data-table
                            class="mt-10"
                            :delete-many-route="route('orders.destroy-many')"
                            :table-props="tableProps" :items-resource="orders"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="pb-12 flex">
            <div class="mx-auto w-3/4 sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm rounded-3xl">
                    <div class="p-6">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-5">Дополнительные услуги
                            (сводка)</h2>
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <table class="min-w-full">
                                        <thead class="bg-gray-50 text-gray-500 text-left" style="border-radius: 16px">
                                        <tr>
                                            <th class="py-3 px-6">Название</th>
                                            <th class="py-3 px-6">Стоимость</th>
                                            <th class="py-3 px-6">Кол-во применений</th>
                                            <th class="py-3 px-6">Сумма</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="option in props.options.data">
                                            <td class="px-6 py-4 whitespace-nowrap font-bold"
                                                style="max-width: 100px;overflow: hidden;">
                                                {{ option.name_ru }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap"
                                                style="max-width: 100px;overflow: hidden;">
                                                {{ option.price }} руб.
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ option.orders_count }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{
                                                    numberFormat(Number(option.price) * Number(option.orders_count))
                                                }}
                                            </td>
                                        </tr>
                                        <tr class="bg-indigo-600 text-white">
                                            <td></td>
                                            <td class="px-6 py-4 whitespace-nowrap font-bold uppercase">
                                                Итого
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap font-bold uppercase">

                                                {{ sumOptions(props.options.data).orders_count }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap font-bold uppercase">

                                                {{ numberFormat(sumOptions(props.options.data).price) }}
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mx-auto w-1/4 sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm rounded-3xl">
                    <div class="p-6">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-5">Итоги</h2>
                        <!--                        <table class="th-order-management-container__results-table">-->
                        <!--                            <tbody>-->
                        <!--                            <tr>-->
                        <!--                                <th colspan="2">Всего игр: <span>{{ props.ordersMeta.count }}</span>, на сумму-->
                        <!--                                    <span>{{ props.ordersMeta.sum }}</span></th>-->
                        <!--                            </tr>-->
                        <!--                            <tr>-->
                        <!--                                <td>Игры:</td>-->
                        <!--                                <td>{{ props.ordersMeta.games_sum }}</td>-->
                        <!--                            </tr>-->
                        <!--                            <tr>-->
                        <!--                                <td>Допуслуги:</td>-->
                        <!--                                <td>{{ props.ordersMeta.services_sum }}</td>-->
                        <!--                            </tr>-->
                        <!--                            <tr class="th-divider-top">-->
                        <!--                                <th colspan="2">Из них:</th>-->
                        <!--                            </tr>-->
                        <!--                            <tr>-->
                        <!--                                <td>Факт:</td>-->
                        <!--                                <td>{{ props.ordersMeta.paid_instantly }}</td>-->
                        <!--                            </tr>-->
                        <!--                            <tr>-->
                        <!--                                <td>Предоплата:</td>-->
                        <!--                                <td>{{ props.ordersMeta.pre_paid }}</td>-->
                        <!--                            </tr>-->
                        <!--                            <tr>-->
                        <!--                                <td>Онлайн:</td>-->
                        <!--                                <td>{{ props.ordersMeta.paid_online }}</td>-->
                        <!--                            </tr>-->
                        <!--                            <tr>-->
                        <!--                                <td>Агрегаторы:</td>-->
                        <!--                                <td>{{ props.ordersMeta.paid_via_aggregator }}</td>-->
                        <!--                            </tr>-->
                        <!--                            <tr>-->
                        <!--                                <td>Сертификаты:</td>-->
                        <!--                                <td>{{ props.ordersMeta.certificates_sum }}</td>-->
                        <!--                            </tr>-->
                        <!--                            <tr class="th-divider-top">-->
                        <!--                                <th colspan="2">К оплате:</th>-->
                        <!--                            </tr>-->
                        <!--                            <tr>-->
                        <!--                                <td>Остаток к оплате:</td>-->
                        <!--                                <td>{{ props.ordersMeta.left_to_pay }}</td>-->
                        <!--                            </tr>-->
                        <!--                            </tbody>-->
                        <!--                        </table>-->
                        <div class="flex flex-col w-full">
                            <div class="bg-indigo-600 text-white p-5 flex justify-center"
                                 style="border-radius: 16px 16px 0 0">
                                <span class="font-bold text-lg">Всего игр проведено</span>
                            </div>
                            <div class="bg-white text-black px-5 py-4 flex justify-between">
                                <span>Кол-во игр:</span>
                                <span>{{ props.ordersMeta.count }}</span>
                            </div>
                            <div class="bg-indigo-600 text-white p-5 flex justify-center">
                                <span class="font-bold text-lg">Общая сумма</span>
                            </div>
                            <div class="bg-white text-black">
                                <div class="flex justify-between border-b px-5 py-4">
                                    <span>Общая сумма:</span>
                                    <span>{{ props.ordersMeta.sum }}</span>
                                </div>
                                <div class="flex justify-between border-b px-5 py-4">
                                    <span>Сумма по играм:</span>
                                    <span>{{ props.ordersMeta.games_sum }}</span>
                                </div>
                                <div class="flex justify-between border-b px-5 py-4">
                                    <span>Сумма по доп.услугам:</span>
                                    <span>{{ props.ordersMeta.services_sum }}</span>
                                </div>
                            </div>
                            <div class="bg-indigo-600 text-white p-5 flex justify-center">
                                <span class="font-bold text-lg">Сумма общая по платежам</span>
                            </div>
                            <div class="bg-white text-black">
                                <div class="flex justify-between border-b px-5 py-4">
                                    <span>Факт:</span>
                                    <span>{{ props.ordersMeta.paid_instantly }}</span>
                                </div>
                                <div class="flex justify-between border-b px-5 py-4">
                                    <span>Предоплаты:</span>
                                    <span>{{ props.ordersMeta.pre_paid }}</span>
                                </div>
                                <div class="flex justify-between border-b px-5 py-4">
                                    <span>Онлайн:</span>
                                    <span>{{ props.ordersMeta.paid_online }}</span>
                                </div>
                                <div class="flex justify-between border-b px-5 py-4">
                                    <span>Агрегаторы:</span>
                                    <span>{{ props.ordersMeta.paid_via_aggregator }}</span>
                                </div>
                                <div class="flex justify-between border-b px-5 py-4">
                                    <span>Сертификаты:</span>
                                    <span>{{ props.ordersMeta.certificates_sum }}</span>
                                </div>
                            </div>
                            <div class="bg-indigo-600 text-white p-5 flex justify-center">
                                <span class="font-bold text-lg">Остаток к оплате</span>
                            </div>

                            <div class="bg-white text-black">
                                <div class="flex justify-center px-5 py-4">
                                    <span class="font-bold">{{ props.ordersMeta.left_to_pay }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

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
import OrderModal from "@/Components/Modals/OrderModal.vue";

const usingFilter = ref(null);

const props = defineProps({
    orders: Object,
    filters: Array,
    options: Object,
    ordersMeta: Object,
    ...orderProps
})

watch(() => props.orders, value => {

}, {
    deep: true
})

const getOrderStatus = (status) => {
    return props.orderStatuses[status]
}

const edit = (order) => {
    showOrderModal(order)
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

const orderModal = ref({
    show: false,
    order: {},
    mode: 0,
})

const showOrderModal = (order = {
    quest_id: null,
    date: null,
    time: null,
    customer_name: null,
    customer_email: null,
    customer_phone: null,
    order_source_id: null,
    option: 'Нет',
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
    order_option_1: null,
    order_option_2: null,
    order_option_3: null,
    order_payments: [],
}) => {
    orderModal.value.show = true
    orderModal.value.order = order
    orderModal.value.mode = order?.id ? 1 : 0
}

const refreshOrder = (orderId) => {
    orderModal.value.order.order_payments = collect(props.orders.data).where('id', '==', orderId).first()?.order_payments || []
}

watch(orderModal, value => {
    // console.log(value)
}, {deep: true})
</script>

<template>
    <order-modal
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
        @refresh-order="refreshOrder"
        v-model="orderModal"/>
    <Head title="Таблица заказов"/>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex w-full items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Таблица заказов</h2>
                <div class="ml-auto sm:gap-x-10 gap-x-5 flex">
                    <button
                        type="button"
                        @click="showOrderModal()"
                        class="relative inline-flex items-center sm:px-5 px-2 sm:py-2 py-1 border border-indigo-600 text-sm font-medium rounded-md focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <PlusIcon class="h-5 w-5 sm:mr-2 text-indigo-600 font-bold" aria-hidden="true"/>
                        <span class="text-indigo-600 font-bold desktop-only">Создать заказ</span>
                    </button>
                    <button
                        type="button"
                        @click.prevent="toExcel"
                        class="relative inline-flex items-center sm:px-5 px-2 sm:py-2 py-1 border border-green-600 text-sm font-medium rounded-md focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <span class="text-green-600 font-bold desktop-only">Выгрузка в Excel</span>
                        <svg class="mobile-only" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_151_242)">
                                <path d="M14.1733 8.54526H11.6288L11.6288 7.27297H14.1733V8.54526ZM14.1733 9.27228H11.6288L11.6288 10.5446H14.1733V9.27228ZM14.1733 3.27433H11.6288L11.6288 4.54663H14.1733V3.27433ZM14.1733 5.27365H11.6288L11.6288 6.54594H14.1733V5.27365ZM14.1733 11.2716H11.6288L11.6288 12.5439H14.1733V11.2716ZM15.9309 13.7798C15.8582 14.1579 15.4038 14.167 15.1003 14.1797H9.44768V15.8155H8.31898L0 14.3615V1.64034L8.36805 0.184479H9.44768V1.63308L14.9058 1.63307C15.213 1.6458 15.5511 1.62399 15.8182 1.80756C16.0054 2.07656 15.9873 2.41826 16 2.72725L15.9927 12.1895C15.9836 12.7184 16.0418 13.2582 15.9309 13.7798ZM6.665 10.9281C6.16335 9.91025 5.65261 8.89968 5.15278 7.88185C5.64716 6.89128 6.13427 5.89707 6.61956 4.90287C6.20697 4.92286 5.79438 4.94831 5.38362 4.97739C5.07645 5.72441 4.71839 6.45143 4.47847 7.22389C4.25491 6.49505 3.95865 5.79347 3.68783 5.08281C3.28797 5.10462 2.88811 5.12824 2.48824 5.15187C2.90992 6.08246 3.35885 7.00033 3.7678 7.93638C3.28615 8.84516 2.8354 9.76666 2.36828 10.6809C2.76633 10.6973 3.16437 10.7136 3.56242 10.7191C3.84596 9.99567 4.19857 9.29955 4.44575 8.56162C4.6675 9.35407 5.04373 10.0866 5.35272 10.8445C5.79075 10.8754 6.22696 10.9026 6.665 10.9281ZM15.1331 2.4963H9.44768L9.44768 3.27433H10.9017V4.54663H9.44768V5.27365H10.9017V6.54594H9.44768V7.27297H10.9017V8.54526H9.44768V9.27228H10.9017V10.5446H9.44768V11.2716H10.9017V12.5439H9.44768V13.3844H15.1331V2.4963Z" fill="#4CA154"/>
                            </g>
                            <defs>
                                <clipPath id="clip0_151_242">
                                    <rect width="16" height="16" fill="white"/>
                                </clipPath>
                            </defs>
                        </svg>
                    </button>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8 px-2">
                <div class="bg-white shadow-sm rounded-3xl">
                    <div class="sm:p-6 rounded-3xl">
                        <div class="desktop-only flex flex-col rounded-3xl">
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
                        </div>
                        <data-table
                            class="sm:mt-10 rounded-3xl"
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

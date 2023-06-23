<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router, Link, useForm} from '@inertiajs/vue3';
import DataTable from "@/Components/Common/DataTable.vue";
import {computed, onMounted, reactive, ref, watch} from "vue";
import {getAlreadyPayed, getOrderPriceToPay, orderProps} from "@/Traits/OrderTrait";
import {getCurrentUrlParam, numberFormat} from "@/Traits/Tools";
import exportFromJSON from "export-from-json";
import OrderFilter from "@/Components/Orders/OrderFilter.vue";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
import {collect} from "collect.js";
import ExpandableBlock from "@/Components/Common/ExpandableBlock.vue";
import {TrashIcon, PencilIcon, ClockIcon} from "@heroicons/vue/24/solid";
import CertificateSelect from "@/Components/Orders/CertificateSelect.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";

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
                return 'white-space: normal !important;' + `background-color:${getOrderStatus(item.status).color};color: black`
            },
            getValue: (order) => {
                return `№${order.id} <br/> ${order.created_at} <br/> ${getOrderStatus(order.status).name}`
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
        {
            name: 'Промокод <br/> сертификат',
            getValue: (item) => ({
                component: CertificateSelect,
                meta: {
                    certificateList: props.certificateList,
                    item
                }
            }),
        },
        {
            name: 'Квест',
            getValue: (order) => order.quest,
            getRowStyle: (item) => {
                return 'max-width: 100px;white-space: normal !important;'
            },
        },
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
            getValue: (order) => {
                return `${getAlreadyPayed(order)} руб.`
            }
        },
        {
            name: 'К оплате',
            getValue: (order) => {
                return `${getOrderPriceToPay(order.price_total, order)} руб.`
            }
        },
        {
            name: 'Источник',
            getValue: (order) => order.source
        },
        {
            name: 'Комментарий',
            getRowStyle: (item) => {
                return 'white-space: normal !important;max-width: 150px;white-space: normal !important;'
            },
            getValue: (order) => order?.comment
        },
    ],
    actions: [
        {
            name: 'Оплата',
            trigger: payments
        },
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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Таблица заказов</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
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
                        <div class="col-span-6 sm:col-span-1 mt-5">
                            <input-label for="search_string" value="Поиск"/>
                            <text-input
                                id="search_string"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="filter.search_string"

                            />
                            <input-error class="mt-2" :message="filter.errors.search_string"/>
                        </div>
                        <hr class="my-5"/>
                        <order-filter
                            :disabled="!!usingFilter"
                            :quest-list="props.questList"
                            :option-list="props.optionList"
                            :source-list="props.sourceList"
                            :promo-code-list="props.promoCodeList"
                            :certificate-list="props.certificateList"
                            :order-statuses="props.orderStatuses"
                            :quest-options="props.questOptions"
                            :filters-prepared="filtersPrepared"
                            v-model="filter" @submit="search" @to-excel="toExcel" @reset="reset"/>
                        <data-table :create-link="route('orders.create')"
                                    :delete-many-route="route('orders.destroy-many')"
                                    :table-props="tableProps" :items-resource="orders"/>
                        <expandable-block v-model="showSums" class="mt-5">
                            <template #header>
                                <h2 class="text-lg font-semibold">Итоги</h2>
                            </template>
                            <template #content>
                                <table class="th-order-management-container__results-table">
                                    <tbody>
                                    <tr>
                                        <th colspan="2">Всего игр: <span>{{ props.ordersMeta.count }}</span>, на сумму
                                            <span>{{ props.ordersMeta.sum }}</span></th>
                                    </tr>
                                    <tr>
                                        <td>Игры:</td>
                                        <td>{{ props.ordersMeta.games_sum }}</td>
                                    </tr>
                                    <tr>
                                        <td>Допуслуги:</td>
                                        <td>{{ props.ordersMeta.services_sum }}</td>
                                    </tr>
                                    <tr class="th-divider-top">
                                        <th colspan="2">Из них:</th>
                                    </tr>
                                    <tr>
                                        <td>Факт:</td>
                                        <td>{{ props.ordersMeta.payed_instantly }}</td>
                                    </tr>
                                    <tr>
                                        <td>Предоплата:</td>
                                        <td>{{ props.ordersMeta.pre_payed }}</td>
                                    </tr>
                                    <tr>
                                        <td>Онлайн:</td>
                                        <td>{{ props.ordersMeta.payed_online }}</td>
                                    </tr>
                                    <tr>
                                        <td>Агрегаторы:</td>
                                        <td>{{ props.ordersMeta.payed_via_aggregator }}</td>
                                    </tr>
                                    <tr>
                                        <td>Сертификаты:</td>
                                        <td>{{ props.ordersMeta.certificates_sum }}</td>
                                    </tr>
                                    <tr class="th-divider-top">
                                        <th colspan="2">К оплате:</th>
                                    </tr>
                                    <tr>
                                        <td>Остаток к оплате:</td>
                                        <td>{{ props.ordersMeta.left_to_pay }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </template>
                        </expandable-block>
                        <div class="mt-5">
                            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                    <div class="shadow-xl overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-100">
                                            <tr>
                                                <th class="py-3">Доп услуга</th>
                                                <th>Количество применений</th>
                                                <th>Сумма</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="option in props.options.data">
                                                <td class="px-6 py-4 whitespace-nowrap  font-bold"
                                                    style="max-width: 100px;overflow: hidden;">
                                                    {{ option.name_ru }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap  text-gray-500">
                                                    {{ option.orders_count }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap  text-gray-500">
                                                    {{ numberFormat(Number(option.price) * Number(option.orders_count)) }}
                                                </td>
                                            </tr>
                                            <tr class="bg-green-400 text-white">
                                                <td class="px-6 py-4 whitespace-nowrap font-bold">
                                                    Итого
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ sumOptions(props.options.data).orders_count }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
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
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import OrderForm from "@/Components/Orders/OrderForm.vue";
import {Head, router, useForm} from "@inertiajs/vue3";
import {orderProps} from "@/Traits/OrderTrait";
import {getCurrentUrlParam, numberFormat} from "@/Traits/Tools";
import {computed, onMounted, ref} from "vue";
import DataTable from "@/Components/Common/DataTable.vue";
import OrderFilter from "@/Components/Orders/OrderFilter.vue";
import {collect} from "collect.js";
import Pagination from "@/Components/Common/Pagination.vue";

const props = defineProps({
    orders: Object,
    paid: Object,
    sources: Object,
    certificates: Object,
    sales: Object,
    options: Object,
    ...orderProps
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
console.log(props.options)
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
})

const search = () => {
    filter.get(route('orders-stats'))
}

const reset = () => {
    filter.reset().get(route('orders-stats'))
}

const mainNumber = computed({
    get() {
        return Number(props.orders.main) - Number(props.orders.for_friends) - Number(props.orders.aggregator)
    },
    set() {
    }
})

const sumSources = (sources) => {
    const sums = {
        orders_sum_price: 0,
        fee: 0,
        orders_sum_paid_aggregator: 0,
    }
    for (const source of sources) {
        sums.orders_sum_price += Number(source.orders_sum_price)
        sums.fee += Number(source.orders_sum_price / 100 * 35)
        sums.orders_sum_paid_aggregator += Number(source.orders_sum_paid_aggregator)
    }
    return sums
}

const sumCertificates = (certificates) => {
    const sums = {
        price: 0,
    }
    for (const certificate of certificates) {
        sums.price += Number(certificate.price)
    }
    return sums
}

const sumSales = (sales) => {
    const sums = {
        value: 0,
        orders_count: 0,
    }
    for (const sale of sales) {
        sums.value += Number(sale.value)
        sums.orders_count += Number(sale.orders_count)
    }
    return sums
}

const sumOptions = (options) => {
    const sums = {
        price: 0,
        orders_count: 0,
    }
    for (const option of options) {
        sums.price += Number(option.price)
        sums.orders_count += Number(option.orders_count)
    }
    return sums
}
</script>

<template>
    <Head title="Статистика"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Статистика</h2>
        </template>
        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg flex flex-col">
                    <div class="p-6">
                        <order-filter
                            :needs-excel="false"
                            :quest-list="props.questList"
                            :option-list="props.optionList"
                            :source-list="props.sourceList"
                            :promo-code-list="props.promoCodeList"
                            :certificate-list="props.certificateList"
                            :order-statuses="props.orderStatuses"
                            :quest-options="props.questOptions"
                            v-model="filter" @submit="search" @reset="reset"/>
                    </div>
                    <div class="flex flex-col mb-5 px-5">
                        <h2 class="text-xl font-bold mb-5">База для расчета</h2>
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8 flex">
                                <div class="overflow-hidden border-b border-gray-200 rounded-2xl w-1/2">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-100 w-full">
                                        <tr>
                                            <th class="py-4 text-left pl-6 text-gray-500">
                                                Название
                                            </th>
                                            <th class="py-4 text-left pl-6 text-gray-500">
                                                Стоимость
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                Игры, всего
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap  text-gray-500">
                                                {{numberFormat(Number(props.orders.main))}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                Игры "для друзей"
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{numberFormat(Number(props.orders.for_friends))}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                Игры от агр (без доп усл)
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{numberFormat(Number(props.orders.aggregator))}}
                                            </td>
                                        </tr>
                                        <tr class="bg-indigo-500 text-white">
                                            <td class="px-6 py-4 whitespace-nowrap аи">
                                                База для расчета
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap ">
                                                {{
                                                    numberFormat(Number(mainNumber))
                                                }}
                                            </td>
                                        </tr>
<!--                                        <tr class="bg-red-500 text-white">-->
<!--                                            <td class="px-6 py-4 whitespace-nowrap ">-->
<!--                                                Остаток к оплате-->
<!--                                            </td>-->
<!--                                            <td class="px-6 py-4 whitespace-nowrap ">-->
<!--                                                {{-->
<!--                                                    numberFormat(Number(props.orders.left_to_pay))-->
<!--                                                }}-->
<!--                                            </td>-->
<!--                                        </tr>-->
                                        </tbody>
                                    </table>
                                </div>
                                <div class="overflow-hidden w-1/4 ml-auto mr-auto rounded-2xl bg-transparent">
                                    <table class="min-w-full divide-y divide-gray-200 rounded-2xl border border-gray-200 shadow">
                                        <thead class="bg-gray-100 w-full rounded-2xl">
                                        <tr>
                                            <th class="py-4 text-gray-500">
                                                Остаток к оплате
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody class="rounded-2xl">
                                        <tr class="rounded-2xl">
                                            <td class="px-6 rounded-2xl py-4 whitespace-nowrap text-center text-green-600 font-bold text-lg">
                                                {{ numberFormat(Number(props.orders.left_to_pay)) }}
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col mb-5 px-5">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <h2 class="text-xl font-bold mb-5">Сводка</h2>
                                <div class=" overflow-hidden border-b border-gray-200 sm:rounded-2xl">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-100">
                                        <tr>
                                            <th colspan="4" class="bg-yellow-400 py-3">Начислено</th>
                                            <th colspan="3" class="bg-green-400">Оплачено</th>
                                            <th class="bg-indigo-400">К перечислению</th>
                                        </tr>
                                        </thead>
                                        <thead>
                                        <tr>
                                            <th class="py-5 bg-white border-l-2 border-yellow-400">Комиссия агрегаторов</th>
                                            <th class="py-5 bg-white">Маркетинговый взнос</th>
                                            <th class="py-5 bg-white">Роялти</th>
                                            <th class="py-5 bg-white">ИТОГО</th>
                                            <th class="py-5 border-l-2 border-green-400">у агрегаторов</th>
                                            <th class="py-5">онлайн</th>
                                            <th class="py-5">сертификаты</th>
                                            <th class="py-5 border-l-2 border-indigo-400">Остаток за месяц</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="bg-yellow-50 border-l-2 border-yellow-400 py-5 text-center">
                                                {{ numberFormat(Number(mainNumber / 100 * 35)) }}
                                            </td>
                                            <td class="bg-yellow-50 py-5 text-center">
                                                {{ numberFormat(Number(mainNumber / 100 * 15)) }}
                                            </td>
                                            <td class="bg-yellow-50 py-5 text-center">
                                                {{ numberFormat(Number(mainNumber / 100 * 7)) }}
                                            </td>
                                            <td class="bg-yellow-50 py-5 text-center">{{
                                                    numberFormat(Number(mainNumber / 100 * 35) + Number(mainNumber / 100 * 15) + Number(mainNumber / 100 * 7))
                                                }}
                                            </td>

                                            <td class="border-l-2 border-green-400 bg-green-50 py-5 text-center">
                                                {{ numberFormat(props.paid.aggregator) }}
                                            </td>
                                            <td class="bg-green-50 py-5 text-center">{{ numberFormat(0) }}</td>
                                            <td class="bg-green-50 py-5 text-center">{{ numberFormat(0) }}</td>

                                            <td class="border-l-2 border-indigo-400 bg-indigo-50 py-5 text-center">{{
                                                    numberFormat(
                                                        Number(mainNumber / 100 * 35) + Number(mainNumber / 100 * 15) + Number(mainNumber / 100 * 7) - Number(props.paid.aggregator)
                                                    )
                                                }}
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex">
                        <div class="flex flex-col mb-5 px-5 w-3/4">
                            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8 w-3/4">
                                    <h2 class="text-xl font-bold mb-5">Комиссия агрегаторов</h2>
                                    <div class=" overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-100">
                                            <tr>
                                                <th class="py-3">Агрегатор</th>
                                                <th class="py-3">Сумма игр <br/> (без доп.услуг)</th>
                                                <th class="py-3">Комиссия</th>
                                                <th class="py-3">Оплачено <br/> у агрегатора</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="source in props.sources.data">
                                                <td class="px-6 py-4 whitespace-nowrap  font-bold">
                                                    {{ source.name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap  text-gray-500">
                                                    {{ numberFormat(source.orders_sum_price) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap  text-gray-500">
                                                    {{ numberFormat(Number(source.orders_sum_price) / 100 * 35) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap  text-gray-500">
                                                    {{ numberFormat(Number(source.orders_sum_paid_aggregator)) }}
                                                </td>
                                            </tr>
                                            <tr class="bg-indigo-600 text-white">
                                                <td class="px-6 py-4 whitespace-nowrap font-bold">
                                                    Итого
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ numberFormat(sumSources(props.sources.data).orders_sum_price) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ numberFormat(sumSources(props.sources.data).fee) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{
                                                        numberFormat(sumSources(props.sources.data).orders_sum_paid_aggregator)
                                                    }}
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-1/4">
                            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                    <h2 class="text-xl font-bold mb-5">Сертификаты</h2>
                                    <div class=" overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-100">
                                            <tr>
                                                <th class="py-3 pl-6 text-left">Номер <br/> заказа</th>
                                                <th class="text-left pl-6">Номер <br/> сертификата</th>
                                                <th class="text-left pl-6">Сумма</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="certificate in props.certificates.data">
                                                <td class="px-6 py-4 whitespace-nowrap  font-bold">
                                                    {{ certificate.order.id }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap  text-gray-500">
                                                    {{ certificate.number }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap  text-gray-500">
                                                    {{ numberFormat(Number(certificate.price)) }}
                                                </td>
                                            </tr>
                                            <tr class="bg-indigo-600 text-white">
                                                <td class="px-6 py-4 whitespace-nowrap font-bold">
                                                    Итого
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap"/>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ numberFormat(sumCertificates(props.certificates.data).price) }}
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-6 gap-6 w-full">
                        <div class="col-span-6 sm:col-span-3 px-5">
                            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                    <h2 class="text-xl font-bold mb-5">Акции</h2>
                                    <div class="shadow-xl overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-100">
                                            <tr>
                                                <th class="py-3">Промокод</th>
                                                <th>Количество применений</th>
                                                <th>Сумма</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="sale in props.sales.data">
                                                <td class="px-6 py-4 whitespace-nowrap  font-bold">
                                                    {{ sale.promo_code }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap  text-gray-500">
                                                    {{ sale.orders_count }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap  text-gray-500">
                                                    {{ numberFormat(Number(sale.value)) }}
                                                </td>
                                            </tr>
                                            <tr class="bg-indigo-600 text-white">
                                                <td class="px-6 py-4 whitespace-nowrap font-bold">
                                                    Итого
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ sumSales(props.sales.data).orders_count }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ numberFormat(sumSales(props.sales.data).value) }}
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-3 px-5">
                            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                    <h2 class="text-xl font-bold mb-5">Доп. услуги</h2>
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
                                                <td class="px-6 py-4 whitespace-nowrap  font-bold" style="max-width: 100px;overflow: hidden;">
                                                    {{ option.name_ru }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap  text-gray-500">
                                                    {{ option.orders_count }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap  text-gray-500">
                                                    {{ numberFormat(Number(option.price)) }}
                                                </td>
                                            </tr>
                                            <tr class="bg-indigo-600 text-white">
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
                    <pagination class="p-5 mx-10"
                                :current-page="props.options.current_page"
                                :max-page="100"/>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

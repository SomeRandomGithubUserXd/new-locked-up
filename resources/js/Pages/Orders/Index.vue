<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router, Link, useForm} from '@inertiajs/vue3';
import DataTable from "@/Components/Common/DataTable.vue";
import {onMounted, ref} from "vue";
import {getAlreadyPayed, getOrderPriceToPay, orderProps} from "@/Traits/OrderTrait";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import {getCurrentUrlParam} from "@/Traits/Tools";
import exportFromJSON from "export-from-json";

const props = defineProps({
    orders: Object,
    ...orderProps
})

const pageChange = (page) => {
    router.reload({
        data: {
            page
        }
    })
}

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
        onPageChange: pageChange,
    }
})

const defaultFilter = {
    date_from: null,
    date_to: null,
    quest_id: null,
    order_id: null,
    source_id: null,
    status: null,
    promo_code_id: null,
    order_by: null,
}
const filter = useForm(defaultFilter)

onMounted(() => {
    for (const key in defaultFilter) {
        filter[key] = getCurrentUrlParam(key)
    }
})

const search = () => {
    filter.get(route('orders.index'), {
        onError: (err) => console.log(err)
    })
}

const reset = () => {
    filter.reset().get(route('orders.index'), {
        onError: (err) => console.log(err)
    })
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
                        <form class="space-y-6 mb-5" @submit.prevent="search">
                            <h2 class="font-semibold text-2xl">Фильтр</h2>
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <InputLabel for="date_from" value="Дата (от)"/>
                                    <TextInput
                                        id="date_from"
                                        type="date"
                                        class="mt-1 block w-full"
                                        v-model="filter.date_from"

                                    />
                                    <InputError class="mt-2" :message="filter.errors.date_from"/>
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <InputLabel for="date" value="Дата (до)"/>
                                    <TextInput
                                        id="date_to"
                                        type="date"
                                        class="mt-1 block w-full"
                                        v-model="filter.date_to"

                                    />
                                    <InputError class="mt-2" :message="filter.errors.date_to"/>
                                </div>
                            </div>
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-1">
                                    <InputLabel for="order_id" value="Номер заказа"/>
                                    <TextInput
                                        id="order_id"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="filter.order_id"

                                    />
                                    <InputError class="mt-2" :message="filter.errors.order_id"/>
                                </div>
                                <div class="col-span-6 sm:col-span-1">
                                    <label for="quest_id" class="block text-sm font-medium text-gray-700">
                                        Квесты </label>
                                    <div class="mt-1">
                                        <select
                                            id="quest_id"
                                            v-model="filter.quest_id"

                                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option value="">
                                                Нет
                                            </option>
                                            <option v-for="quest in props.questList" :value="quest.id">
                                                {{ quest.name_ru }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-span-6 sm:col-span-1">
                                    <label for="source_id" class="block text-sm font-medium text-gray-700">
                                        Источник </label>
                                    <div class="mt-1">
                                        <select
                                            id="source_id"
                                            v-model="filter.source_id"

                                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option value="">
                                                Нет
                                            </option>
                                            <option v-for="source in props.sourceList" :value="source.id">
                                                {{ source.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-span-6 sm:col-span-1">
                                    <label for="status" class="block text-sm font-medium text-gray-700">
                                        Статус </label>
                                    <div class="mt-1">
                                        <select
                                            id="quest"
                                            v-model="filter.status"

                                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option value="">
                                                Нет
                                            </option>
                                            <option v-for="(status, key) in props.orderStatuses" :value="key">
                                                {{ status.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-span-6 sm:col-span-1">
                                    <label for="quest" class="block text-sm font-medium text-gray-700">
                                        Акция </label>
                                    <div class="mt-1">
                                        <select
                                            id="quest"
                                            v-model="filter.promo_code_id"

                                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option value="">
                                                Нет
                                            </option>
                                            <option v-for="promoCode in props.promoCodeList" :value="promoCode.id">
                                                {{ promoCode.promocode }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-span-6 sm:col-span-1">
                                    <label for="quest" class="block text-sm font-medium text-gray-700">
                                        Сортировка </label>
                                    <div class="mt-1">
                                        <select
                                            id="quest"
                                            v-model="filter.order_by"

                                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option value="">
                                                По умолчанию
                                            </option>
                                            <option value="time_asc">
                                                По времени игры &#8593;
                                            </option>
                                            <option value="time_desc">
                                                По времени игры &#8595;
                                            </option>
                                            <option value="date_asc">
                                                По дате игры &#8593;
                                            </option>
                                            <option value="date_desc">
                                                По дате игры &#8595;
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-6 mt-5 gap-6">
                                <div class="col-span-6 sm:col-span-4">
                                    <button type="submit"
                                            class="flex w-full justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Искать
                                    </button>
                                </div>
                                <div class="col-span-6 sm:col-span-1">
                                    <button type="button"
                                            @click="toExcel"
                                            class="flex w-full justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Выгрузить в Excel
                                    </button>
                                </div>
                                <div class="col-span-6 sm:col-span-1">
                                    <button type="button"
                                            @click="reset()"
                                            class="flex w-full justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Сбросить
                                    </button>
                                </div>
                            </div>
                        </form>
                        <data-table :create-link="route('orders.create')" @delete-many="deleteMany"
                                    :table-props="tableProps" :items-resource="orders"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

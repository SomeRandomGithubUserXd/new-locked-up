<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router, Link} from '@inertiajs/vue3';
import DataTable from "@/Components/Common/DataTable.vue";
import {ref} from "vue";
import {getOrderPriceToPay} from "@/Traits/OrderTrait";

const props = defineProps({
    orders: Object,
    orderStatuses: Object
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
</script>

<template>
    <Head title="Таблица заказов"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Таблица заказов</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <data-table :create-link="route('orders.create')" @delete-many="deleteMany"
                                    :table-props="tableProps" :items-resource="orders"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import OrderForm from "@/Components/Orders/OrderForm.vue";
import {Head, router, useForm} from "@inertiajs/vue3";
import {orderProps} from "@/Traits/OrderTrait";
import {getCurrentUrlParam} from "@/Traits/Tools";
import {ref} from "vue";
import DataTable from "@/Components/Common/DataTable.vue";

const props = defineProps({
    logs: Object
})

const tableProps = ref({
    records: [
        {
            name: 'Пользователь',
            getValue: (item) => item.user
        },
        {
            name: 'Заказ №',
            getValue: (item) => item.order
        },
        {
            name: 'Изменение',
            getValue: (item) => item.string_value
        },
        {
            name: 'Дата',
            getValue: (item) => item.date
        },
    ],
    pagination: {
        isRequired: true,
    }
})
</script>

<template>
    <Head title="Логи заказа"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Логи заказа</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <data-table :needs-selection="false" :table-props="tableProps"
                                    :items-resource="props.logs"/>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

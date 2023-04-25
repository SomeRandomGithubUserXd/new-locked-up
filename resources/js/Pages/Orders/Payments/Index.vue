<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import OrderForm from "@/Components/Orders/OrderForm.vue";
import {Head, router, useForm} from "@inertiajs/vue3";
import {orderProps} from "@/Traits/OrderTrait";
import {getCurrentUrlParam} from "@/Traits/Tools";
import {ref} from "vue";
import DataTable from "@/Components/Common/DataTable.vue";

const props = defineProps({
    payments: Object,
    order: Object
})

const tableProps = ref({
    records: [
        {
            name: '#',
            getValue: (item) => item.id
        }
    ],
    pagination: {
        isRequired: true,
    }
})
</script>

<template>
    <Head title="Платежи по заказу"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Платежи по заказу</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <data-table
                            :create-link="route('orders.payments.create', props.order.id)"
                            :needs-selection="false" :table-props="tableProps"
                            :items-resource="props.payments"/>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

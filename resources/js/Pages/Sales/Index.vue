<script setup>
import {Head, router} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {ref} from "vue";
import DataTable from "@/Components/Common/DataTable.vue";

const props = defineProps({
    sales: Object
})

const tableProps = ref({
    records: [
        {
            name: 'Код',
            getValue: (sale) => sale.promo_code
        },
        {
            name: 'Тип',
            getValue: (sale) => sale.type
        },
        {
            name: 'Значение',
            getValue: (sale) => sale.value
        },
        {
            name: 'Квесты',
            getValue: (sale) => sale.quest_list
        },
        {
            name: 'Начало',
            getValue: (sale) => sale.start_date
        },
        {
            name: 'Окончание',
            getValue: (sale) => sale.best_before
        },
        {
            name: 'Только будние дни',
            getValue: (sale) => sale.weekdays_only
        },
    ],
    actions: [
        {
            name: 'Редактировать',
            trigger(topic) {
                router.get(route('sales.show', topic))
            }
        }
    ],
    pagination: {
        isRequired: true,
    }
})
</script>

<template>
    <Head title="Таблица акций"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Таблица акций</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <data-table :create-link="route('sales.create')"
                                    :delete-many-route="route('sales.destroy-many')" :table-props="tableProps"
                                    :items-resource="props.sales"/>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

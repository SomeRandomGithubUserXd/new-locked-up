<script setup>
import {Head, router, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {onMounted, ref} from "vue";
import DataTable from "@/Components/Common/DataTable.vue";
import SaleFilter from "@/Components/Sales/SaleFilter.vue";
import {salesProps} from "@/Traits/SalesTrait";
import {getCurrentUrlParam} from "@/Traits/Tools";

const props = defineProps({
    sales: Object,
    ...salesProps
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

const defaultFilter = {
    search_string: null,
    promo_code: null,
    value: null,
    start_date: null,
    best_before: null,
    type: null,
    quest_ids: null,
    weekdays_only: null,
}

const filter = useForm(defaultFilter)

onMounted(() => {
    for (const key in defaultFilter) {
        switch (key) {
            case 'quest_ids':
                filter[key] = getCurrentUrlParam('quest_ids[]', true, Number)
                break;
            case 'weekdays_only':
                filter[key] = getCurrentUrlParam(key) === 'true'
                break;
            default:
                filter[key] = getCurrentUrlParam(key)
                break;
        }
    }
})

const search = () => {
    filter.get(route('sales.index'))
}

const reset = () => {
    filter.reset().get(route('sales.index'))
}
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
                        <sale-filter
                            :certificate-types="certificateTypes"
                            :quest-list="props.questList"
                            @submit="search"
                            @reset="reset"
                            v-model="filter"/>
                        <data-table :create-link="route('sales.create')"
                                    :delete-many-route="route('sales.destroy-many')" :table-props="tableProps"
                                    :items-resource="props.sales"/>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

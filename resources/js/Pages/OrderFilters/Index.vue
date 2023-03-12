<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {onMounted, ref} from "vue";
import {getAlreadyPayed, getOrderPriceToPay} from "@/Traits/OrderTrait";
import DataTable from "@/Components/Common/DataTable.vue";
import {Head, router, Link, useForm} from '@inertiajs/vue3';
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import {getCurrentUrlParam} from "@/Traits/Tools";

const props = defineProps({
    filters: Object,
})

const tableProps = ref({
    records: [
        {
            name: 'Название',
            getValue: (filterInstance) => {
                return filterInstance.name
            }
        },
        {
            name: 'Создан',
            getValue: (appeal) => appeal.created_at
        },
        {
            name: 'Обновлен',
            getValue: (appeal) => appeal.updated_at
        },
    ],
    actions: [
        {
            name: 'Редактировать',
            trigger: (filter) => router.get(route('order-filters.show', filter))

        }
    ],
    pagination: {
        isRequired: true,
    }
})

const deleteMany = (ids) => {
    if (confirm('Вы уверены?')) {
        router.post(route('order-filters.destroy-many'), {
            ids
        })
    }
}
</script>

<template>
    <Head title="Таблица фильтров заказов"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Таблица фильтров заказов</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <data-table @delete-many="deleteMany" :create-link="route('order-filters.create')" :table-props="tableProps"
                                    :items-resource="filters"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

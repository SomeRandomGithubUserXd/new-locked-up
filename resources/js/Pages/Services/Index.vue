<script setup>
import {Head, router} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DataTable from "@/Components/Common/DataTable.vue";
import {ref} from "vue";

const props = defineProps({
    services: Object
})

const tableProps = ref({
    records: [
        {
            name: 'Название',
            getValue: (service) => {
                return service.name_ru
            }
        },
        {
            name: 'Цена',
            getValue: (service) => service.price + ' руб.'
        },
        {
            name: 'Активна',
            getValue: (service) => service.is_active
        },
        {
            name: 'Является внутренней',
            getValue: (service) => service.is_inner
        },
    ],
    actions: [
        {
            name: 'Редактировать',
            trigger: (filter) => router.get(route('services.show', filter))

        }
    ],
    pagination: {
        isRequired: true,
    }
})
</script>

<template>
    <Head title="Таблица услуг"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Таблица услуг</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <data-table :delete-many-route="route('services.destroy-many')" :create-link="route('services.create')" :table-props="tableProps" :items-resource="services"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

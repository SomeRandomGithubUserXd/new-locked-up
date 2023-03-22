<script setup>
import {Head, router} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {ref} from "vue";
import DataTable from "@/Components/Common/DataTable.vue";
const props = defineProps({
    locations: Object
})

const tableProps = ref({
    records: [
        {
            name: 'Название',
            getValue: (location) => location.name_ru
        },
        {
            name: 'Телефон',
            getValue: (location) => location.phone
        },
        {
            name: 'Адрес',
            getValue: (location) => location.address_ru
        },
        {
            name: 'E-Mail',
            getValue: (location) => location.email
        },
    ],
    actions: [
        {
            name: 'Редактировать',
            trigger(location) {
                router.get(route('locations.show', location))
            }
        }
    ]
})
</script>

<template>
    <Head title="Таблица локаций"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Таблица локаций</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <data-table :create-link="route('locations.create')" :delete-many-route="route('locations.destroy-many')" :table-props="tableProps" :items-resource="locations"/>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

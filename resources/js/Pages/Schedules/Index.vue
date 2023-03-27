<script setup>
import {Head, router} from "@inertiajs/vue3";
import DataTable from "@/Components/Common/DataTable.vue";
import {ref} from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    schedules: Object
})

const tableProps = ref({
    records: [
        {
            name: 'Название',
            getValue: (schedule) => {
                return schedule.name || 'Нет'
            },
        },
        {
            name: 'Квест',
            getValue: (schedule) => {
                return schedule.quest || 'Нет'
            },
        },
    ],
    actions: [
        {
            name: 'Редактировать',
            trigger: (filter) => router.get(route('schedules.show', filter))

        }
    ],
    pagination: {
        isRequired: true,
    }
})
</script>

<template>
    <Head title="Таблица расписаний"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Таблица расписаний</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <data-table :delete-many-route="route('schedules.destroy-many')"
                                    :create-link="route('schedules.create')" :table-props="tableProps"
                                    :items-resource="schedules"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

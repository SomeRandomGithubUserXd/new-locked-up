<script setup>
import {Head, router} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {ref} from "vue";
import DataTable from "@/Components/Common/DataTable.vue";

const props = defineProps({
    loungeSchedules: Object
})

const tableProps = ref({
    records: [
        {
            name: 'Название',
            getValue: (schedule) => schedule.name
        },
    ],
    actions: [
        {
            name: 'Редактировать',
            trigger(schedule) {
                router.get(route('lounge-schedules.show', schedule))
            }
        }
    ],
    pagination: {
        isRequired: true,
    }
})
</script>

<template>
    <Head title="Таблица лаунжей"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Таблица лаунжей</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <data-table :create-link="route('lounge-schedules.create')"
                                    :delete-many-route="route('lounge-schedules.destroy-many')" :table-props="tableProps"
                                    :items-resource="props.loungeSchedules"/>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

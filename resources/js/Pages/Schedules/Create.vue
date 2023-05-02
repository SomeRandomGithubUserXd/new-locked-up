<script setup>
import {Head, router, useForm} from "@inertiajs/vue3";
import DataTable from "@/Components/Common/DataTable.vue";
import {ref, watch} from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ScheduleForm from "@/Components/Schedules/ScheduleForm.vue";
import Tabs from "@/Components/Common/Tabs.vue";

const schedule = useForm({
    name: ''
})
</script>

<template>
    <Head title="Редактировать расписание"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Редактировать расписание</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <schedule-form
                            destroy-route="schedule-items.destroy"
                            v-model="schedule"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

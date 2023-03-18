<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, router} from "@inertiajs/vue3";
import DataTable from "@/Components/Common/DataTable.vue";
import {ref} from "vue";

const props = defineProps({
    quests: Object
})

const tableProps = ref({
    records: [
        {
            name: 'Название',
            getValue: (quest) => {
                return quest.name || 'Нет'
            },
        },
        {
            name: 'Порядок',
            getValue: (quest) => {
                return quest.order || 'Не указан'
            },
        },
        {
            name: 'Просмотров',
            getValue: (quest) => {
                return quest.views || 0
            },
        },
    ],
    actions: [
        {
            name: 'Редактировать',
            trigger: (quest) => {
                router.get(route('quests.show', quest))
            }
        }
    ],
    pagination: {
        isRequired: true,
    }
})
</script>

<template>
    <Head title="Таблица квестов"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Таблица квестов</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <data-table :create-link="route('quests.create')" :table-props="tableProps" :items-resource="quests"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

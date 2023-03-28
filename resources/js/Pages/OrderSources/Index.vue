<script setup>
import {Head, router} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {ref} from "vue";
import DataTable from "@/Components/Common/DataTable.vue";

const props = defineProps({
    sources: Object
})

const tableProps = ref({
    records: [
        {
            name: 'Название',
            getValue: (source) => source.name
        },
    ],
    actions: [
        {
            name: 'Редактировать',
            trigger(source) {
                router.get(route('order-sources.show', source))
            }
        }
    ],
    pagination: {
        isRequired: true,
    }
})
</script>

<template>
    <Head title="Таблица источников"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Таблица источников</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <data-table :create-link="route('order-sources.create')"
                                    :delete-many-route="route('order-sources.destroy-many')" :table-props="tableProps"
                                    :items-resource="props.sources"/>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

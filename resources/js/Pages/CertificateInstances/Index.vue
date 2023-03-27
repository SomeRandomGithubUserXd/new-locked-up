<script setup>
import {Head, router} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {ref} from "vue";
import DataTable from "@/Components/Common/DataTable.vue";

const props = defineProps({
    certificateInstances: Object
})

const tableProps = ref({
    records: [
        {
            name: 'Номер',
            getValue: (certificate) => certificate.number
        },
        {
            name: 'Номинал',
            getValue: (certificate) => certificate.price
        },
        {
            name: 'Статус',
            getValue: (certificate) => `<span style="color:${certificate.status.color}">${certificate.status.name}</span>`
        },
    ],
    actions: [
        {
            name: 'Редактировать',
            trigger(certificate) {
                router.get(route('certificate-instances.show', certificate))
            }
        }
    ],
    pagination: {
        isRequired: true,
    }
})
</script>

<template>
    <Head title="Таблица оригинальных сертификатов"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Таблица оригинальных сертификатов</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <data-table :create-link="route('certificate-instances.create')"
                                    :delete-many-route="route('certificate-instances.destroy-many')" :table-props="tableProps"
                                    :items-resource="props.certificateInstances"/>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

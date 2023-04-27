<script setup>
import {Head, router} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {ref} from "vue";
import DataTable from "@/Components/Common/DataTable.vue";
import CertificateSelect from "@/Components/Orders/CertificateSelect.vue";
import CertificateInstanceStatusSelect from "@/Components/Certificates/CertificateInstanceStatusSelect.vue";

const props = defineProps({
    certificateInstances: Object,
    certificateStatuses: Array,
})

const tableProps = ref({
    records: [
        {
            name: 'Номер',
            getValue: (certificate) =>
                `<span style="${certificate.status.key === 2 ? 'text-decoration: line-through' : ''}">` + certificate.number + '</span>'
        },
        {
            name: 'Номинал',
            getValue: (certificate) => certificate.price
        },
        {
            name: 'Статус',
            getValue: (item) => ({
                component: CertificateInstanceStatusSelect,
                meta: {
                    certificateStatuses: props.certificateStatuses,
                    item
                }
            })
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
                                    :delete-many-route="route('certificate-instances.destroy-many')"
                                    :table-props="tableProps"
                                    :items-resource="props.certificateInstances"/>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<script setup>
import {Head, router, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {ref} from "vue";
import DataTable from "@/Components/Common/DataTable.vue";
import CertificateSelect from "@/Components/Orders/CertificateSelect.vue";
import CertificateInstanceStatusSelect from "@/Components/Certificates/CertificateInstanceStatusSelect.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";

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

const uploadForm = useForm({
    file: null
})

const handleFileUpload = (event) => {
    uploadForm.file = event.target.files[0]
}

const fileInput = ref('')

const uploadCertificates = () => {
    uploadForm.post(route('certificate-instances.upload'))
    // fileInput.value.value = null
    // uploadForm.file = null
}
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
                        <form @submit.prevent="uploadCertificates" class="mb-5">
                            <h2 class="text-xl font-bold">Загрузить сертификаты (excel)</h2>
                            <div class="mt-1 mb-5">
                                <input-label for="file" value="Файл" />
                                <input
                                    accept=".csv,.xls,.xlsx"
                                    id="file"
                                    type="file"
                                    ref="fileInput"
                                    @change="handleFileUpload"
                                />
                                <input-error class="mt-2" :message="uploadForm.errors.file" />
                            </div>
                            <div class="col-span-6 sm:col-span-4">
                                <button type="submit"
                                        class="flex w-full justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Загрузить
                                </button>
                            </div>
                        </form>
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

<script setup>
import {router, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import CertificateForm from "@/Components/Certificates/CertificateForm.vue";

const props = defineProps({
    certificate: Object,
    certificateInstances: Array,
    certificateStatuses: Array
})
const certificateToUpdate = useForm(props.certificate)

const updateCertificate = () => {
    certificateToUpdate.patch(route('certificates.update', props.certificate), {
        onError: (err) => console.log(err)
    })
}
</script>

<template>
    <Head title="Редактировать сертификат"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Редактировать сертификат</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <certificate-form
                            @submit="updateCertificate"
                            v-model="certificateToUpdate"
                            :certificate-instances="props.certificateInstances"
                            :certificate-statuses="props.certificateStatuses"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

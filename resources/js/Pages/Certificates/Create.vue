<script setup>
import {router, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import CertificateForm from "@/Components/Certificates/CertificateForm.vue";

const props = defineProps({
    certificateInstances: Array,
    certificateStatuses: Array
})
const certificate = useForm({
    customer_name: '',
    customer_phone: '',
    customer_email: '',
    certificate_instance_id: null,
    address: '',
    price: 0,
    delivery_price: 0,
    payed_cash: 0,
    payed_card: 0,
    payed_online: 0,
    expires_at: '',
    payment_link: '',
    status: '',
    comment: '',
})

const storeCertificate = () => {
    certificate.post(route('certificates.store'))
}
</script>

<template>
    <Head title="Добавить сертификат"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Добавить сертификат</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <certificate-form
                            @submit="storeCertificate"
                            v-model="certificate"
                            :certificate-instances="props.certificateInstances"
                            :certificate-statuses="props.certificateStatuses"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

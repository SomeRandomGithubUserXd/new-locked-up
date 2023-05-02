<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import LocationForm from "@/Components/Locations/LocationForm.vue";
import QuestOptionForm from "@/Components/Quest/QuestOptionForm.vue";
import QuestTopicForm from "@/Components/QuestTopics/QuestTopicForm.vue";
import CertificteInstanceForm from "@/Components/Certificates/CertificteInstanceForm.vue";

const props = defineProps({
    certificateStatuses: Array
})

const certificate = useForm({
    number: '',
    price: 0,
    status: 0
})

const store = () => {
    certificate.post(route('certificate-instances.store'), {
        onError: (errs) => {
            console.log(errs)
        }
    })
}
</script>

<template>
    <Head title="Добавить сертификат"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Добавить сертификат</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <certificte-instance-form
                            :statuses="certificateStatuses"
                            @submit="store"
                            v-model="certificate"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import LocationForm from "@/Components/Locations/LocationForm.vue";
import QuestOptionForm from "@/Components/Quest/QuestOptionForm.vue";
import QuestTopicForm from "@/Components/QuestTopics/QuestTopicForm.vue";
import CertificteInstanceForm from "@/Components/Certificates/CertificteInstanceForm.vue";

const props = defineProps({
    certificate: Object,
    certificateStatuses: Array
})

const certificateToUpdate = useForm(props.certificate)

const update = () => {
    certificateToUpdate.patch(route('certificate-instances.update', props.certificate), {
        onError: (errs) => {
            console.log(errs)
        }
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
                        <certificte-instance-form
                            :statuses="certificateStatuses"
                            @submit="update"
                            v-model="certificateToUpdate"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

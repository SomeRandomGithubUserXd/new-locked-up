<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import LocationForm from "@/Components/Locations/LocationForm.vue";
import QuestOptionForm from "@/Components/Quest/QuestOptionForm.vue";
import QuestTopicForm from "@/Components/QuestTopics/QuestTopicForm.vue";
import ChildQuestTopicForm from "@/Components/QuestTopics/ChildQuestTopicForm.vue";
import SaleForm from "@/Components/Sales/SaleForm.vue";
import {salesProps} from "@/Traits/SalesTrait";

const props = defineProps({
    sale: Object,
    ...salesProps
})

const saleToUpdate = useForm(props.sale)

const update = () => {
    console.log(saleToUpdate)
    saleToUpdate.patch(route('sales.update', props.sale), {
        onError: (errs) => {
            console.log(errs)
        }
    })
}
</script>

<template>
    <Head title="Редактировать акцию"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Редактировать акцию</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <sale-form
                            :certificate-types="props.certificateTypes"
                            :quest-list="props.questList"
                            @submit="update"
                            v-model="saleToUpdate"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

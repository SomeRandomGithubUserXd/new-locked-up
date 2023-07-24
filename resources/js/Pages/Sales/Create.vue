<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import LocationForm from "@/Components/Locations/LocationForm.vue";
import QuestOptionForm from "@/Components/Quest/QuestOptionForm.vue";
import QuestTopicForm from "@/Components/QuestTopics/QuestTopicForm.vue";
import ChildQuestTopicForm from "@/Components/QuestTopics/ChildQuestTopicForm.vue";
import SaleForm from "@/Components/Sales/SaleForm.vue";

const props = defineProps({
    certificateTypes: Array,
    questList: Array,
})

const sale = useForm({
    weekdays_only: false,
    promo_code: '',
    type: 0,
    value: 0,
    activation_date: '',
    best_before: '',
    quest_ids: [],
    for_certificates: false,
    for_aggregators: false,
})

const store = () => {
    sale.post(route('sales.store'), {
        onError: (errs) => {
            console.log(errs)
        }
    })
}
</script>

<template>
    <Head title="Добавить акцию"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Добавить акцию</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <sale-form
                            :certificate-types="props.certificateTypes"
                            :quest-list="props.questList"
                            @submit="store"
                            v-model="sale"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

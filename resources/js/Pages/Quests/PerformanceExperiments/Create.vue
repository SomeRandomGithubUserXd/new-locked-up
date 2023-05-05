<script setup>
import {useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {orderProps} from "@/Traits/OrderTrait";
import OrderFilter from "@/Components/Orders/OrderFilter.vue";
import {Head} from "@inertiajs/vue3";
import LocationForm from "@/Components/Locations/LocationForm.vue";
import LocationLoungeForm from "@/Components/Locations/LocationLoungeForm.vue";
import QuestPerformanceShowForm from "@/Components/Quest/QuestPerformanceShowForm.vue";
import QuestPerformanceLoadForm from "@/Components/Quest/QuestPerformanceLoadForm.vue";
import QuestPerformanceExperimentForm from "@/Components/Quest/QuestPerformanceExperimentForm.vue";

const props = defineProps({
    questId: Number
})

const performanceExperiment = useForm({
    name_ru: '',
    name_en: '',
    time_ru: '',
    time_en: '',
    description_ru: '',
    description_en: '',
    full_description_ru: '',
    full_description_en: '',
    price: 0,
})

const storeExperiment = () => {
    performanceExperiment.post(route('quests.quest_performance_experiments.store', props.questId))
}
</script>

<template>
    <Head title="Добавить эксперимент к квесту"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Добавить эксперимент к квесту</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <quest-performance-experiment-form @submit="storeExperiment" v-model="performanceExperiment"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

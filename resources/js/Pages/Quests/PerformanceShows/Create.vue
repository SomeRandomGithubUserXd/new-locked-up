<script setup>
import {useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {orderProps} from "@/Traits/OrderTrait";
import OrderFilter from "@/Components/Orders/OrderFilter.vue";
import {Head} from "@inertiajs/vue3";
import LocationForm from "@/Components/Locations/LocationForm.vue";
import LocationLoungeForm from "@/Components/Locations/LocationLoungeForm.vue";
import QuestPerformanceShowForm from "@/Components/Quest/QuestPerformanceShowForm.vue";

const props = defineProps({
    questId: Number
})

const performanceShow = useForm({
    name_ru: '',
    name_en: '',
    time_ru: '',
    time_en: '',
    description_ru: '',
    description_en: '',
    program_ru: '',
    program_en: '',
})

const storeLounge = () => {
    performanceShow.post(route('quests.quest_performance_shows.store', props.questId))
}
</script>

<template>
    <Head title="Добавить шоу к квесту"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Добавить шоу к квесту</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <quest-performance-show-form @submit="storeLounge" v-model="performanceShow"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

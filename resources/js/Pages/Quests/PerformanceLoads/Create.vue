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

const props = defineProps({
    questId: Number
})

const performanceLoad = useForm({
    name_ru: '',
    name_en: '',
    time: '',
    price_workday: 0,
    price_weekend: 0,
    description_ru: '',
    description_en: '',
    class_name: '',
})

const storeLoad = () => {
    performanceLoad.post(route('quests.quest_performance_loads.store', props.questId))
}
</script>

<template>
    <Head title="Добавить пакет к квесту"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Добавить пакет к квесту</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <quest-performance-load-form @submit="storeLoad" v-model="performanceLoad"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

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
    questId: Number,
    questPerformanceShow: Object
})

const performanceShowToEdit = useForm(props.questPerformanceShow)

const storeLounge = () => {
    performanceShowToEdit.patch(route('quests.quest_performance_shows.update', {
        quest_performance_show: props.questPerformanceShow.id,
        quest: props.questId
    }))
}
</script>

<template>
    <Head title="Редактировать шоу"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Редактировать шоу</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <quest-performance-show-form @submit="storeLounge" v-model="performanceShowToEdit"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

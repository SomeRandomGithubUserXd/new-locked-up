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
    questId: Number,
    questPerformanceLoad: Object
})

const performanceLoadToEdit = useForm(props.questPerformanceLoad)

const saveLoad = () => {
    performanceLoadToEdit.patch(route('quests.quest_performance_loads.update', {
        quest_performance_load: props.questPerformanceLoad.id,
        quest: props.questId
    }))
}
</script>

<template>
    <Head title="Редактировать пакет"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Редактировать пакет</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <quest-performance-load-form @submit="saveLoad" v-model="performanceLoadToEdit"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import {useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import QuestPerformanceLoungeForm from "@/Components/Quest/QuestPerformanceLoungeForm.vue";

const props = defineProps({
    questId: Number,
    questPerformanceLounge: Object
})

const performanceLoungeToEdit = useForm(props.questPerformanceLounge)

const saveLounge = () => {
    performanceLoungeToEdit.patch(route('quests.quest_performance_lounges.update', {
        quest_performance_lounge: props.questPerformanceLounge.id,
        quest: props.questId
    }))
}
</script>

<template>
    <Head title="Редактировать лаунж"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Редактировать лаунж</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <quest-performance-lounge-form @submit="saveLounge" v-model="performanceLoungeToEdit"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

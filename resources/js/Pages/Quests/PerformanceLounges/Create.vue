<script setup>
import {useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import QuestPerformanceShowForm from "@/Components/Quest/QuestPerformanceShowForm.vue";
import QuestPerformanceLoungeForm from "@/Components/Quest/QuestPerformanceLoungeForm.vue";

const props = defineProps({
    questId: Number
})

const performanceLounge = useForm({
    name_ru: '',
    name_en: '',
    description_ru: '',
    description_en: '',
    advantages_ru: '',
    advantages_en: '',
})

const storeLounge = () => {
    performanceLounge.post(route('quests.quest_performance_lounges.store', props.questId))
}
</script>

<template>
    <Head title="Добавить лаунж к квесту"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Добавить лаунж к квесту</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <quest-performance-lounge-form @submit="storeLounge" v-model="performanceLounge"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

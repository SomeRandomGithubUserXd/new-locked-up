<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import LocationForm from "@/Components/Locations/LocationForm.vue";
import QuestOptionForm from "@/Components/Quest/QuestOptionForm.vue";
import QuestTopicForm from "@/Components/QuestTopics/QuestTopicForm.vue";
import ChildQuestTopicForm from "@/Components/QuestTopics/ChildQuestTopicForm.vue";

const questTopic = useForm({
    'active': true,
    'name_ru': '',
    'name_en': '',
})

const store = () => {
    questTopic.post(route('child-quest-topics.store'), {
        onError: (errs) => {
            console.log(errs)
        }
    })
}
</script>

<template>
    <Head title="Создать детскую рубрику"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Создать детскую рубрику</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <child-quest-topic-form @submit="store" v-model="questTopic"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

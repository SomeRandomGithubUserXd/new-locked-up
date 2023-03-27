<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import LocationForm from "@/Components/Locations/LocationForm.vue";
import QuestOptionForm from "@/Components/Quest/QuestOptionForm.vue";
import QuestTopicForm from "@/Components/QuestTopics/QuestTopicForm.vue";
import ChildQuestTopicForm from "@/Components/QuestTopics/ChildQuestTopicForm.vue";

const questTopic = useForm({
    'active': true,
    'alias': '',
    'og_type': '',
    'og_url': '',
    'name_ru': '',
    'name_en': '',
    'og_title_ru': '',
    'og_title_en': '',
    'og_description_ru': '',
    'og_description_en': '',
    'h1_ru': '',
    'h1_en': '',
    'title_ru': '',
    'title_en': '',
    'seo_ru': '',
    'seo_en': '',
    'description_ru': '',
    'description_en': '',
    'keywords_ru': '',
    'keywords_en': '',
    'position': 0,
})

const store = () => {
    questTopic.post(route('quest-topics.store'), {
        onError: (errs) => {
            console.log(errs)
        }
    })
}
</script>

<template>
    <Head title="Создать рубрику"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Создать рубрику</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <quest-topic-form @submit="store" v-model="questTopic"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

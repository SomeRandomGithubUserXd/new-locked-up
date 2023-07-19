<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import LocationForm from "@/Components/Locations/LocationForm.vue";
import QuestOptionForm from "@/Components/Quest/QuestOptionForm.vue";
import QuestTopicForm from "@/Components/QuestTopics/QuestTopicForm.vue";
import NewsForm from "@/Components/News/NewsForm.vue";

const props = defineProps({
    questList: Array
})

const news = useForm({
    'id' : null,
    'meta_title_ru' : null,
    'meta_title_en' : null,
    'meta_description_ru' : null,
    'meta_description_en' : null,
    'meta_keywords_ru' : null,
    'meta_keywords_en' : null,
    'og_title_ru' : null,
    'og_title_en' : null,
    'og_type' : null,
    'og_description_ru' : null,
    'og_description_en' : null,
    'title_ru' : null,
    'title_en' : null,
    'announce_ru' : null,
    'announce_en' : null,
    'badge_ru' : null,
    'badge_en' : null,
    'h1_ru' : null,
    'h1_en' : null,
    'text_ru' : null,
    'text_en' : null,
    'conditions_header_ru' : null,
    'conditions_header_en' : null,
    'conditions_text_ru' : null,
    'conditions_text_en' : null,
    'book_button_text_ru' : null,
    'book_button_text_en' : null,
    'book_button_link_ru' : null,
    'book_button_link_en' : null,
    'instruction_text_ru' : null,
    'instruction_text_en' : null,
    'seo_text_ru' : null,
    'seo_text_en' : null,
    'quests_title_ru' : null,
    'quests_title_en' : null,
    'quest_ids' : [],
    'alias_ru' : null,
    'alias_en' : null,
    'is_published' : true,
    'quests_attached' : [],
})

const store = () => {
    news.post(route('news.store'), {
        onError: (errs) => {
            alert(Object.keys(errs).map(key => `${errs[key]} \n`))
        }
    })
}
</script>

<template>
    <Head title="Добавить новость"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Добавить новость</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <news-form @submit="store" v-model="news" :quest-list="props.questList"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

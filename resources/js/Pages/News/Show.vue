<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import LocationForm from "@/Components/Locations/LocationForm.vue";
import QuestOptionForm from "@/Components/Quest/QuestOptionForm.vue";
import QuestTopicForm from "@/Components/QuestTopics/QuestTopicForm.vue";
import NewsForm from "@/Components/News/NewsForm.vue";

const props = defineProps({
    news: Object
})

const newsToUpdate = useForm(props.news)

const update = () => {
    newsToUpdate.patch(route('news.update', props.news.id), {
        onError: (errs) => {
            alert(Object.keys(errs).map(key => `${errs[key]} \n`))
        }
    })
}
</script>

<template>
    <Head title="Редактировать новость"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Редактировать новость</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <news-form @submit="update" v-model="newsToUpdate"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import LocationForm from "@/Components/Locations/LocationForm.vue";
import QuestOptionForm from "@/Components/Quest/QuestOptionForm.vue";
import QuestTopicForm from "@/Components/QuestTopics/QuestTopicForm.vue";
import ReviewForm from "@/Components/Reviews/ReviewForm.vue";

const props = defineProps({
    questList: Array
})

const review = useForm({
    'review_date': '',
    'name': '',
    'rate': '',
    'review': '',
    'quest_id': '',
    'is_approved': false,
    'language': ''
})

const store = () => {
    review.post(route('reviews.store'), {
        onError: (errs) => {
            console.log(errs)
        }
    })
}
</script>

<template>
    <Head title="Добавить отзыв"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Добавить отзыв</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <review-form :quest-list="props.questList" @submit="store" v-model="review"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

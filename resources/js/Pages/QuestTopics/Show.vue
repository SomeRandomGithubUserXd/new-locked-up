<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import LocationForm from "@/Components/Locations/LocationForm.vue";
import QuestOptionForm from "@/Components/Quest/QuestOptionForm.vue";
import QuestTopicForm from "@/Components/QuestTopics/QuestTopicForm.vue";

const props = defineProps({
    questTopic: Object
})

const questTopicToUpdate = useForm(props.questTopic)

const update = () => {
    questTopicToUpdate.patch(route('quest-topics.update', props.questTopic), {
        onError: (errs) => {
            console.log(errs)
        }
    })
}
</script>

<template>
    <Head title="Редактировать рубрику"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Редактировать рубрику</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <quest-topic-form @submit="update" v-model="questTopicToUpdate"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

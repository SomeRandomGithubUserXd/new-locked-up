<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import QuestForm from "@/Components/Quest/QuestForm.vue";
import {watch} from "vue";
import {questProps} from "@/Traits/QuestTrait";

const props = defineProps({
    quest: Object,
    ...questProps
})
const questToUpdate = useForm(props.quest)
console.log(props.quest.related_quest_ids)
const submit = () => {
    questToUpdate.patch(route('quests.update', props.quest.id), {
        onError: (err) => {
            console.log(err)
        }
    })
}
</script>

<template>
    <Head title="Редактировать квест"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Редактировать квест</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <quest-form v-model="questToUpdate"
                                    :quest-topics="props.questTopics"
                                    :quest-child-topics="props.questChildTopics"
                                    :difficulty-levels="props.difficultyLevels"
                                    :locations="props.locations"
                                    :schedules="props.schedules"
                                    :checkouts="props.checkouts"
                                    :project-meta="props.projectMeta"
                                    :news-list="props.newsList.data"
                                    :quest-list="props.questList"
                                    :load-list="props.loadList"
                                    :quest-blocks="props.questBlocks"
                                    :sticker-list="props.stickerList"
                                    @submit="submit"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>


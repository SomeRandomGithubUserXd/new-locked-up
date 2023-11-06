<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import QuestForm from "@/Components/Quest/QuestForm.vue";
import {onMounted, ref, watch} from "vue";
import {emptyQuest, questProps} from "@/Traits/QuestTrait";
import axios from "axios";
import {useRouter} from "vue-router";
import {data} from "autoprefixer";

const dataToPreload = ref({
    quest: emptyQuest,
    ...questProps
})

const router = useRouter()

onMounted(() => {
    axios.get(route('quests.show', router.currentRoute.value.params.quest)).then((resp) => {
        dataToPreload.value = resp.data
    })
})

const submit = () => {
    axios.patch(route('quests.update', router.currentRoute.value.params.quest), dataToPreload.value.quest).then((resp) => {
        if (resp.status === 200) router.push({path: '/quests'})
    })
}
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Редактировать квест</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <quest-form v-model="dataToPreload.quest"
                                    :quest-topics="dataToPreload.questTopics"
                                    :quest-child-topics="dataToPreload.questChildTopics"
                                    :difficulty-levels="dataToPreload.difficultyLevels"
                                    :locations="dataToPreload.locations"
                                    :schedules="dataToPreload.schedules"
                                    :checkouts="dataToPreload.checkouts"
                                    :project-meta="dataToPreload.projectMeta"
                                    :news-list="dataToPreload.newsList"
                                    :quest-list="dataToPreload.questList"
                                    :load-list="dataToPreload.loadList"
                                    :quest-blocks="dataToPreload.questBlocks"
                                    :sticker-list="dataToPreload.stickerList"
                                    @submit="submit"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>


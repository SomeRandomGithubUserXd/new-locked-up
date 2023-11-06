<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import QuestForm from "@/Components/Quest/QuestForm.vue";
import {onMounted, ref, watch} from "vue";
import {emptyQuest, questProps} from "@/Traits/QuestTrait";
import {useRouter} from "vue-router";

const router = useRouter()

const dataToPreload = ref(questProps)

const quest = ref(emptyQuest)

onMounted(() => {
    axios.get(route('quests.create')).then((resp) => {
        dataToPreload.value = resp.data
    })
})

const store = () => {
    axios.post(route('quests.store'), quest.value).catch((err) => {
        alert(err.response.data.message)
    }).then((resp) => {
        if (resp.status === 200) router.push({path: '/quests'})
    })
}

watch(dataToPreload, () => {}, {deep: true})
watch(quest, () => {}, {deep: true})
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Добавить квест</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <quest-form v-model="quest"
                                    @submit="store"
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
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>


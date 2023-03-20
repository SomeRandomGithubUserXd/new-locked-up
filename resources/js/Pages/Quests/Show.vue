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

console.log(props.quest)

const quest = useForm(props.quest)
</script>

<template>
    <Head title="Добавить квест"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Добавить квест</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <quest-form v-model="quest"
                                    :themes="props.projectMeta.themes"
                                    :news-list="props.newsList.data"
                                    :quest-list="props.questList"
                                    :quest-blocks="props.questBlocks"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>


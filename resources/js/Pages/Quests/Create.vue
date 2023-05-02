<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import QuestForm from "@/Components/Quest/QuestForm.vue";
import {watch} from "vue";
import {questProps} from "@/Traits/QuestTrait";

const props = defineProps(questProps)

const quest = useForm({
    ord: 0,
    color: '#ffffff',
    checkout_id: null,
    theme: 0,
    name_ru: '',
    name_en: '',
    h1_ru: '',
    h1_en: '',
    short_description_ru: '',
    short_description_en: '',
    related_quest_ids: [],
    block_id: null,
    show_at_home: false,
    is_popular: false,
    is_for_children: false,
    show_at_kids_celebration: false,
    show_at_corporate_parties: false,
    enabled: true,
    price_per_additional_player: 0,
    team_price: 0,
    discount_percent: 0,
    mins_until_slot_is_closed: 1200,
    duration: 120,
    age_limit: 6,
    age_restriction: null,
    min_players: 1,
    max_players: null,
    min_players_free: 1,
    max_players_free: null,
    located_near_subway_station: '',
    genre: '',
    rating: 10,
    advantages: [],
    options: [],
    options_block_header: '',
    options_block_subheading: '',
    applied_sales: [],
    you_may_like_it_section_header: '',
    you_may_like_it_section_subheading: '',
    you_may_like_it_section_quest_ids: [],
    schedule_blocks_section_header: '',
    schedule_blocks_section_text: '',
    schedule_section_blocks_bottom_text: '',
    schedule_id: null,
    location_id: null,
    difficulty: null,
    quest_topic_ids: [],
    quest_child_topic_ids: [],
    loads: [],
    sticker_id: null,
})

const store = () => {
    quest.post(route('quests.store'), {
        onError: (err) => {
            console.log(err)
        }
    })
}
</script>

<template>
    <Head title="Добавить квест"/>

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
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>


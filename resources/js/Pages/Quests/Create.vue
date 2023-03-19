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
    name_ru: '',
    name_en: '',
    h1_ru: '',
    h1_en: '',
    short_description_ru: '',
    short_description_en: '',
    related_quests: [],
    block_id: null,
    needs_to_be_shown_at_home: false,
    is_popular: false,
    is_for_children: false,
    needs_to_be_shown_at_kids_celebration: false,
    needs_to_be_shown_at_kids_corporate_parties: false,
    enabled: true,
    price_per_additional_player: 0,
    team_price: 0,
    discount_percent: 0,
    mins_until_slot_is_closed: 1200,
    duration: 120,
    age_limit: 6,
    min_players: 1,
    max_players: null,
    min_players_free: 1,
    max_players_free: null,
    locates_near_subway_station: '',
    genre: '',
    rating: 10,
    advantages: [],
    options: [],
    options_block_header: '',
    options_block_subheading: '',
    applied_sales: [],
    you_may_like_it_section_header: '',
    you_may_like_it_section_subheading: '',
    you_may_like_it_section_quests: [],
    schedule_blocks_section_header: '',
    schedule_blocks_section_text: '',
    schedule_section_blocks_bottom_text: '',
    checkout_id: null,
})
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
                                    :checkouts="props.checkouts"
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


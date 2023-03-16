<script setup>
import {computed, reactive, ref, watch} from "vue";
import {useForm} from "@inertiajs/vue3";
import ExpandableBlock from "@/Components/Common/ExpandableBlock.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import SwitchLangGroup from "@/Components/Quest/SwitchLangGroup.vue";
import Editor from '@tinymce/tinymce-vue'
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
import Checkbox from "@/Components/Checkbox.vue";
import QuestAdvantageForm from "@/Components/Quest/QuestAdvantageForm.vue";

const props = defineProps({
    modelValue: {
        required: true,
        default: useForm({})
    },
    questList: Array,
    questBlocks: Array,
})

const blocks = reactive({
    namingAndImages: false,
    quests: false,
    priceAndPlayers: false,
    about: false,
})

const locale = ref('ru')

const localePointers = {
    name: {
        ru: 'name_ru',
        en: 'name_en',
    },
    h1: {
        ru: 'h1_ru',
        en: 'h1_en',
    },
    short_description: {
        ru: 'short_description_ru',
        en: 'short_description_en',
    },
    full_description: {
        ru: 'full_description_ru',
        en: 'full_description_en',
    },
}

const emit = defineEmits(['submit'])

const addAdvantage = () => {
    props.modelValue.advantages.push({
        imageSrc: '',
        header: '',
        shortDescription: '',
    })
}

const removeAdvantage = (item) => {
    props.modelValue.advantages.splice(props.modelValue.advantages.indexOf(item), 1)
}
</script>

<template>
    <form @submit.prevent="emit('submit')">
        <expandable-block v-model="blocks.namingAndImages">
            <template #header>
                <switch-lang-group class="mr-3" v-model="locale" @click.stop/>
                <h2 class="text-lg font-semibold">Описание и изображения</h2>
            </template>
            <template #content>
                <div class="grid grid-cols-6 gap-6 w-full">
                    <div class="col-span-6 sm:col-span-3">
                        <InputLabel for="name" :value="`Название (${locale})`"/>
                        <TextInput
                            id="name"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="modelValue[localePointers['name'][locale]]"

                            autofocus
                        />
                        <InputError class="mt-2" :message="modelValue.errors[localePointers['name'][locale]]"/>
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <InputLabel for="h1" :value="`Заголовок H1 (${locale})`"/>
                        <TextInput
                            id="h1"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="modelValue[localePointers['h1'][locale]]"

                        />
                        <InputError class="mt-2" :message="modelValue.errors[localePointers['h1'][locale]]"/>
                    </div>
                    <div class="col-span-6 sm:col-span-6">
                        <InputLabel for="short_description" :value="`Краткое описание (${locale})`"/>
                        <div class="mt-1">
                            <textarea
                                id="short_description"
                                v-model="modelValue[localePointers['short_description'][locale]]"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </textarea>
                        </div>
                        <InputError class="mt-2"
                                    :message="modelValue.errors[localePointers['short_description'][locale]]"/>
                    </div>
                    <div class="col-span-6 sm:col-span-6">
                        <InputLabel for="full_description" :value="`Полное описание (${locale})`"/>
                        <div class="mt-1">
                            <Editor
                                id="full_description"
                                lang="ru"
                                v-model="modelValue[localePointers['full_description'][locale]]"
                                api-key="no-api-key"
                            />
                        </div>
                        <InputError class="mt-2"
                                    :message="modelValue.errors[localePointers['full_description'][locale]]"/>
                    </div>
                </div>
            </template>
        </expandable-block>
        <expandable-block class="mt-3" v-model="blocks.quests">
            <template #header>
                <h2 class="text-lg font-semibold">Связанные квесты</h2>
            </template>
            <template #content>
                <div class="grid grid-cols-6 gap-6 w-full">
                    <div class="col-span-6 sm:col-span-6">
                        <label for="options" class="block text-sm font-medium text-gray-700"> Связанные квесты </label>
                        <a class="text-indigo-600 text-sm" href="#" @click.prevent="modelValue.related_quests = []">Очистить</a>
                        <div class="mt-1">
                            <v-select v-model="modelValue.related_quests" multiple="" label="name_ru"
                                      :options="props.questList">
                                <template v-slot:option="option">
                                    {{ option.name_ru }}
                                </template>
                            </v-select>
                        </div>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <label for="block_id" class="block text-sm font-medium text-gray-700"> Группа квестов на
                            главной</label>
                        <div class="mt-1">
                            <select
                                id="block_id"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                v-model="modelValue.block_id">
                                <option :value="option.id" v-for="option in props.questBlocks">
                                    {{ option.name_ru }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-6 gap-6 col-span-6 sm:col-span-4">
                        <div class="col-span-6 sm:col-span-2">
                            <label for="needs_to_be_shown_at_home" class="flex items-center">
                                <Checkbox id="needs_to_be_shown_at_home"
                                          v-model:checked="modelValue.needs_to_be_shown_at_home"/>
                                <span class="ml-2 text-sm text-gray-600">Выводить на главной</span>
                            </label>
                            <label for="is_popular" class="flex items-center mt-2">
                                <Checkbox id="is_popular" v-model:checked="modelValue.is_popular"/>
                                <span class="ml-2 text-sm text-gray-600">Популярный квест</span>
                            </label>
                            <label for="is_for_children" class="flex items-center mt-2">
                                <Checkbox id="is_for_children" v-model:checked="modelValue.is_for_children"/>
                                <span class="ml-2 text-sm text-gray-600">Детский квест</span>
                            </label>
                        </div>
                        <div class="col-span-6 sm:col-span-2">
                            <label for="needs_to_be_shown_at_kids_celebration" class="flex items-center mt-2">
                                <Checkbox id="needs_to_be_shown_at_kids_celebration"
                                          v-model:checked="modelValue.needs_to_be_shown_at_kids_celebration"/>
                                <span class="ml-2 text-sm text-gray-600">Выводить на странице Детские праздники</span>
                            </label>
                            <label for="needs_to_be_shown_at_kids_corporate_parties" class="flex items-center mt-2">
                                <Checkbox id="needs_to_be_shown_at_kids_corporate_parties"
                                          v-model:checked="modelValue.needs_to_be_shown_at_kids_corporate_parties"/>
                                <span class="ml-2 text-sm text-gray-600">Выводить на странице Корпоративы</span>
                            </label>
                            <label for="enabled" class="flex items-center mt-2">
                                <Checkbox id="enabled" v-model:checked="modelValue.enabled"/>
                                <span class="ml-2 text-sm text-gray-600">Доступен для вывода на сайте</span>
                            </label>
                        </div>
                        <div class="col-span-6 sm:col-span-2">
                            <label for="is_performance_art" class="flex items-center mt-2">
                                <Checkbox id="is_performance_art" v-model:checked="modelValue.is_performance_art"/>
                                <span class="ml-2 text-sm text-gray-600">Перформанс</span>
                            </label>
                        </div>
                    </div>
                </div>
            </template>
        </expandable-block>
        <expandable-block class="mt-3" v-model="blocks.priceAndPlayers">
            <template #header>
                <h2 class="text-lg font-semibold">Цены и игроки</h2>
            </template>
            <template #content>
                <div class="grid grid-cols-6 gap-6 w-full">
                    <div class="col-span-6 sm:col-span-2">
                        <InputLabel for="price_per_additional_player" value="Цена за дополнительного игрока"/>
                        <TextInput
                            id="price_per_additional_player"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="modelValue.price_per_additional_player"

                        />
                        <InputError class="mt-2" :message="modelValue.errors.price_per_additional_player"/>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <InputLabel for="team_price" value="Цена за команду"/>
                        <TextInput
                            id="team_price"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="modelValue.team_price"

                        />
                        <InputError class="mt-2" :message="modelValue.errors.team_price"/>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <InputLabel for="discount_percent" value="Скидка (%)"/>
                        <TextInput
                            id="discount_percent"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="modelValue.discount_percent"

                        />
                        <InputError class="mt-2" :message="modelValue.errors.discount_percent"/>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <InputLabel for="mins_until_slot_is_closed" value="Время до закрытия слота (мин.)"/>
                        <TextInput
                            id="mins_until_slot_is_closed"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="modelValue.mins_until_slot_is_closed"

                        />
                        <InputError class="mt-2" :message="modelValue.errors.mins_until_slot_is_closed"/>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <InputLabel for="duration" value="Продолжительность (мин.)"/>
                        <TextInput
                            id="duration"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="modelValue.duration"

                        />
                        <InputError class="mt-2" :message="modelValue.errors.duration"/>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <InputLabel for="age_limit" value="Ограничение по возрасту"/>
                        <TextInput
                            id="age_limit"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="modelValue.age_limit"

                        />
                        <InputError class="mt-2" :message="modelValue.errors.age_limit"/>
                    </div>
                    <div class="col-span-6 sm:col-span-1">
                        <InputLabel for="min_players" value="Количество игроков (мин.)"/>
                        <TextInput
                            id="min_players"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="modelValue.min_players"

                        />
                        <InputError class="mt-2" :message="modelValue.errors.min_players"/>
                    </div>
                    <div class="col-span-6 sm:col-span-1">
                        <InputLabel for="max_players" value="Количество игроков (макс.)"/>
                        <TextInput
                            id="max_players"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="modelValue.max_players"

                        />
                        <InputError class="mt-2" :message="modelValue.errors.max_players"/>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <InputLabel for="min_players_free" value="Количество игроков в форме бронирования (мин.)"/>
                        <TextInput
                            id="min_players_free"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="modelValue.min_players_free"

                        />
                        <InputError class="mt-2" :message="modelValue.errors.max_players"/>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <InputLabel for="max_players_free" value="Количество игроков в форме бронирования (макс.)"/>
                        <TextInput
                            id="max_players_free"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="modelValue.max_players_free"

                        />
                        <InputError class="mt-2" :message="modelValue.errors.max_players_free"/>
                    </div>
                </div>
            </template>
        </expandable-block>
        <expandable-block class="mt-3" v-model="blocks.about">
            <template #header>
                <h2 class="text-lg font-semibold">Подробнее</h2>
            </template>
            <template #content>
                <div class="grid grid-cols-6 gap-6 w-full">
                    <div class="col-span-6 sm:col-span-1">
                        <InputLabel for="locates_near_subway_station" value="Метро"/>
                        <TextInput
                            id="locates_near_subway_station"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="modelValue.locates_near_subway_station"

                        />
                        <InputError class="mt-2" :message="modelValue.errors.locates_near_subway_station"/>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <InputLabel for="genre" value="Жанр"/>
                        <TextInput
                            id="genre"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="modelValue.genre"

                        />
                        <InputError class="mt-2" :message="modelValue.errors.genre"/>
                    </div>
                    <div class="col-span-6 sm:col-span-1">
                        <InputLabel for="rating" value="Рейтинг"/>
                        <TextInput
                            id="rating"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="modelValue.rating"

                        />
                        <InputError class="mt-2" :message="modelValue.errors.rating"/>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <InputLabel for="video_src" value="Ссылка на видео"/>
                        <TextInput
                            id="video_src"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="modelValue.video_src"

                        />
                        <InputError class="mt-2" :message="modelValue.errors.video_src"/>
                    </div>
                </div>
            </template>
        </expandable-block>
        <expandable-block class="mt-3" v-model="blocks.advantages">
            <template #header>
                <h2 class="text-lg font-semibold">Преимущества</h2>
            </template>
            <template #content>
                <div class="flex flex-col w-full">
                    <button @click="addAdvantage" type="submit"
                            class="w-full flex justify-center mb-5 py-2 px-4 border border-transparent rounded-md shadow-xl text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600">
                        Добавить преимущество
                    </button>
                    <div class="grid grid-cols-6 gap-6 w-full">
                        <quest-advantage-form
                            @remove="removeAdvantage"
                            class="col-span-6 sm:col-span-3"
                            v-model="modelValue.advantages[key]"
                            v-for="(advantage, key) in modelValue.advantages"/>
                    </div>
                </div>
            </template>
        </expandable-block>
        <div class="shadow-2xl bg-white rounded-xl sticky bottom-1 z-40 mt-5 p-3">
            <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-xl text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Сохранить
            </button>
        </div>
    </form>
</template>

<!--тема, касса, ord, цвет-->

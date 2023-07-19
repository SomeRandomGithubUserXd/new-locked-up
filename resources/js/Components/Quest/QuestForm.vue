<script setup>
import {computed, onMounted, reactive, ref, watch} from "vue";
import {getAttribute as getAttributeInstance} from "@/Traits/LocaleTrait";
import {router, useForm} from "@inertiajs/vue3";
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
import QuestOptionForm from "@/Components/Quest/QuestOptionForm.vue";
import DataTable from "@/Components/Common/DataTable.vue";
import Tabs from "@/Components/Common/Tabs.vue";
import {questProps} from "@/Traits/QuestTrait";

const props = defineProps({
    modelValue: {
        required: true,
        default: useForm({})
    },
    ...questProps
})

const blocks = reactive({
    main: true,
    namingAndImages: false,
    quests: false,
    priceAndPlayers: false,
    about: false,
    advantages: false,
    options: false,
    sales: false,
    youMayLikeSection: false,
    scheduleTextBlocks: false,
    performanceShowMisc: false,
})

const locale = ref('ru')

const getAttribute = (name) => {
    return getAttributeInstance(name, locale.value)
}

const emit = defineEmits(['submit'])

const addAdvantage = () => {
    props.modelValue.advantages.push({
        // imageSrc: '',
        header: '',
        shortDescription: '',
    })
}

const addOption = () => {
    props.modelValue.options.push({
        // imageSrc: '',
        header: '',
        subheading: '',
    })
}

const removeAdvantage = (item) => {
    props.modelValue.advantages.splice(props.modelValue.advantages.indexOf(item), 1)
}

const removeOption = (item) => {
    props.modelValue.options.splice(props.modelValue.options.indexOf(item), 1)
}
const tabsArray = [
    {
        name: 'Основное',
        value: 'main'
    },
    {
        name: 'Расписание',
        value: 'schedule'
    },
    {
        name: 'Фильтры',
        value: 'filters'
    },
    {
        name: 'Отзывы',
        value: 'reviews'
    },
    {
        name: 'Фотографии',
        value: 'photos'
    },
    {
        name: 'CEO',
        value: 'CEO'
    },
    {
        name: 'Сниппеты',
        value: 'snippets'
    },
]

const performanceShowTableProps = ref({
    records: [
        {
            name: 'Название',
            getValue: (item) => {
                return item.name_ru || 'Нет'
            },
        },
    ],
    actions: [
        {
            name: 'Редактировать',
            trigger: (item) => {
                router.get(route('quests.quest_performance_shows.show', {
                    quest_performance_show: item.id,
                    quest: props.modelValue.id
                }))
            },
        },
        {
            name: 'Удалить',
            trigger: (item) => {
                router.delete(route('quests.quest_performance_shows.destroy', {
                    quest_performance_show: item.id,
                    quest: props.modelValue.id
                }))
            },
        }
    ],
    pagination: {
        isRequired: false,
    }
})

const performanceLoadsTableProps = ref({
    records: [
        {
            name: 'Название',
            getValue: (item) => {
                return item.name_ru || 'Нет'
            },
        },
    ],
    actions: [
        {
            name: 'Редактировать',
            trigger: (item) => {
                router.get(route('quests.quest_performance_loads.show', {
                    quest_performance_load: item.id,
                    quest: props.modelValue.id
                }))
            },
        },
        {
            name: 'Удалить',
            trigger: (item) => {
                router.delete(route('quests.quest_performance_loads.destroy', {
                    quest_performance_load: item.id,
                    quest: props.modelValue.id
                }))
            },
        }
    ],
    pagination: {
        isRequired: false,
    }
})

const performanceExperimentsTableProps = ref({
    records: [
        {
            name: 'Название',
            getValue: (item) => {
                return item.name_ru || 'Нет'
            },
        },
    ],
    actions: [
        {
            name: 'Редактировать',
            trigger: (item) => {
                router.get(route('quests.quest_performance_experiments.show', {
                    quest_performance_experiment: item.id,
                    quest: props.modelValue.id
                }))
            },
        },
        {
            name: 'Удалить',
            trigger: (item) => {
                router.delete(route('quests.quest_performance_experiments.destroy', {
                    quest_performance_experiment: item.id,
                    quest: props.modelValue.id
                }))
            },
        }
    ],
    pagination: {
        isRequired: false,
    }
})

const performanceLoungesTableProps = ref({
    records: [
        {
            name: 'Название',
            getValue: (item) => {
                return item.name_ru || 'Нет'
            },
        },
    ],
    actions: [
        {
            name: 'Редактировать',
            trigger: (item) => {
                router.get(route('quests.quest_performance_lounges.show', {
                    quest_performance_lounge: item.id,
                    quest: props.modelValue.id
                }))
            },
        },
        {
            name: 'Удалить',
            trigger: (item) => {
                router.delete(route('quests.quest_performance_lounges.destroy', {
                    quest_performance_lounge: item.id,
                    quest: props.modelValue.id
                }))
            },
        }
    ],
    pagination: {
        isRequired: false,
    }
})

const currentTab = ref(tabsArray[0])

const scheduleItems = ref([])

const scheduleItemTableProps = computed({
    get: () => {
        return {
            records: [
                {
                    name: 'Время',
                    getValue: (item) => {
                        return item.time || 'Нет'
                    },
                },
                {
                    name: 'Стоимость',
                    getValue: (item) => {
                        return item.price || 'Нет'
                    },
                },
                {
                    name: 'Тип',
                    getValue: (item) => {
                        return item.type || 'Нет'
                    },
                },
            ],
            pagination: {
                isRequired: false,
            }
        }
    },
    set: () => {
    },
})

onMounted(() => {
    if (props.modelValue.schedule_id) {
        loadScheduleItems(props.modelValue.schedule_id)
    }
})

const loadScheduleItems = (val) => {
    axios.get(route('schedule-items.index', val)).then((resp) => {
        scheduleItems.value = resp.data
    })
}

watch(() => props.modelValue.schedule_id, async (val) => {
    loadScheduleItems(val)
})

watch(() => props.modelValue.errors, async (val) => {
    alert(val[Object.keys(val)[0]])
})


</script>

<template>
    <form @submit.prevent="emit('submit')">
        <tabs class="mb-5" :tabs="tabsArray" v-model="currentTab"/>
        <div v-if="currentTab.value === 'main'">
            <expandable-block v-model="blocks.main">
                <template #header>
                    <h2 class="text-lg font-semibold">Основное</h2>
                </template>
                <template #content>
                    <!--доп услуги, доп почты-->
                    <div class="grid grid-cols-6 gap-6 w-full">
                        <div class="col-span-6 sm:col-span-1">
                            <label for="ord" class="block text-sm font-medium text-gray-700">Порядковый номер</label>
                            <TextInput
                                id="ord"
                                type="number"
                                class="mt-1 block w-full"
                                v-model="modelValue.ord"
                            />
                        </div>
<!--                        <div class="col-span-6 sm:col-span-1">-->
<!--                            <label for="color" class="block text-sm font-medium text-gray-700">Цвет</label>-->
<!--                            <TextInput-->
<!--                                id="color"-->
<!--                                type="color"-->
<!--                                class="mt-1 block w-full"-->
<!--                                v-model="modelValue.color"-->
<!--                            />-->
<!--                        </div>-->
                        <div class="col-span-6 sm:col-span-1">
                            <label for="theme" class="block text-sm font-medium text-gray-700">Тема</label>
                            <div class="mt-1">
                                <select
                                    id="theme"
                                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    v-model="modelValue.theme">
                                    <option :value="theme.key" v-for="theme in props.projectMeta.themes">
                                        {{ theme.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-1">
                            <label for="checkout_id" class="block text-sm font-medium text-gray-700">Касса</label>
                            <div class="mt-1">
                                <select
                                    id="checkout_id"
                                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    v-model="modelValue.checkout_id">
                                    <option :value="option.id" v-for="option in props.checkouts">
                                        {{ option.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </template>
            </expandable-block>
            <expandable-block v-model="blocks.namingAndImages" class="mt-3">
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
                                v-model="modelValue[getAttribute('name')]"
                                autofocus
                            />
                            <InputError class="mt-2" :message="modelValue.errors[getAttribute('name')]"/>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <InputLabel for="h1" :value="`Заголовок H1 (${locale})`"/>
                            <TextInput
                                id="h1"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="modelValue[getAttribute('h1')]"

                            />
                            <InputError class="mt-2" :message="modelValue.errors[getAttribute('h1')]"/>
                        </div>
                        <div class="col-span-6 sm:col-span-6">
                            <InputLabel for="short_description" :value="`Краткое описание (${locale})`"/>
                            <div class="mt-1">
                            <textarea
                                id="short_description"
                                v-model="modelValue[getAttribute('short_description')]"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </textarea>
                            </div>
                            <InputError class="mt-2"
                                        :message="modelValue.errors[getAttribute('short_description')]"/>
                        </div>
                        <div class="col-span-6 sm:col-span-6">
                            <InputLabel for="full_description" :value="`Полное описание (${locale})`"/>
                            <div class="mt-1">
                                <Editor
                                    id="full_description"
                                    lang="ru"
                                    v-model="modelValue[getAttribute('full_description')]"
                                    api-key="no-api-key"
                                />
                            </div>
                            <InputError class="mt-2"
                                        :message="modelValue.errors[getAttribute('full_description')]"/>
                        </div>
                        <div class="col-span-6 sm:col-span-2">
                            <input-label for="file" value="Баннер (1920х790px)"/>
                            <input
                                id="file"
                                type="file"
                            />
                        </div>
                        <div class="col-span-6 sm:col-span-2">
                            <input-label for="file" value="Баннер моб. (480х480px)"/>
                            <input
                                id="file"
                                type="file"
                            />
                        </div>
                        <div class="col-span-6 sm:col-span-2">
                            <input-label for="file" value="Превью баннера (520х445px)"/>
                            <input
                                id="file"
                                type="file"
                            />
                        </div>
                        <div class="col-span-6 sm:col-span-2">
                            <input-label for="file" value="Превью расписания (165х130px)"/>
                            <input
                                id="file"
                                type="file"
                            />
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
                            <label for="options" class="block text-sm font-medium text-gray-700"> Связанные
                                квесты </label>
                            <a class="text-indigo-600 text-sm" href="#"
                               @click.prevent="modelValue.related_quest_ids = []">Очистить</a>
                            <div class="mt-1">
                                <v-select v-model="modelValue.related_quest_ids" multiple=""
                                          :reduce="option => option.id"
                                          label="name_ru"
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
                                <label for="show_at_home" class="flex items-center">
                                    <Checkbox id="show_at_home"
                                              v-model:checked="modelValue.show_at_home"/>
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
                                <label for="show_at_kids_celebration" class="flex items-center mt-2">
                                    <Checkbox id="show_at_kids_celebration"
                                              v-model:checked="modelValue.show_at_kids_celebration"/>
                                    <span
                                        class="ml-2 text-sm text-gray-600">Выводить на странице Детские праздники</span>
                                </label>
                                <label for="show_at_corporate_parties" class="flex items-center mt-2">
                                    <Checkbox id="show_at_corporate_parties"
                                              v-model:checked="modelValue.show_at_corporate_parties"/>
                                    <span class="ml-2 text-sm text-gray-600">Выводить на странице Корпоративы</span>
                                </label>
                                <label for="is_enabled" class="flex items-center mt-2">
                                    <Checkbox id="is_enabled" v-model:checked="modelValue.is_enabled"/>
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
                            <InputLabel for="located_near_subway_station" value="Метро"/>
                            <TextInput
                                id="located_near_subway_station"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="modelValue.located_near_subway_station"

                            />
                            <InputError class="mt-2" :message="modelValue.errors.located_near_subway_station"/>
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
                            <InputLabel step="0.01" for="rating" value="Рейтинг"/>
                            <TextInput
                                id="rating"
                                type="number"
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
                        <button @click="addAdvantage" type="button"
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
            <expandable-block class="mt-3" v-model="blocks.options">
                <template #header>
                    <h2 class="text-lg font-semibold">Блок опций</h2>
                </template>
                <template #content>
                    <div class="grid grid-cols-6 gap-6 w-full">
                        <div class="col-span-6 sm:col-span-1">
                            <InputLabel for="options_block_header" value="Заголовок"/>
                            <TextInput
                                id="options_block_header"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="modelValue.options_block_header"
                            />
                            <InputError class="mt-2" :message="modelValue.errors.options_block_header"/>
                        </div>
                        <div class="col-span-6 sm:col-span-6">
                            <InputLabel for="options_block_subheading" value="Подзаголовок"/>
                            <textarea
                                id="options_block_subheading"
                                v-model="modelValue.options_block_subheading"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </textarea>
                            <InputError class="mt-2" :message="modelValue.errors.options_block_subheading"/>
                        </div>
                        <div class="col-span-6 sm:col-span-6">
                            <div class="flex flex-col w-full">
                                <button @click="addOption" type="button"
                                        class="w-full flex justify-center mb-5 py-2 px-4 border border-transparent rounded-md shadow-xl text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600">
                                    Добавить опцию
                                </button>
                                <div class="grid grid-cols-6 gap-6 w-full">
                                    <quest-option-form
                                        @remove="removeOption"
                                        class="col-span-6 sm:col-span-3"
                                        v-model="modelValue.options[key]"
                                        v-for="(option, key) in modelValue.options"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </expandable-block>
            <expandable-block class="mt-3" v-model="blocks.loads">
                <template #header>
                    <h2 class="text-lg font-semibold">Пакеты</h2>
                </template>
                <template #content>
                    <div class="grid grid-cols-6 gap-6 w-full">
                        <div class="col-span-6 sm:col-span-6">
                            <a class="text-indigo-600 text-sm" href="#"
                               @click.prevent="modelValue.loads = []">Очистить</a>
                            <div class="mt-1">
                                <v-select class="scrollable-select" v-model="modelValue.loads"
                                          multiple=""
                                          label="title_fdp_ru"
                                          :reduce="option => option.id"
                                          :options="props.loadList"/>
                            </div>
                            <InputError class="mt-2" :message="modelValue.errors.loads"/>
                        </div>
                    </div>
                </template>
            </expandable-block>
            <expandable-block class="mt-3" v-model="blocks.sales">
                <template #header>
                    <h2 class="text-lg font-semibold">Акции</h2>
                </template>
                <template #content>
                    <div class="grid grid-cols-6 gap-6 w-full">
                        <div class="col-span-6 sm:col-span-1">
                            <InputLabel for="sales_block_header" value="Заголовок"/>
                            <TextInput
                                id="sales_block_header"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="modelValue.sales_block_header"
                            />
                            <InputError class="mt-2" :message="modelValue.errors.sales_block_header"/>
                        </div>
                        <div class="col-span-6 sm:col-span-6">
                            <InputLabel for="sales_block_subheading" value="Подзаголовок"/>
                            <textarea
                                id="options_block_subheading"
                                v-model="modelValue.sales_block_subheading"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </textarea>
                            <InputError class="mt-2" :message="modelValue.errors.sales_block_subheading"/>
                        </div>
                        <div class="col-span-6 sm:col-span-6">
                            <InputLabel for="sales" value="Список акций"/>
                            <a class="text-indigo-600 text-sm" href="#" @click.prevent="modelValue.applied_sales = []">Очистить</a>
                            <div class="mt-1">
                                <v-select class="scrollable-select" v-model="modelValue.applied_sales"
                                          multiple=""
                                          label="title_ru"
                                          :reduce="option => option.id"
                                          :options="props.newsList"/>
                            </div>
                            <InputError class="mt-2" :message="modelValue.errors.applied_sales"/>
                        </div>
                    </div>
                </template>
            </expandable-block>
            <expandable-block class="mt-3" v-model="blocks.youMayLikeSection">
                <template #header>
                    <h2 class="text-lg font-semibold">"Вам может понравиться"</h2>
                </template>
                <template #content>
                    <div class="grid grid-cols-6 gap-6 w-full">
                        <div class="col-span-6 sm:col-span-1">
                            <InputLabel for="you_may_like_it_section_header" value="Заголовок"/>
                            <TextInput
                                id="you_may_like_it_section_header"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="modelValue.you_may_like_it_section_header"
                            />
                            <InputError class="mt-2" :message="modelValue.errors.you_may_like_it_section_header"/>
                        </div>
                        <div class="col-span-6 sm:col-span-6">
                            <InputLabel for="you_may_like_it_section_subheading" value="Подзаголовок"/>
                            <textarea
                                id="you_may_like_it_section_subheading"
                                v-model="modelValue.you_may_like_it_section_subheading"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </textarea>
                            <InputError class="mt-2" :message="modelValue.errors.you_may_like_it_section_subheading"/>
                        </div>
                        <div class="col-span-6 sm:col-span-6">
                            <InputLabel for="you_may_like_it_section_quest_ids" value="Отображаемые квесты"/>
                            <a class="text-indigo-600 text-sm" href="#"
                               @click.prevent="modelValue.you_may_like_it_section_quest_ids = []">Очистить</a>
                            <div class="mt-1">
                                <v-select class="scrollable-select"
                                          v-model="modelValue.you_may_like_it_section_quest_ids"
                                          multiple
                                          id="you_may_like_it_section_quest_ids"
                                          label="name_ru"
                                          :reduce="option => option.id"
                                          :options="props.questList"/>
                            </div>
                            <InputError class="mt-2" :message="modelValue.errors.you_may_like_it_section_quest_ids"/>
                        </div>
                    </div>
                </template>
            </expandable-block>
            <expandable-block class="mt-3" v-model="blocks.scheduleTextBlocks">
                <template #header>
                    <h2 class="text-lg font-semibold">Текстовые блоки возле расписания</h2>
                </template>
                <template #content>
                    <div class="grid grid-cols-6 gap-6 w-full">
                        <div class="col-span-6 sm:col-span-1">
                            <InputLabel for="schedule_blocks_section_header" value="Заголовок блока возле расписания"/>
                            <TextInput
                                id="schedule_blocks_section_header"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="modelValue.schedule_blocks_section_header"
                            />
                            <InputError class="mt-2" :message="modelValue.errors.schedule_blocks_section_header"/>
                        </div>
                        <div class="col-span-6 sm:col-span-6">
                            <InputLabel for="schedule_blocks_section_text" value="Текст блока над расписанием"/>
                            <textarea
                                id="schedule_text_blocks_section_text"
                                v-model="modelValue.schedule_blocks_section_text"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </textarea>
                            <InputError class="mt-2" :message="modelValue.errors.schedule_blocks_section_text"/>
                        </div>
                        <div class="col-span-6 sm:col-span-6">
                            <InputLabel for="schedule_section_blocks_bottom_text" value="Текст блока под расписанием"/>
                            <textarea
                                id="schedule_section_blocks_bottom_text"
                                v-model="modelValue.schedule_section_blocks_bottom_text"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </textarea>
                            <InputError class="mt-2" :message="modelValue.errors.schedule_section_blocks_bottom_text"/>
                        </div>
                    </div>
                </template>
            </expandable-block>
            <expandable-block class="mt-3" v-if="modelValue.is_performance_art" v-model="blocks.performanceShowMisc">
                <template #header>
                    <h2 class="text-lg font-semibold">Прочее для квеста-спектакля</h2>
                </template>
                <template #content>
                    <div class="grid grid-cols-6 gap-6 w-full">
                        <div class="col-span-6 sm:col-span-6">
                            <h2 class="font-medium text-xl">Блок шоу</h2>
                            <InputLabel value="Шоу"/>
                            <data-table :create-link="route('quests.quest_performance_shows.create', props.modelValue.id)"
                                        :table-props="performanceShowTableProps"
                                        :needs-selection="false"
                                        class="mt-3"
                                        :raw-data="modelValue.quest_performance_shows"/>
                        </div>
                        <div class="col-span-6 sm:col-span-6">
                            <h2 class="font-medium text-xl">Блок пакетов</h2>
                            <InputLabel for="packages_description" :value="`Описание (${locale})`"/>
                            <div class="mt-1">
                            <textarea
                                id="packages_description"
                                v-model="modelValue[getAttribute('packages_description')]"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </textarea>
                            </div>
                            <InputError class="mt-2"
                                        :message="modelValue.errors[getAttribute('packages_description')]"/>
                        </div>
                        <div class="col-span-6 sm:col-span-6">
                            <InputLabel for="packages_example" :value="`Пример расчета (${locale})`"/>
                            <div class="mt-1">
                            <textarea
                                id="packages_example"
                                v-model="modelValue[getAttribute('packages_example')]"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </textarea>
                            </div>
                            <InputError class="mt-2"
                                        :message="modelValue.errors[getAttribute('packages_example')]"/>
                        </div>
                        <div class="col-span-6 sm:col-span-6">
                            <InputLabel value="Пакеты"/>
                            <data-table :create-link="route('quests.quest_performance_loads.create', props.modelValue.id)"
                                        :table-props="performanceLoadsTableProps"
                                        :needs-selection="false"
                                        class="mt-3"
                                        :raw-data="modelValue.quest_performance_loads"/>
                        </div>
                        <div class="col-span-6 sm:col-span-6">
                            <h2 class="font-medium text-xl">Блок экспериментов</h2>
                            <InputLabel value="Эксперименты"/>
                            <data-table :create-link="route('quests.quest_performance_experiments.create', props.modelValue.id)"
                                        :table-props="performanceExperimentsTableProps"
                                        :needs-selection="false"
                                        class="mt-3"
                                        :raw-data="modelValue.quest_performance_experiments"/>
                        </div>
                        <div class="col-span-6 sm:col-span-6">
                            <h2 class="font-medium text-xl">Блок лаунжей</h2>
                            <InputLabel value="Лаунжи"/>
                            <data-table :create-link="route('quests.quest_performance_lounges.create', props.modelValue.id)"
                                        :table-props="performanceLoungesTableProps"
                                        :needs-selection="false"
                                        class="mt-3"
                                        :raw-data="modelValue.quest_performance_lounges"/>
                        </div>
                    </div>
                </template>
            </expandable-block>
        </div>
        <div v-if="currentTab.value === 'schedule'">
            <div class="grid grid-cols-6 gap-6 w-full">
                <div class="col-span-6 sm:col-span-6">
                    <InputLabel for="source" value="Расписание"/>
                    <select
                        id="quest"
                        v-model="modelValue.schedule_id"
                        class="appearance-none block w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">
                            Нет
                        </option>
                        <option v-for="schedule in props.schedules" :value="schedule.id">
                            {{ schedule.name }}
                        </option>
                    </select>
                    <InputError class="mt-2" :message="modelValue.errors.schedule_id"/>
                </div>
                <div class="col-span-6 sm:col-span-6">
                    <data-table
                        :allow-deletion="false"
                        :needs-selection="false"
                        :table-props="scheduleItemTableProps"
                        :raw-data="scheduleItems"/>
                </div>
            </div>
        </div>
        <div v-if="currentTab.value === 'filters'">
            <div class="grid grid-cols-6 gap-6 w-full">
                <div class="col-span-6 sm:col-span-2">
                    <InputLabel for="location_id" value="Локация"/>
                    <select
                        id="location_id"
                        v-model="modelValue.location_id"
                        class="appearance-none block w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">
                            Нет
                        </option>
                        <option v-for="location in props.locations" :value="location.id">
                            {{ location.name_ru }}
                        </option>
                    </select>
                    <InputError class="mt-2" :message="modelValue.errors.location_id"/>
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <InputLabel for="difficulty" value="Сложность"/>
                    <select
                        id="difficulty"
                        v-model="modelValue.difficulty"
                        class="appearance-none block w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">
                            Нет
                        </option>
                        <option v-for="difficulty in props.difficultyLevels" :value="difficulty.key">
                            {{ difficulty.name }}
                        </option>
                    </select>
                    <InputError class="mt-2" :message="modelValue.errors.difficulty"/>
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <InputLabel for="age_restriction" value="Ограничение по возрасту"/>
                    <TextInput
                        id="age_restriction"
                        type="number"
                        class="mt-1 block w-full"
                        v-model="modelValue.age_restriction"
                    />
                    <InputError class="mt-2" :message="modelValue.errors.age_restriction"/>
                </div>
                <div class="col-span-6 sm:col-span-6">
                    <InputLabel for="quest_topic_ids" value="Рубрики"/>
                    <div class="mt-1">
                        <v-select class="scrollable-select" v-model="modelValue.quest_topic_ids"
                                  multiple=""
                                  label="name_ru"
                                  :reduce="option => option.id"
                                  :options="props.questTopics"/>
                        <InputError class="mt-2" :message="modelValue.errors.quest_topic_ids"/>
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-6">
                    <InputLabel for="quest_child_topic_ids" value="Детские рубрики"/>
                    <div class="mt-1">
                        <v-select class="scrollable-select" v-model="modelValue.quest_child_topic_ids"
                                  multiple=""
                                  label="name_ru"
                                  :reduce="option => option.id"
                                  :options="props.questChildTopics"/>
                        <InputError class="mt-2" :message="modelValue.errors.quest_child_topic_ids"/>
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-6">
                    <InputLabel for="sticker_id" value="Стикер"/>
                    <select id="sticker_id" name="sticker_id"
                            v-model="modelValue.sticker_id"
                            class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">Нет</option>
                        <option v-for="sticker in stickerList" :value="sticker.id">{{ sticker.name }}</option>
                    </select>
                    <InputError class="mt-2" :message="modelValue.errors.sticker_id"/>
                </div>
            </div>
        </div>
        <div v-if="currentTab.value === 'photos'">
            <div class="grid grid-cols-6 gap-6 w-full">
                <div class="col-span-6 sm:col-span-2">
                    <InputLabel for="location_id" value="Галерея 1"/>
                    <input
                        type="file"
                        multiple
                    />
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <InputLabel for="location_id" value="Галерея 2"/>
                    <input
                        type="file"
                        multiple
                    />
                </div>
            </div>
        </div>
        <div v-if="currentTab.value === 'CEO'">
            <div class="grid grid-cols-6 gap-6 w-full">
                <div class="col-span-6 sm:col-span-3">
                    <label for="meta_title" class="block text-sm font-medium text-gray-700">Title</label>
                    <TextInput
                        id="meta_title"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="modelValue.meta_title"
                    />
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="meta_description" class="block text-sm font-medium text-gray-700">Description</label>
                    <TextInput
                        id="meta_description"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="modelValue.meta_description"
                    />
                </div>
                <div class="col-span-6 sm:col-span-6">
                    <label for="meta_keywords" class="block text-sm font-medium text-gray-700">Ключевые слова</label>
                    <TextInput
                        id="meta_keywords"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="modelValue.meta_keywords"
                    />
                </div>
                <div class="col-span-6 sm:col-span-6">
                    <label for="meta_url" class="block text-sm font-medium text-gray-700">URL</label>
                    <TextInput
                        id="meta_url"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="modelValue.meta_url"
                    />
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <label for="og_title" class="block text-sm font-medium text-gray-700">OG Title</label>
                    <TextInput
                        id="og_title"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="modelValue.og_title"
                    />
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <label for="og_description" class="block text-sm font-medium text-gray-700">OG Description</label>
                    <TextInput
                        id="og_description"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="modelValue.og_description"
                    />
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <label for="og_type" class="block text-sm font-medium text-gray-700">OG Тип</label>
                    <TextInput
                        id="og_type"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="modelValue.og_type"
                    />
                </div>
                <div class="col-span-6 sm:col-span-6">
                    <label for="og_url" class="block text-sm font-medium text-gray-700">OG URL</label>
                    <TextInput
                        id="og_url"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="modelValue.og_url"
                    />
                </div>
            </div>
        </div>
        <div class="shadow-2xl rounded-xl sticky bottom-1 z-40 my-5">
            <button type="submit"
                    v-if="currentTab.value !== 'reviews'"
                    class="w-full p-5 flex justify-center py-2 px-4 border border-transparent rounded-md shadow-xl text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Сохранить
            </button>
        </div>
    </form>
</template>

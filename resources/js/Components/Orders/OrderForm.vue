<script setup>
import {computed, onMounted, ref, watch} from "vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import {useForm} from "@inertiajs/vue3";
import {getOptionsSum, getOrderPriceToPay, getOrderTotal, getPlayersSum, orderProps} from "@/Traits/OrderTrait";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
import {collect} from "collect.js";
import { vMaska } from "maska"

const emit = defineEmits(['submit'])

const props = defineProps({
    isEditable: {
        required: false,
        type: Boolean,
        default: false
    },
    modelValue: {
        required: false,
        type: Object,
        default: useForm({})
    },
    ...orderProps
})

const questMeta = ref({
    schedule: [],
    min_players: null,
    max_players: null,
    price: null,
    price_per_participant: null,
})

onMounted(() => {
    if (props.modelValue.date) {
        loadQuestMeta()
    }
})

watch(() => props.modelValue.quest_id, async value => {
    await loadQuestMeta(true)
})

watch(() => props.modelValue.date, async value => {
    await loadQuestMeta()
})

const loadQuestMeta = async (refreshModel = false) => {
    if (!props.modelValue.quest_id) {
        questMeta.value = []
    }
    const date = props.modelValue.date
    questMeta.value.schedule = []
    const data = (await (axios.get(route('quests.get-quest-meta', props.modelValue.quest_id), {
        params: {date: date}
    }))).data
    questMeta.value = data
    if (props.modelValue?.time?.constructor === String) {
        props.modelValue.time = collect(data.schedule).where('time', '==', props.modelValue.time).first()
    }
    if (refreshModel) props.modelValue.players_count = data.min_players
}

const optionSum = computed({
    get() {
        return getOptionsSum(props.modelValue.options)
    },
    set() {

    }
})

const playersSum = computed({
    get() {
        return getPlayersSum(
            Number(questMeta.value.max_players) + Number(props.modelValue.additional_players),
            questMeta.value.min_players,
            questMeta.value.max_players,
            questMeta.value.price_per_participant
        )
    },
    set() {

    }
})

const orderTotal = computed({
    get() {
        return getOrderTotal(questMeta.value.price, props.modelValue, optionSum.value, playersSum.value)
    },
    set() {

    }
})

const orderPriceToPay = computed({
    get() {
        return getOrderPriceToPay(orderTotal.value, props.modelValue)
    },
    set() {

    }
})

const selectedLoungeScheduleItems = computed({
    get() {
        if (!props.modelValue.lounge_id) return []
        return collect(props.loungeList).where('id', '==', props.modelValue.lounge_id).first()['lounge_schedule']['lounge_schedule_items']
    },
    set() {

    }
})
</script>

<template>
    <form class="space-y-6" @submit.prevent="emit('submit', orderTotal)">
        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6" :class="questMeta.min_players ? 'sm:col-span-2' : 'sm:col-span-12'">
                <label for="quest" class="block text-sm font-medium text-gray-700"> Квест </label>
                <div class="mt-1">
                    <select
                        id="quest"
                        :disabled="isEditable"
                        v-model="modelValue.quest_id"
                        required
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">
                            Нет
                        </option>
                        <option v-for="quest in props.questList" :value="quest.id">
                            {{ quest.name_ru }}
                        </option>
                    </select>
                </div>
            </div>
<!--            <div class="col-span-6 sm:col-span-2" v-if="questMeta.min_players || questMeta.max_players">-->
<!--                <label for="players_count" class="block text-sm font-medium text-gray-700"> Количество игроков </label>-->
<!--                <div class="mt-1">-->
<!--                    <select-->
<!--                        v-model="modelValue.players_count"-->
<!--                        required-->
<!--                        id="players_count"-->
<!--                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">-->
<!--                        <template v-for="count in questMeta.max_players">-->
<!--                            <option-->
<!--                                :value="count"-->
<!--                                v-if="count >= questMeta.min_players">-->
<!--                                {{ count }}-->
<!--                            </option>-->
<!--                        </template>-->
<!--                    </select>-->
<!--                </div>-->
<!--            </div>-->
            <div class="col-span-6 sm:col-span-4" v-if="questMeta.min_players || questMeta.max_players">
                <label for="players_count" class="block text-sm font-medium text-gray-700"> Дополнительные
                    игроки </label>
                <div class="mt-1">
                    <select
                        v-model="modelValue.additional_players"
                        id="players_count"
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option :value="0">
                            0
                        </option>
                        <template v-for="count in 5">
                            <option
                                :value="count">
                                {{ count }}
                            </option>
                        </template>
                    </select>
                </div>
            </div>
        </div>
        <div v-if="modelValue.quest_id">
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-3">
                    <InputLabel for="date" value="Дата"/>
                    <TextInput
                        id="date"
                        type="date"
                        class="mt-1 block w-full"
                        v-model="modelValue.date"
                        required
                    />
                    <InputError class="mt-2" :message="modelValue.errors.date"/>
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <label for="time" class="block text-sm font-medium text-gray-700"> Время </label>
                    <select
                        id="time"
                        required
                        :disabled="!props.modelValue.date"
                        v-model="modelValue.time"
                        class="appearance-none mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option v-for="option in questMeta.schedule"
                                :value="option">
                            {{ option.time }}
                        </option>
                    </select>
                    <InputError class="mt-2" :message="modelValue.errors.time"/>
                </div>
            </div>
            <div class="grid grid-cols-6 gap-6 mt-5">
                <div class="col-span-6 sm:col-span-2">
                    <InputLabel for="customer_name" value="Имя клиента"/>
                    <TextInput
                        id="customer_name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="modelValue.customer_name"
                        required
                    />
                    <InputError class="mt-2" :message="modelValue.errors.customer_name"/>
                </div>

                <div class="col-span-6 sm:col-span-2">
                    <InputLabel for="customer_email" value="E-Mail клиента"/>
                    <TextInput
                        id="customer_email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="modelValue.customer_email"
                    />
                    <InputError class="mt-2" :message="modelValue.errors.customer_email"/>
                </div>

                <div class="col-span-6 sm:col-span-2">
                    <InputLabel for="customer_phone" value="Телефон клиента"/>
                    <TextInput
                        v-maska
                        data-maska="+7 (###) ### ##-##"
                        id="customer_phone"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="modelValue.customer_phone"
                        required
                    />
                    <InputError class="mt-2" :message="modelValue.errors.customer_phone"/>
                </div>
            </div>
            <div class="grid grid-cols-6 gap-6 mt-5">
                <div class="col-span-6 sm:col-span-3">
                    <label for="option" class="block text-sm font-medium text-gray-700"> Пакет </label>
                    <div class="mt-1">
                        <select
                            id="option"
                            v-model="modelValue.option"
                            required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option v-for="option in props.optionList" :value="option">
                                {{ option }}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <label for="source" class="block text-sm font-medium text-gray-700"> Источник </label>
                    <div class="mt-1">
                        <select
                            v-model="modelValue.source"
                            required
                            id="source"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option v-for="source in props.sourceList" :value="source.id">
                                {{ source.name }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-6 gap-6 mt-5">
                <div class="col-span-6 sm:col-span-3">
                    <label for="promo-code" class="block text-sm font-medium text-gray-700"> Промокод </label>
                    <div class="mt-1">
                        <select
                            id="promo-code"
                            v-model="modelValue.promo_code"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option :value="null">
                                Нет
                            </option>
                            <option v-for="promoCode in props.promoCodeList" :value="promoCode">
                                {{ promoCode.promocode }}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <label for="certificate" class="block text-sm font-medium text-gray-700"> Сертификат </label>
                    <div class="mt-1">
                        <select
                            id="certificate"
                            v-model="modelValue.certificate"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option :value="null">
                                Нет
                            </option>
                            <option v-for="certificate in props.certificateList" :value="certificate">
                                {{ certificate.number }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-6 gap-6 mt-5">
                <div class="col-span-6 sm:col-span-12">
                    <label for="comment" class="block text-sm font-medium text-gray-700"> Комментарий </label>
                    <div class="mt-1">
                        <textarea
                            id="comment"
                            v-model="modelValue.comment"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </textarea>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-6 gap-6 mt-5">
                <div class="col-span-6 sm:col-span-12">
                    <label for="status" class="block text-sm font-medium text-gray-700"> Статус </label>
                    <div class="mt-1">
                        <select
                            v-model="modelValue.status"
                            required
                            id="status"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option v-for="(status, key) in props.orderStatuses" :value="key">
                                {{ status.name }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-6 gap-6 mt-5">
                <div class="col-span-6 sm:col-span-12">
                    <label for="options" class="block text-sm font-medium text-gray-700"> Дополнительные услуги </label>
                    <a class="text-indigo-600 text-sm" href="#" @click.prevent="modelValue.options = []">Очистить</a>
                    <div class="mt-1">
                        <v-select v-model="modelValue.options" multiple="" label="name_ru"
                                  :options="props.questOptions">
                            <template v-slot:option="option">
                                <span style="color: green" class="text-green-600">{{
                                        option.price
                                    }}</span>
                                {{ option.name_ru }}
                            </template>
                        </v-select>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-6 gap-6 mt-5">
                <div class="col-span-6 sm:col-span-2">
                    <div class="mt-1">
                        <InputLabel for="fact_payment" value="Фактическая оплата"/>
                        <TextInput
                            id="fact_payment"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="modelValue.fact_payment"
                            required
                        />
                        <InputError class="mt-2" :message="modelValue.errors.fact_payment"/>
                    </div>
                    <div class="mt-1">
                        <select
                            :required="!!Number(modelValue.fact_payment)"
                            v-model="modelValue.fact_payment_type"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="" selected disabled>
                                Тип оплаты
                            </option>
                            <option value="0">
                                Наличные
                            </option>
                            <option value="1">
                                Безналичные
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <div class="mt-1">
                        <InputLabel for="prepayment" value="Предоплата"/>
                        <TextInput
                            id="prepayment"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="modelValue.pre_payed"
                            required
                        />
                        <InputError class="mt-2" :message="modelValue.errors.pre_payed"/>
                    </div>

                    <div class="mt-1">
                        <select
                            :required="!!Number(modelValue.pre_payed)"
                            v-model="modelValue.pre_payed_type"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="" selected disabled>
                                Тип оплаты
                            </option>
                            <option value="0">
                                Наличные
                            </option>
                            <option value="1">
                                Безналичные
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-1">
                    <div class="mt-1">
                        <InputLabel for="online_payment" value="Онлайн на сайте"/>
                        <TextInput
                            id="online_payment"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="modelValue.online_payment"
                            required
                        />
                        <InputError class="mt-2" :message="modelValue.errors.online_payment"/>
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-1">
                    <div class="mt-1">
                        <InputLabel for="payed_aggregator" value="Онлайн у агрегаторов"/>
                        <TextInput
                            id="payed_aggregator"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="modelValue.payed_aggregator"
                            required
                        />
                        <InputError class="mt-2" :message="modelValue.errors.payed_aggregator"/>
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-6">
                    <label for="lounge" class="block text-sm font-medium text-gray-700"> Лаунж </label>
                    <div class="mt-1">
                        <select
                            id="lounge"
                            v-model="props.modelValue.lounge_id"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option :value="null">
                                Нет
                            </option>
                            <option v-for="lounge in props.loungeList" :value="lounge.id">
                                {{ lounge.name_ru }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-6">
                    <label for="lounge" class="block text-sm font-medium text-gray-700"> Расписание лаунжа </label>
                    <div class="mt-1">
                        <select
                            id="lounge"
                            :disabled="!props.modelValue.lounge_id"
                            v-model="props.modelValue.lounge_schedule_item_id"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option :value="null">
                                Нет
                            </option>
                            <option v-for="item in selectedLoungeScheduleItems" :value="item.id">
                                {{ item.time }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-6 gap-6 mt-5">
                <div class="col-span-6 sm:col-span-12">
                    <div class="flex flex-col">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Квест
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Игроки
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Лаунж
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Сертификат
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Услуги
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Итого
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                К оплате
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                                                {{ questMeta.price }} <span class="text-green-600"
                                                                            v-if="modelValue.promo_code">(скидка {{
                                                    modelValue.promo_code.value
                                                }})</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ playersSum }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                -
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ -modelValue.certificate?.price || 0 }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ optionSum }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ orderTotal }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ orderPriceToPay }}
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Сохранить
                </button>
            </div>
        </div>
    </form>
</template>

<style lang="scss" scoped>
.scrolling-wrapper {
    display: flex;
    flex-wrap: nowrap;
    overflow-x: auto;
    max-height: 100px;

    .card {
        width: 50%;
        flex: 0 0 auto;
    }
}

::-webkit-scrollbar {
    -webkit-appearance: none;
    width: 3px;
    height: 3px;
}

::-webkit-scrollbar-thumb {
    height: 4px;
    border-radius: 4px;
    background-color: rgba(0, 0, 0, .5);
    -webkit-box-shadow: 0 0 1px rgba(255, 255, 255, .5);
}
</style>

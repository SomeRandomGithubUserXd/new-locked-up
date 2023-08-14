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
import {vMaska} from "maska"
import {PlusIcon} from "@heroicons/vue/24/solid";
import OrderOptionBlock from "@/Components/Orders/OrderOptionBlock.vue";
import LoungeBlock from "@/Components/Orders/LoungeBlock.vue";
import OrdersTablePaymentDetails from "@/Components/DataTableMisc/OrdersTablePaymentDetails.vue";

const emit = defineEmits(['submit', 'abort'])

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
            Number(questMeta.value.max_players) + Number(props.modelValue.additional_players_count),
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
            + Number(loungeSum.value || 0)
            + Number(props.modelValue.time?.price || 0)
    },
    set() {

    }
})
const loungeSum = computed({
    get() {
        let item = collect(selectedLoungeScheduleItems.value).where('id', '==', props.modelValue?.lounge_schedule_item_id || 0).first()
        if (item) {
            return item.price
        }
        return 0
    },
    set() {

    }
})

const orderPriceToPay = computed({
    get() {
        return getOrderPriceToPay(orderTotal.value, props.modelValue, appliedPromoCode.value?.value, appliedCertificate.value?.price)
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

const appliedPromoCode = computed({
    get() {
        if (!props.modelValue.promo_code) return
        return collect(props.promoCodeList).where('promo_code', '==', props.modelValue.promo_code).first()
    },
    set() {

    }
})

const appliedCertificate = computed({
    get() {
        if (!props.modelValue.certificate_id) return
        return collect(props.certificateList).where('id', '==', props.modelValue.certificate_id).first()
    },
    set() {

    }
})

const additionalOption = ref(null)

watch(additionalOption, value => {
    if (!value) return
    if (props.modelValue.options && !props.modelValue.options.find(x => x.id === value.id)) {
        props.modelValue.options.push(value)
    } else {
        props.modelValue.options = [value]
    }
    additionalOption.value = null
}, {deep: true})

const removeOption = (option) => {
    const index = props.modelValue.options.indexOf(option)
    props.modelValue.options.splice(index, 1)
}
</script>

<template>
    <form
        class="space-y-6"
        @submit.prevent="emit('submit', questMeta.price, playersSum, optionSum, orderTotal, orderPriceToPay, Number(orderTotal) - Number(orderPriceToPay))"
        v-on:keydown.enter.prevent>
        <div class="grid grid-cols-5 gap-x-12">
            <div class="grid grid-cols-7 gap-x-6 gap-y-3 col-span-3">
                <div class="col-span-7">
                    <h2 class="text-xl font-bold">Данные заказа</h2>
                </div>
                <div class="col-span-6 sm:col-span-4">
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
                <div class="col-span-6 sm:col-span-1">
                    <label for="players_count" class="block text-sm font-medium text-gray-700"> Доп. игроки </label>
                    <div class="mt-1">
                        <select
                            v-model="modelValue.additional_players_count"
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
                <div class="col-span-6 sm:col-span-2">
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
                    <label for="option" class="block text-sm font-medium text-gray-700"> Пакет </label>
                    <div class="mt-1">
                        <select
                            id="option"
                            v-model="modelValue.option"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option v-for="option in props.optionList" :value="option">
                                {{ option }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-1" v-if="props.modelValue.option !== 'Нет'">
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
                <div class="col-span-6 sm:col-span-3" v-if="props.modelValue.option !== 'Нет'">
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
                <div class="col-span-6 sm:col-span-2" v-if="props.modelValue.option !== 'Нет'">
                    <label for="options" class="block text-sm font-medium text-gray-700">
                        Доп к пакету
                    </label>
                    <!--                    <a class="text-indigo-600 text-sm" href="#"-->
                    <!--                       @click.prevent="modelValue.options = []">Очистить</a>-->
                    <select v-model="props.modelValue.order_option_1"
                            class="appearance-none mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option v-for="option in props.questOptions" :value="option.id">
                            {{ option.name_ru }}
                        </option>
                    </select>
                </div>
                <div class="col-span-6 sm:col-span-2" v-if="props.modelValue.option === 'Максимальный'">
                    <label for="options" class="block text-sm font-medium text-gray-700">
                        Доп к пакету
                    </label>
                    <!--                    <a class="text-indigo-600 text-sm" href="#"-->
                    <!--                       @click.prevent="modelValue.options = []">Очистить</a>-->
                    <select v-model="props.modelValue.order_option_2"
                            class="appearance-none mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option v-for="option in props.questOptions" :value="option.id">
                            {{ option.name_ru }}
                        </option>
                    </select>
                </div>
                <div class="col-span-6 sm:col-span-3" v-if="props.modelValue.option === 'Максимальный'">
                    <label for="options" class="block text-sm font-medium text-gray-700">
                        Доп к пакету
                    </label>
                    <!--                    <a class="text-indigo-600 text-sm" href="#"-->
                    <!--                       @click.prevent="modelValue.options = []">Очистить</a>-->
                    <select v-model="props.modelValue.order_option_3"
                            class="appearance-none mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option v-for="option in props.questOptions" :value="option.id">
                            {{ option.name_ru }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-7 gap-x-6 gap-y-3 col-span-2">
                <div class="col-span-7">
                    <h2 class="text-xl font-bold">Данные заказчика</h2>
                </div>
                <div class="col-span-6 sm:col-span-7">
                    <InputLabel for="customer_name" value="Имя заказчика"/>
                    <TextInput
                        id="customer_name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="modelValue.customer_name"
                        required
                    />
                    <InputError class="mt-2" :message="modelValue.errors.customer_name"/>
                </div>


                <div class="col-span-6 sm:col-span-3">
                    <InputLabel for="customer_phone" value="Телефон"/>
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
                <div class="col-span-6 sm:col-span-4">
                    <InputLabel for="customer_email" value="E-Mail"/>
                    <TextInput
                        id="customer_email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="modelValue.customer_email"
                    />
                    <InputError class="mt-2" :message="modelValue.errors.customer_email"/>
                </div>
            </div>
            <div class="grid grid-cols-10 gap-x-6 gap-y-3 col-span-5 mt-10">
                <div class="col-span-10">
                    <h2 class="text-xl font-bold">Дополнительная информация</h2>
                </div>
                <div class="col-span-6 sm:col-span-2">
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
                <div class="col-span-6 sm:col-span-2">
                    <label for="source" class="block text-sm font-medium text-gray-700"> Источник </label>
                    <div class="mt-1">
                        <select
                            v-model="modelValue.order_source_id"
                            required
                            id="source"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option v-for="source in props.sourceList" :value="source.id">
                                {{ source.name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <label for="certificate" class="block text-sm font-medium text-gray-700"> Сертификат </label>
                    <div class="mt-1">
                        <select
                            id="certificate"
                            v-model="modelValue.certificate_id"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option :value="null">
                                Нет
                            </option>
                            <option v-for="certificate in props.certificateList" :value="certificate.id">
                                {{ certificate.number }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <InputLabel for="promo_code" value="Промокод"/>
                    <TextInput
                        id="promo_code"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="modelValue.promo_code"
                    />
                    <InputError class="mt-2" :message="modelValue.errors.promo_code"/>
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="options" class="block text-sm font-medium text-gray-700"> Дополнительные
                        услуги </label>
                    <!--                    <a class="text-indigo-600 text-sm" href="#"-->
                    <!--                       @click.prevent="modelValue.options = []">Очистить</a>-->
                    <select v-model="additionalOption"
                            class="appearance-none mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option v-for="option in props.questOptions" :value="option">
                            {{ option.name_ru }}
                        </option>
                    </select>
                </div>
                <div class="col-span-6 sm:col-span-3 items-start flex w-full h-full flex-wrap gap-3 pt-5">
                    <order-option-block
                        @remove="removeOption"
                        :instance="option"
                        v-for="option in props.modelValue.options"/>
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <label for="comment" class="block text-sm font-medium text-gray-700"> Комментарий </label>
                    <div class="mt-1">
                        <textarea
                            id="comment"
                            v-model="modelValue.comment"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </textarea>
                    </div>
                </div>

                <div class="col-span-10 sm:col-span-10 grid grid-cols-10 gap-x-6 gap-y-3">
                    <div class="grid grid-cols-4 gap-x-6 gap-y-3 col-span-10 sm:col-span-3">
                        <div class="col-span-10 sm:col-span-1">
                            <label for="lounge_option_time"
                                   class="block text-sm font-medium text-gray-700">Время</label>
                            <div class="mt-1">
                                <select
                                    id="lounge_option_time"
                                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <!--                                    <option selected :value="instance.time">-->
                                    <!--                                        {{instance.time}}-->
                                    <!--                                    </option>-->
                                </select>
                            </div>
                        </div>
                        <div class="col-span-10 sm:col-span-3">
                            <label for="lounge_option" class="block text-sm font-medium text-gray-700">Лаунж</label>
                            <div class="mt-1 flex items-center">
                                <select
                                    id="lounge_option"
                                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <!--                                    <option selected :value="props.instance.pivot.lounge">-->
                                    <!--                                        {{props.instance.pivot.lounge.name_ru}}-->
                                    <!--                                    </option>-->
                                </select>
                                <button type="button"
                                        style="height: 38px"
                                        class="w-full flex justify-center items-center ml-1 w-12 h-full flex justify-center border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <plus-icon class="w-3/4"/>
                                </button>
                            </div>
                        </div>
                    </div>
                    <lounge-block class="col-span-10 sm:col-span-3"
                                  v-for="lounge in props.modelValue.lounge_schedule_items" :instance="lounge"/>
                </div>
            </div>
        </div>

        <div v-if="true">
            <div class="grid grid-cols-6 gap-6 mt-5">
                <div class="col-span-6 sm:col-span-2">
                    <div class="mt-1">
                        <InputLabel for="fact_payment" value="Фактическая оплата"/>
                        <TextInput
                            id="fact_payment"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="modelValue.postpaid"
                            required
                        />
                        <InputError class="mt-2" :message="modelValue.errors.postpaid"/>
                    </div>
                    <div class="mt-1">
                        <select
                            :required="!!Number(modelValue.postpaid)"
                            v-model="modelValue.postpaid_type"
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
                            v-model="modelValue.pre_paid"
                            required
                        />
                        <InputError class="mt-2" :message="modelValue.errors.pre_paid"/>
                    </div>

                    <div class="mt-1">
                        <select
                            :required="!!Number(modelValue.pre_paid)"
                            v-model="modelValue.pre_paid_type"
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
                            v-model="modelValue.paid_through_acquiring"
                            required
                        />
                        <InputError class="mt-2" :message="modelValue.errors.paid_through_acquiring"/>
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-1">
                    <div class="mt-1">
                        <InputLabel for="paid_aggregator" value="Онлайн у агрегаторов"/>
                        <TextInput
                            id="paid_aggregator"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="modelValue.paid_through_aggregator"
                            required
                        />
                        <InputError class="mt-2" :message="modelValue.errors.paid_through_aggregator"/>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-6 gap-6 mt-5">
                <div class="col-span-6 sm:col-span-12">
                    <div class="flex flex-col">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="overflow-hidden border-b border-gray-200">
                                    <table class="min-w-full">
                                        <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-md font-bold text-gray-500  tracking-wider">
                                                Квест
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-md font-bold text-gray-500  tracking-wider">
                                                Игроки
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-md font-bold text-gray-500  tracking-wider">
                                                Лаунж
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-md font-bold text-gray-500  tracking-wider">
                                                Сертификат
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-md font-bold text-gray-500  tracking-wider">
                                                Услуги
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-md font-bold text-gray-500  tracking-wider">
                                                Итого
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-md font-bold text-gray-500  tracking-wider">
                                                Оплачено
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-md font-bold text-gray-500  tracking-wider">
                                                К оплате
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-md font-medium text-black">
                                                {{ questMeta.price }} <span class="text-green-600"
                                                                            v-if="appliedPromoCode">(скидка {{
                                                    appliedPromoCode.value
                                                }})</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-md text-black">
                                                {{ playersSum }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-md text-black">
                                                {{ loungeSum }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-md text-black">
                                                {{ -appliedCertificate?.price || 0 }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-md text-black">
                                                {{ optionSum }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-md text-black">
                                                {{ orderTotal }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-md text-black">
                                                <orders-table-payment-details :meta="{item: props.modelValue}"/>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-md text-black">
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
            <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                <button type="button"
                        @click.prevent="emit('abort')"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-red-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-red-700 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                    Отменить
                </button>
                <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mr-3 sm:w-auto sm:text-sm">
                    Сохранить изменения
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

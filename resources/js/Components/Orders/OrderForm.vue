<script setup>
import {computed, onMounted, ref, watch} from "vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import {router, useForm, usePage} from "@inertiajs/vue3";
import {getOptionsSum, getOrderPriceToPay, getOrderTotal, getPlayersSum, orderProps} from "@/Traits/OrderTrait";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
import {collect} from "collect.js";
import {vMaska} from "maska"
import {PlusIcon, ArrowUturnLeftIcon} from "@heroicons/vue/24/solid";
import OrderOptionBlock from "@/Components/Orders/OrderOptionBlock.vue";
import LoungeBlock from "@/Components/Orders/LoungeBlock.vue";
import OrdersTablePaymentDetails from "@/Components/DataTableMisc/OrdersTablePaymentDetails.vue";
import OrderPaymentStatusBlock from "@/Components/Orders/OrderPaymentStatusBlock.vue";

const emit = defineEmits(['submit', 'abort', 'refreshOrder'])

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

watch(() => props.modelValue, value => {
}, {
    deep: true
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

const getPaidSum = computed({
    get() {
        let paid = 0
        for (const payment of props.modelValue.order_payments) {
            paid += payment.sum
        }
        return paid
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

const selectedAdditionalLoungeScheduleItems = computed({
    get() {
        if (!additionalLounge.value) return []
        return collect(props.loungeList).where('id', '==', additionalLounge.value.id).first()['lounge_schedule']['lounge_schedule_items']
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

const additionalLounge = ref(null)

const additionalLoungeScheduleItem = ref(null)

const storeAdditionalLounge = () => {
    if (!additionalLounge.value || !additionalLoungeScheduleItem.value) return
    const scheduleItemCompiled = {
        ...additionalLoungeScheduleItem.value,
        pivot: {
            lounge_id: additionalLounge.value.id
        }
    }
    props.modelValue.lounge_schedule_items.push(scheduleItemCompiled)
    additionalLounge.value = null
    additionalLoungeScheduleItem.value = null
}

const removeLoungeScheduleItem = (item) => {
    const index = props.modelValue.lounge_schedule_items.indexOf(item)
    props.modelValue.lounge_schedule_items.splice(index, 1)
}

const storePayment = () => {
    props.modelValue.order_payments.push({
        id: Math.random() * 100,
        order_id: props.modelValue.id,
        id_from_provider: null,
        order_number: null,
        type: 0,
        payment_option: 0,
        date: new Date().toJSON().slice(0, 10),
        status: 0,
        link: null,
        sum: 0,
        returned: 0,
        can_be_returned: false,
        can_be_registered: false,
        apply_refund: false,
    })
}

const countRemaining = (total, item) => {
    let sum = Number(orderPriceToPay.value)
    for (const payment of total) {
        sum += Number(payment.returned)
        sum -= Number(payment.sum)
        if (payment.id === item.id) {
            return sum
        }
    }
    return sum
}

const registerPayment = (item) => {
    router.post(route('orders.payments.register', {
        order_payment: item.id,
    }), {}, {
        preserveScroll: true,
        onSuccess: () => {
            emit('refreshOrder', item.order_id)
        }
    })
}

const requestRefund = (item) => {
    item.apply_refund = true
}
</script>

<template>
    <form
        class="space-y-6"
        @submit.prevent="emit('submit', questMeta.price, playersSum, optionSum, orderTotal, orderPriceToPay, Number(orderTotal) - Number(orderPriceToPay))"
        v-on:keydown.enter.prevent>
        <div class="grid grid-cols-5 gap-x-12">
            <div class="grid grid-cols-12 gap-x-6 gap-y-3 col-span-3">
                <div class="col-span-12">
                    <h2 class="text-xl font-bold">Данные заказа</h2>
                </div>
                <div class="col-span-6 sm:col-span-5">
                    <label for="quest" class="block text-md font-medium text-gray-700"> Квест </label>
                    <div class="mt-1">
                        <select
                            id="quest"
                            :disabled="isEditable"
                            v-model="modelValue.quest_id"
                            required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-md">
                            <option value="">
                                Нет
                            </option>
                            <option v-for="quest in props.questList" :value="quest.id">
                                {{ quest.name_ru }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <label for="players_count" class="block text-md font-medium text-gray-700"> Доп. игроки </label>
                    <div class="mt-1">
                        <select
                            v-model="modelValue.additional_players_count"
                            id="players_count"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-md">
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
                <div class="col-span-6 sm:col-span-3">
                    <InputLabel for="date" value="Дата"/>
                    <TextInput
                        id="date"
                        type="date"
                        class="mt-1 block w-full"
                        v-model="modelValue.date"
                        required
                    />
                    <InputError class="mt-2" :message="modelValue?.errors?.date"/>
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <label for="time" class="block text-md font-medium text-gray-700"> Время </label>
                    <select
                        id="time"
                        required
                        :disabled="!props.modelValue.date"
                        v-model="modelValue.time"
                        class="appearance-none mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-md">
                        <option v-for="option in questMeta.schedule"
                                :value="option">
                            {{ option.time }}
                        </option>
                    </select>
                    <InputError class="mt-2" :message="modelValue?.errors?.time"/>
                </div>

                <div class="col-span-6 sm:col-span-5">
                    <label for="option" class="block text-md font-medium text-gray-700"> Пакет </label>
                    <div class="mt-1">
                        <select
                            id="option"
                            v-model="modelValue.option"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-md">
                            <option v-for="option in props.optionList" :value="option">
                                {{ option }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-5" v-if="props.modelValue.option !== 'Нет'">
                    <label for="lounge" class="block text-md font-medium text-gray-700"> Лаунж </label>
                    <div class="mt-1">
                        <select
                            id="lounge"
                            v-model="props.modelValue.lounge_id"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-md">
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
                    <label for="lounge" class="block text-md font-medium text-gray-700"> Время </label>
                    <div class="mt-1">
                        <select
                            id="lounge"
                            :disabled="!props.modelValue.lounge_id"
                            v-model="props.modelValue.lounge_schedule_item_id"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-md">
                            <option :value="null">
                                Нет
                            </option>
                            <option v-for="item in selectedLoungeScheduleItems" :value="item.id">
                                {{ item.time }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-4" v-if="props.modelValue.option !== 'Нет'">
                    <label for="options" class="block text-md font-medium text-gray-700">
                        Доп к пакету
                    </label>
                    <!--                    <a class="text-indigo-600 text-md" href="#"-->
                    <!--                       @click.prevent="modelValue.options = []">Очистить</a>-->
                    <select v-model="props.modelValue.order_option_1"
                            class="appearance-none mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-md">
                        <option v-for="option in props.questOptions" :value="option.id">
                            {{ option.name_ru }}
                        </option>
                    </select>
                </div>
                <div class="col-span-6 sm:col-span-4" v-if="props.modelValue.option === 'Максимальный'">
                    <label for="options" class="block text-md font-medium text-gray-700">
                        Доп к пакету
                    </label>
                    <!--                    <a class="text-indigo-600 text-md" href="#"-->
                    <!--                       @click.prevent="modelValue.options = []">Очистить</a>-->
                    <select v-model="props.modelValue.order_option_2"
                            class="appearance-none mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-md">
                        <option v-for="option in props.questOptions" :value="option.id">
                            {{ option.name_ru }}
                        </option>
                    </select>
                </div>
                <div class="col-span-6 sm:col-span-4" v-if="props.modelValue.option === 'Максимальный'">
                    <label for="options" class="block text-md font-medium text-gray-700">
                        Доп к пакету
                    </label>
                    <!--                    <a class="text-indigo-600 text-md" href="#"-->
                    <!--                       @click.prevent="modelValue.options = []">Очистить</a>-->
                    <select v-model="props.modelValue.order_option_3"
                            class="appearance-none mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-md">
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
                    <InputError class="mt-2" :message="modelValue?.errors?.customer_name"/>
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
                    <InputError class="mt-2" :message="modelValue?.errors?.customer_phone"/>
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <InputLabel for="customer_email" value="E-Mail"/>
                    <TextInput
                        id="customer_email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="modelValue.customer_email"
                    />
                    <InputError class="mt-2" :message="modelValue?.errors?.customer_email"/>
                </div>
            </div>
            <div class="grid grid-cols-10 gap-x-6 gap-y-3 col-span-5 mt-10">
                <div class="col-span-10">
                    <h2 class="text-xl font-bold">Дополнительная информация</h2>
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <label for="status" class="block text-md font-medium text-gray-700"> Статус </label>
                    <div class="mt-1">
                        <select
                            v-model="modelValue.status"
                            required
                            id="status"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-md">
                            <option v-for="(status, key) in props.orderStatuses" :value="key">
                                {{ status.name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <label for="source" class="block text-md font-medium text-gray-700"> Источник </label>
                    <div class="mt-1">
                        <select
                            v-model="modelValue.order_source_id"
                            required
                            id="source"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-md">
                            <option v-for="source in props.sourceList" :value="source.id">
                                {{ source.name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <label for="certificate" class="block text-md font-medium text-gray-700"> Сертификат </label>
                    <div class="mt-1">
                        <select
                            id="certificate"
                            v-model="modelValue.certificate_id"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-md">
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
                    <InputError class="mt-2" :message="modelValue?.errors?.promo_code"/>
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="options" class="block text-md font-medium text-gray-700"> Дополнительные
                        услуги </label>
                    <!--                    <a class="text-indigo-600 text-md" href="#"-->
                    <!--                       @click.prevent="modelValue.options = []">Очистить</a>-->
                    <select v-model="additionalOption"
                            class="appearance-none mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-md">
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
                    <label for="comment" class="block text-md font-medium text-gray-700"> Комментарий </label>
                    <div class="mt-1">
                        <textarea
                            id="comment"
                            v-model="modelValue.comment"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-md">
                        </textarea>
                    </div>
                </div>

                <div class="col-span-10 sm:col-span-10 grid grid-cols-9 gap-x-6 gap-y-3">
                    <div class="grid grid-cols-5 gap-x-6 gap-y-3 col-span-10 sm:col-span-3">
                        <div class="col-span-10 sm:col-span-3">
                            <label for="lounge_option" class="block text-md font-medium text-gray-700">Лаунж</label>
                            <div class="mt-1 flex items-center">
                                <select
                                    id="lounge_option"
                                    v-model="additionalLounge"
                                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-md">
                                    <option :value="null">
                                        Нет
                                    </option>
                                    <option v-for="lounge in props.loungeList" :value="lounge">
                                        {{ lounge.name_ru }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-span-10 sm:col-span-2">
                            <label for="lounge_option_time"
                                   class="block text-md font-medium text-gray-700">Время</label>
                            <div class="mt-1 flex items-center">
                                <select
                                    id="lounge_option_time"
                                    v-model="additionalLoungeScheduleItem"
                                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-md">
                                    <option :value="instance" v-for="instance in selectedAdditionalLoungeScheduleItems">
                                        {{ instance.time }}
                                    </option>
                                </select>
                                <button type="button"
                                        @click.prevent="storeAdditionalLounge"
                                        style="height: 38px"
                                        class="flex justify-center items-center ml-1 w-16 h-full flex justify-center border border-transparent rounded-md shadow-sm text-md font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <plus-icon class="w-3/4"/>
                                </button>
                            </div>
                        </div>
                    </div>
                    <lounge-block
                        @remove="removeLoungeScheduleItem"
                        :lounge-list="props.loungeList"
                        class="col-span-10 sm:col-span-3"
                        v-for="lounge in props.modelValue.lounge_schedule_items" :instance="lounge"/>
                </div>

                <div class="sm:col-span-10">
                    <div class="col-span-10 flex items-center my-4">
                        <h2 class="text-xl font-bold">Оплаты</h2>
                        <div class="ml-auto">
                            <button type="button"
                                    @click.prevent="storePayment"
                                    style="height: 38px"
                                    class="flex justify-center items-center ml-1 w-12 h-full flex justify-center border border-transparent rounded-md shadow-sm text-md font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <plus-icon class="w-3/4"/>
                            </button>
                        </div>
                    </div>
                    <div
                        class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg overflow-scroll">
                        <table class="min-w-full divide-y divide-gray-200 font-size-all">
                            <thead style="background: rgba(249, 250, 251, 1);color: rgba(113, 113, 113, 1);">
                            <tr>
                                <th
                                    class="px-3 py-4 text-left text-md font-bold">
                                    Тип платежа
                                </th>
                                <th
                                    class="px-3 py-4 text-left text-md font-bold ">
                                    Дата
                                </th>
                                <th
                                    class="px-3 py-4 text-left text-md font-bold ">
                                    Вид
                                </th>
                                <th
                                    class="px-3 py-4 text-left text-md font-bold ">
                                    Сумма
                                </th>
                                <th
                                    class="px-3 py-4 text-left text-md font-bold ">
                                    Статус
                                </th>
                                <th
                                    class="px-3 py-4 text-left text-md font-bold ">
                                    Остаток
                                </th>
                                <th
                                    class="px-3 py-4 text-left text-md font-bold ">
                                    Ссылка
                                </th>
                                <th
                                    class="px-3 py-4 text-left text-md font-bold ">
                                    Возврат
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="payment in props.modelValue.order_payments">
                                <td class="px-3 whitespace-nowrap text-md ">
                                    <select
                                        required
                                        :disabled="payment.status !== 0 || payment.link"
                                        v-model="payment.type"
                                        :style="{backgroundColor: orderPaymentTypes[payment.type].backgroundColor, color: orderPaymentTypes[payment.type].color}"
                                        class="appearance-none w-full block px-3 py-2 rounded-md sm:text-md focus:border-transparent focus:ring-0 border-transparent">
                                        <option :value="type.key" v-for="type in orderPaymentTypes">
                                            {{ type.name }}
                                        </option>
                                    </select>
                                </td>
                                <td class="px-3 whitespace-nowrap text-md ">
                                    <text-input
                                        id="activation_date"
                                        type="date"
                                        class="mt-1 block w-full"
                                        v-model="payment.date"
                                    />
                                </td>
                                <td class="px-3 whitespace-nowrap text-md ">
                                    <fieldset>
                                        <div class="flex flex-col my-2">
                                            <div class="flex items-center">
                                                <input :id="'payment_option_0_' + payment.id"
                                                       :name="'payment_option_0_' + payment.id"
                                                       value="0"
                                                       type="radio" v-model="payment.payment_option"
                                                       class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"/>
                                                <label :for="'payment_option_0_' + payment.id"
                                                       class="ml-3 block text-sm font-medium text-gray-700">
                                                    Н
                                                </label>
                                            </div>
                                            <div class="flex items-center">
                                                <input :id="'payment_option_1_' + payment.id"
                                                       :name="'payment_option_1_' + payment.id"
                                                       value="1"
                                                       type="radio" v-model="payment.payment_option"
                                                       class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"/>
                                                <label :for="'payment_option_1_' + payment.id"
                                                       class="ml-3 block text-sm font-medium text-gray-700">
                                                    БН
                                                </label>
                                            </div>
                                        </div>
                                    </fieldset>
                                </td>
                                <td class="px-3 whitespace-nowrap text-md ">
                                    <text-input
                                        type="number"
                                        class="mt-1 block w-full"
                                        v-model="payment.sum"
                                    />
                                </td>
                                <td class="px-3 whitespace-nowrap text-md ">
                                    <order-payment-status-block
                                        class="w-28 text-sm"
                                        :order-statuses="props.orderPaymentStatuses"
                                        v-model="payment.status"/>
                                </td>
                                <td class="px-3 whitespace-nowrap text-md ">
                                    {{ countRemaining(props.modelValue.order_payments, payment) }}
                                </td>
                                <!--  TODO: explain why disabled  -->
                                <td class="px-3 whitespace-nowrap text-md">
                                    <div v-if="Number(payment.type) === 2">
                                        <div v-if="payment.link">
                                            {{ payment.link }}
                                        </div>
                                        <div v-else>
                                            <button type="button"
                                                    :disabled="payment.can_be_registered === false"
                                                    :class="payment.can_be_registered === false ? 'bg-gray-600 focus:ring-gray-500' : 'bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500'"
                                                    @click.prevent="registerPayment(payment)"
                                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 sm:mr-3 sm:w-auto sm:text-md">
                                                Сгенерировать
                                            </button>
                                        </div>
                                    </div>
                                    <div v-else>
                                        -
                                    </div>
                                </td>
                                <td class="px-3 whitespace-nowrap text-md">
                                    <div class="mt-1 flex items-center">
                                        <text-input
                                            :disabled="!payment.can_be_returned || payment.apply_refund"
                                            id="returned_amount"
                                            type="number"
                                            class="mt-1 block w-28 h-full"
                                            v-model="payment.returned"
                                        />
                                        <button
                                            @click.prevent="requestRefund(payment)"
                                            v-if="payment.can_be_returned  && !payment.apply_refund"
                                            type="button"
                                            class="flex justify-center items-center ml-1 w-16 h-full flex justify-center border border-transparent rounded-md shadow-sm text-md font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                            style="height: 38px;">
                                            <arrow-uturn-left-icon class="w-8"/>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        <!--        <div class="grid grid-cols-6 gap-6 mt-5">-->
        <!--            <div class="col-span-6 sm:col-span-2">-->
        <!--                <div class="mt-1">-->
        <!--                    <InputLabel for="fact_payment" value="Фактическая оплата"/>-->
        <!--                    <TextInput-->
        <!--                        id="fact_payment"-->
        <!--                        type="number"-->
        <!--                        class="mt-1 block w-full"-->
        <!--                        v-model="modelValue.postpaid"-->
        <!--                        required-->
        <!--                    />-->
        <!--                    <InputError class="mt-2" :message="modelValue?.errors?.postpaid"/>-->
        <!--                </div>-->
        <!--                <div class="mt-1">-->
        <!--                    <select-->
        <!--                        :required="!!Number(modelValue.postpaid)"-->
        <!--                        v-model="modelValue.postpaid_type"-->
        <!--                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-md">-->
        <!--                        <option value="" selected disabled>-->
        <!--                            Тип оплаты-->
        <!--                        </option>-->
        <!--                        <option value="0">-->
        <!--                            Наличные-->
        <!--                        </option>-->
        <!--                        <option value="1">-->
        <!--                            Безналичные-->
        <!--                        </option>-->
        <!--                    </select>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--            <div class="col-span-6 sm:col-span-2">-->
        <!--                <div class="mt-1">-->
        <!--                    <InputLabel for="prepayment" value="Предоплата"/>-->
        <!--                    <TextInput-->
        <!--                        id="prepayment"-->
        <!--                        type="number"-->
        <!--                        class="mt-1 block w-full"-->
        <!--                        v-model="modelValue.pre_paid"-->
        <!--                        required-->
        <!--                    />-->
        <!--                    <InputError class="mt-2" :message="modelValue?.errors?.pre_paid"/>-->
        <!--                </div>-->

        <!--                <div class="mt-1">-->
        <!--                    <select-->
        <!--                        :required="!!Number(modelValue.pre_paid)"-->
        <!--                        v-model="modelValue.pre_paid_type"-->
        <!--                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-md">-->
        <!--                        <option value="" selected disabled>-->
        <!--                            Тип оплаты-->
        <!--                        </option>-->
        <!--                        <option value="0">-->
        <!--                            Наличные-->
        <!--                        </option>-->
        <!--                        <option value="1">-->
        <!--                            Безналичные-->
        <!--                        </option>-->
        <!--                    </select>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--            <div class="col-span-6 sm:col-span-1">-->
        <!--                <div class="mt-1">-->
        <!--                    <InputLabel for="online_payment" value="Онлайн на сайте"/>-->
        <!--                    <TextInput-->
        <!--                        id="online_payment"-->
        <!--                        type="number"-->
        <!--                        class="mt-1 block w-full"-->
        <!--                        v-model="modelValue.paid_through_acquiring"-->
        <!--                        required-->
        <!--                    />-->
        <!--                    <InputError class="mt-2" :message="modelValue?.errors?.paid_through_acquiring"/>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--            <div class="col-span-6 sm:col-span-1">-->
        <!--                <div class="mt-1">-->
        <!--                    <InputLabel for="paid_aggregator" value="Онлайн у агрегаторов"/>-->
        <!--                    <TextInput-->
        <!--                        id="paid_aggregator"-->
        <!--                        type="number"-->
        <!--                        class="mt-1 block w-full"-->
        <!--                        v-model="modelValue.paid_through_aggregator"-->
        <!--                        required-->
        <!--                    />-->
        <!--                    <InputError class="mt-2" :message="modelValue?.errors?.paid_through_aggregator"/>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <div class="grid grid-cols-6 gap-6 mt-5">
            <div class="col-span-6 sm:col-span-12">
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="overflow-hidden border-b border-gray-200">
                                <table class="min-w-full">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-md font-bold text-gray-500  ">
                                            Квест
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-md font-bold text-gray-500  ">
                                            Игроки
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-md font-bold text-gray-500  ">
                                            Лаунж
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-md font-bold text-gray-500  ">
                                            Сертификат
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-md font-bold text-gray-500  ">
                                            Услуги
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-md font-bold text-gray-500  ">
                                            Итого
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-md font-bold text-gray-500  ">
                                            Оплачено
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-md font-bold text-gray-500  ">
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
                                            {{ orderPriceToPay - getPaidSum }}
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
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-red-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-red-700 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-md">
                Отменить
            </button>
            <button type="submit"
                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mr-3 sm:w-auto sm:text-md">
                Сохранить изменения
            </button>
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

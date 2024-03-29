<script setup>
import {Head, router, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import BookingItem from "@/Components/Bookings/BookingItem.vue";
import {onMounted} from "vue";
import {getCurrentUrlParam} from "@/Traits/Tools";
import Pagination from "@/Components/Common/Pagination.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {collect} from "collect.js";

const props = defineProps({
    quests: Object,
    locations: Array
})

const defaultFilter = {
    date: null,
    location_id: null
}

const filter = useForm(defaultFilter)

onMounted(() => {
    const date = getCurrentUrlParam('date') || new Date().toJSON().slice(0, 10)
    filter.date = date
    filter.location_id = getCurrentUrlParam('location_id')
    router.reload({data: {date}})
})

const submit = () => {
    filter.get(route('bookings.index'), {
        onError: (err) => console.log(err)
    })
}

const setBooking = (quest_id, id) => {
    filter.transform((data) => ({
        ...data,
        quest_id,
    })).patch(route('bookings.make', id), {
        preserveScroll: true
    })
}

const unsetBooking = (quest_id, id) => {
    filter.transform((data) => ({
        ...data,
        quest_id,
    })).patch(route('bookings.undo', id), {
        preserveScroll: true
    })
}

const writeOrder = (time, quest_id) => {
    router.get(route('orders.create'), {
        quest_id: quest_id,
        date: filter.date,
        time: time,
    }, {
        preserveScroll: true
    })
}

const bookAllItems = (quest) => {
    filter.transform((data) => {
        return {
            ...data,
            quest_id: quest.id,
            ids: collect(quest.items).pluck('id').all()
        }
    }).post(route('bookings.make_many'), {
        preserveScroll: true
    })
}

const unbookAllItems = (quest) => {
    filter.transform((data) => {
        return {
            ...data,
            quest_id: quest.id,
            ids: collect(quest.items).pluck('id').all()
        }
    }).post(route('bookings.undo_many'), {
        preserveScroll: true
    })
}
</script>

<template>
    <Head title="Бронирование"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Бронирование</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submit" class="grid grid-cols-9 gap-6 flex items-center">
                            <h2 class="font-semibold text-2xl col-span-6 sm:col-span-9">Фильтр</h2>
                            <div class=" col-span-6 sm:col-span-1">
                                <InputLabel for="date" value="Дата"/>
                                <TextInput
                                    id="date"
                                    :min="new Date().toISOString().split('T')[0]"
                                    type="date"
                                    class="mt-1 block w-full"
                                    v-model="filter.date"
                                    required
                                    autofocus
                                />
                                <InputError class="mt-2" :message="filter.errors.date"/>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <InputLabel for="location_id" value="Локация"/>
                                <select
                                    id="location_id"
                                    v-model="filter.location_id"
                                    class="appearance-none block w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">
                                        Нет
                                    </option>
                                    <option v-for="location in props.locations" :value="location.id">
                                        {{ location.name_ru }}
                                    </option>
                                </select>
                            </div>
                            <div class="mt-5 col-span-6 sm:col-span-2">
                                <button type="submit"
                                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Искать
                                </button>
                            </div>
                            <div class="mt-5 col-span-6 sm:col-span-1">
                                <button type="submit"
                                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Сбросить
                                </button>
                            </div>
                        </form>
                        <div class="flex flex-col mt-3 overflow-scroll">
                            <div v-for="quest in props.quests.data" class="my-1">
                                <div class="flex items-end my-5">
                                    <h3 class="font-semibold text-lg">
                                        {{ quest.name }}
                                    </h3>
                                    <button
                                        @click="bookAllItems(quest)"
                                        class="inline-flex ml-3 items-center justify-center p-2 text-sm rounded-md text-white bg-indigo-500 hover:bg-indigo-600 transition duration-150 ease-in-out">
                                        Забронировать все
                                    </button>
                                </div>
                                <div class="flex">
                                    <booking-item
                                        class="mr-3"
                                        @block-manually="setBooking(quest.id, $event)"
                                        @unblock-manually="unsetBooking(quest.id, $event)"
                                        @write-order-using-item="writeOrder"
                                        :id="item.id"
                                        :quest-id="quest.id"
                                        :time="item.time"
                                        :price="item.price"
                                        :is-active="item.active"
                                        v-for="item in quest.items"/>
                                </div>
                            </div>
                        </div>
                        <pagination
                            :current-page="props.quests.meta.current_page"
                            :max-page="props.quests.meta.last_page"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

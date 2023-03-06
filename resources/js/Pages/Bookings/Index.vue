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

const props = defineProps({
    quests: Object
})

const defaultFilter = {
    date: null
}

const filter = useForm(defaultFilter)

onMounted(() => {
    const date = getCurrentUrlParam('date') || new Date().toJSON().slice(0, 10)
    filter.date = date
    router.reload({data: {date}})
})

const submit = () => {
    filter.get(route('bookings.index'), {
        onError: (err) => console.log(err)
    })
}

const setBooking = (id) => {
    filter.patch(route('bookings.make', id))
}

const unsetBooking = (id) => {
    filter.patch(route('bookings.undo', id))
}

const writeOrder = (time, quest_id) => {
    router.get(route('orders.create'), {
        quest_id: quest_id,
        date: filter.date,
        time: time,
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
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submit">
                            <h2 class="font-semibold text-2xl">Фильтр</h2>
                            <div>
                                <InputLabel for="date" value="Дата"/>
                                <TextInput
                                    id="date"
                                    type="date"
                                    class="mt-1 block w-full"
                                    v-model="filter.date"
                                    required
                                    autofocus
                                />
                                <InputError class="mt-2" :message="filter.errors.date"/>
                            </div>
                            <div class="mt-5">
                                <button type="submit"
                                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Искать
                                </button>
                            </div>
                        </form>
                        <div class="flex flex-col mt-3 overflow-scroll">
                            <div v-for="quest in props.quests.data" class="my-1">
                                <h3 class="font-semibold text-lg"> {{ quest.name }} </h3>
                                <div class="flex">
                                    <booking-item
                                        class="mr-3"
                                        @block-manually="setBooking"
                                        @unblock-manually="unsetBooking"
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

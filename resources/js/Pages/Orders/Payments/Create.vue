<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import OrderForm from "@/Components/Orders/OrderForm.vue";
import {Head, router, useForm} from "@inertiajs/vue3";
import {orderProps} from "@/Traits/OrderTrait";
import {getCurrentUrlParam} from "@/Traits/Tools";
import {ref} from "vue";
import DataTable from "@/Components/Common/DataTable.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";

const props = defineProps({
    order: Object
})

const item = useForm({
    sum: 0
})

const store = () => {
    item.post(route('orders.payments.store', props.order.id))
}
</script>

<template>
    <Head title="Добавить платеж"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Добавить платеж</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form class="grid grid-cols-6 gap-6" @submit.prevent="store">
                            <div class="col-span-6 sm:col-span-6">
                                <input-label for="search_string" value="Сумма"/>
                                <text-input
                                    id="search_string"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="item.sum"
                                    autofocus
                                />
                                <input-error class="mt-2" :message="item.sum.search_string"/>
                            </div>
                            <div class="col-span-6 sm:col-span-6">
                                <button type="submit"
                                        class="flex w-full justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Сохранить
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

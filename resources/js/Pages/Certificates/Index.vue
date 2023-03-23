<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {onMounted, ref} from "vue";
import {getAlreadyPayed, getOrderPriceToPay} from "@/Traits/OrderTrait";
import DataTable from "@/Components/Common/DataTable.vue";
import {Head, router, Link, useForm} from '@inertiajs/vue3';
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import {getCurrentUrlParam} from "@/Traits/Tools";

const props = defineProps({
    certificates: Object,
    certificateInstances: Array
})

const tableProps = ref({
    records: [
        {
            name: 'Заказчик',
            getValue: (appeal) => {
                return `Имя: ${appeal.customer_name || 'Нет'} <br/> Телефон ${appeal.customer_phone || 'Нет'} <br/> E-Mail ${appeal.customer_email || 'Нет'}`
            }
        },
        {
            name: 'Номер',
            getValue: (appeal) => appeal.number
        },
        {
            name: 'Адрес',
            getValue: (appeal) => appeal.address || 'Нет'
        },
        {
            name: 'Стоимость',
            getValue: (appeal) => `${appeal.price} руб.`
        },
        {
            name: 'Стоимость доставки',
            getValue: (appeal) => `${appeal.delivery_price || 0} руб.`
        },
        {
            name: 'Итого',
            getValue: (appeal) => `${appeal.delivery_price + appeal.price} руб.`
        },
        {
            name: 'Истекает',
            getValue: (appeal) => appeal.expired || 'Не указано'
        },
    ],
    actions: [
        {
            name: 'Редактировать',
            trigger: (certificate) => router.get(route('certificates.show', certificate))
        }
    ],
    pagination: {
        isRequired: true,
    }
})

const defaultFilter = {
    certificate_id: null
}

const filter = useForm(defaultFilter)

const search = () => {
    filter.get(route('certificates.index'))
}

const reset = () => {
    filter.reset().get(route('certificates.index'))
}

onMounted(() => {
    filter.certificate_id = getCurrentUrlParam('certificate_id')
})
</script>

<template>
    <Head title="Таблица сертификатов"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Таблица сертификатов</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form class="space-y-6 mb-5" @submit.prevent="search">
                            <h2 class="font-semibold text-2xl">Фильтр</h2>
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-6">
                                    <InputLabel for="source" value="Номер сертификата"/>
                                    <select
                                        id="quest"
                                        v-model="filter.certificate_id"
                                        required
                                        class="appearance-none block w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option value="">
                                            Нет
                                        </option>
                                        <option v-for="certificateInstance in props.certificateInstances" :value="certificateInstance.id">
                                            {{ certificateInstance.number }}
                                        </option>
                                    </select>
                                    <InputError class="mt-2" :message="filter.errors.certificate_id"/>
                                </div>
                                <div class="col-span-6 sm:col-span-4">
                                    <button type="submit"
                                            class="flex w-full justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Искать
                                    </button>
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                    <button type="button"
                                            @click="reset()"
                                            class="flex w-full justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Сбросить
                                    </button>
                                </div>
                            </div>
                        </form>
                        <data-table :delete-many-route="route('certificates.destroy-many')" :create-link="route('certificates.create')" :table-props="tableProps" :items-resource="certificates"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
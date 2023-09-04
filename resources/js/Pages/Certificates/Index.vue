<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {onMounted, ref} from "vue";
import {getAlreadypaid, getOrderPriceToPay} from "@/Traits/OrderTrait";
import DataTable from "@/Components/Common/DataTable.vue";
import {Head, router, Link, useForm} from '@inertiajs/vue3';
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import {getCurrentUrlParam} from "@/Traits/Tools";
import {PencilIcon} from "@heroicons/vue/24/solid";

const props = defineProps({
    certificates: Object,
    certificateInstances: Array
})

const tableProps = ref({
    records: [
        {
            name: 'Номер',
            getValue: (certificate) => certificate.number
        },
        {
            name: 'Данные клиента',
            getValue: (certificate) => {
                return `Имя: ${certificate.customer_name || 'Нет'} <br/> Телефон ${certificate.customer_phone || 'Нет'} <br/> E-Mail ${certificate.customer_email || 'Нет'}`
            }
        },
        {
            name: 'Статус',
            getValue: (certificate) => certificate.customer_address || 'Нет'
        },
        {
            name: 'Адрес',
            getValue: (certificate) => certificate.customer_address || 'Нет'
        },
        {
            name: 'Стоимость',
            getValue: (certificate) => `${certificate.price} руб.`
        },
        {
            name: 'Доставка',
            getValue: (certificate) => `${certificate.delivery_cost || 0} руб.`
        },
        {
            name: 'Итого',
            getValue: (certificate) => `${certificate.delivery_cost + certificate.price} руб.`
        },
        {
            name: 'Оплачено',
            getValue: (certificate) => certificate.paid + ' руб.'
        },
        {
            name: 'Истекает',
            getValue: (certificate) => certificate.expires_at || 'Не указано'
        },
        {
            name: 'Комментарий',
            getValue: (certificate) => certificate.comment || 'Не указано'
        },
    ],
    actions: [
        {
            name: 'Редактировать',
            icon: PencilIcon,
            trigger: (certificate) => router.get(route('certificates.show', certificate))
        }
    ],
    pagination: {
        isRequired: true,
    }
})

const defaultFilter = {
    certificate_id: null,
    search_string: null,
}

const filter = useForm(defaultFilter)

const search = () => {
    filter.get(route('certificates.index'))
}

const reset = () => {
    filter.reset().get(route('certificates.index'))
}

onMounted(() => {
    filter.search_string = getCurrentUrlParam('search_string')
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
                                <div class="col-span-6 sm:col-span-3">
                                    <InputLabel for="search_string" value="Поиск"/>
                                    <TextInput
                                        id="search_string"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="filter.search_string"
                                        autofocus
                                    />
                                    <InputError class="mt-2" :message="filter.errors.search_string"/>
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <InputLabel for="number" value="Номер сертификата"/>
                                    <select
                                        id="number"
                                        v-model="filter.certificate_id"
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
                                <div class="col-span-6 sm:col-span-4"/>
                                <div class="col-span-6 sm:col-span-1">
                                    <button type="submit"
                                            class="flex w-full justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Искать
                                    </button>
                                </div>
                                <div class="col-span-6 sm:col-span-1">
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

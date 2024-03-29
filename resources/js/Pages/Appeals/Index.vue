\
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {onMounted, ref, watch} from "vue";
import {getAlreadypaid, getOrderPriceToPay} from "@/Traits/OrderTrait";
import DataTable from "@/Components/Common/DataTable.vue";
import {Head, router, Link, useForm} from '@inertiajs/vue3';
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import {getCurrentUrlParam} from "@/Traits/Tools";
import CertificateInstanceStatusSelect from "@/Components/Certificates/CertificateInstanceStatusSelect.vue";
import AppealStatusSelect from "@/Components/Appeals/AppealStatusSelect.vue";
import {PencilIcon} from "@heroicons/vue/24/solid";
import AppealModal from "@/Components/Appeals/AppealModal.vue";

const props = defineProps({
    appeals: Object,
    sourceList: Array,
    appealStatuses: Array,
    forms: Array
})

const edit = (appeal) => {
    showAppealModal(appeal)
}

const tableProps = ref({
    records: [
        {
            name: 'Данные клиента',
            getValue: (appeal) => {
                return `Имя: ${appeal.name || 'Нет'} <br/> Телефон ${appeal.phone || 'Нет'} <br/> E-Mail ${appeal.email || 'Нет'}`
            }
        },
        {
            name: 'Источник',
            getValue: (appeal) => appeal.source
        },
        {
            name: 'Статус',
            getValue: (item) => ({
                component: AppealStatusSelect,
                meta: {
                    appealStatuses: props.appealStatuses,
                    item
                }
            })
        },
        {
            name: 'Форма',
            getValue: (appeal) => appeal.form
        },
        {
            name: 'Создано',
            getValue: (appeal) => appeal.created_at
        },
        {
            name: 'Комментарий',
            getValue: (appeal) => appeal.comment,
            getRowStyle: (item) => {
                return 'white-space: normal !important;max-width: 150px;white-space: normal !important;'
            },
        }
    ],
    actions: [
        {
            name: 'Редактировать',
            icon: PencilIcon,
            trigger: edit
        },
    ],
    pagination: {
        isRequired: true,
    }
})

const defaultFiler = {
    source: ''
}

onMounted(() => {
    filter.source = getCurrentUrlParam('source')
})

const filter = useForm(defaultFiler)

const search = () => {
    filter.get(route('appeals.index'))
}

const reset = () => {
    filter.reset().get(route('appeals.index'))
}

const appealModal = ref({
    show: false,
    appeal: {},
    mode: 0,
})

const showAppealModal = (appeal = {}) => {
    appealModal.value.show = true
    appealModal.value.appeal = appeal
    appealModal.value.mode = appeal?.id ? 1 : 0
}

watch(appealModal, value => {
    // console.log(value)
}, {deep: true})
</script>

<template>
    <Head title="Таблица заявок"/>
    <appeal-modal
        :statuses="appealStatuses"
        :forms="forms"
        :sources="sourceList"
        v-model="appealModal"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Таблица заявок</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form class="space-y-6 mb-5" @submit.prevent="search">
                            <h2 class="font-semibold text-2xl">Фильтр</h2>
                            <div class="grid grid-cols-6 gap-6 flex items-center">
                                <div class="col-span-6 sm:col-span-2">
                                    <InputLabel for="source" value="Страницы, с которых пришел запрос"/>
                                    <select
                                        id="quest"
                                        v-model="filter.source"
                                        required
                                        class="appearance-none block w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option value="">
                                            Нет
                                        </option>
                                        <option v-for="source in props.sourceList" :value="source">
                                            {{ source }}
                                        </option>
                                    </select>
                                    <InputError class="mt-2" :message="filter.errors.source"/>
                                </div>
                                <div class="col-span-6 sm:col-span-2 mt-5">
                                    <button type="submit"
                                            class="flex w-full justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Искать
                                    </button>
                                </div>
                                <div class="col-span-6 sm:col-span-2 mt-5">
                                    <button type="button"
                                            @click="reset()"
                                            class="flex w-full justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Сбросить
                                    </button>
                                </div>
                            </div>
                        </form>
                        <data-table :delete-many-route="route('appeals.destroy-many')" :table-props="tableProps"
                                    :items-resource="appeals"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

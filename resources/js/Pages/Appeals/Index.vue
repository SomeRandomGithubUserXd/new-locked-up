\<script setup>
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
    appeals: Object,
    sourceList: Array
})

const edit = (appeal) => {
    router.get(route('appeals.show', appeal))
}

const tableProps = ref({
    records: [
        {
            name: 'Контактные данные',
            getValue: (appeal) => {
                return `Имя: ${appeal.name || 'Нет'} <br/> Телефон ${appeal.phone || 'Нет'} <br/> E-Mail ${appeal.email || 'Нет'}`
            }
        },
        {
            name: 'Источник',
            getValue: (appeal) => appeal.source
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
            name: 'Статус',
            getValue: (appeal) => appeal.status
        },
        {
            name: 'Комментарий',
            getValue: (appeal) => appeal.comment
        }
    ],
    actions: [
        {
            name: 'Редактировать',
            trigger: edit
        }
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

const deleteMany = (ids) => {
    if (confirm('Вы уверены?')) {
        router.post(route('appeals.destroy-many'), {
            ids
        })
    }
}
</script>

<template>
    <Head title="Таблица заявок"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Таблица заявок</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form class="space-y-6 mb-5" @submit.prevent="search">
                            <h2 class="font-semibold text-2xl">Фильтр</h2>
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-6">
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
                        <data-table @delete-many="deleteMany" :table-props="tableProps" :items-resource="appeals"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

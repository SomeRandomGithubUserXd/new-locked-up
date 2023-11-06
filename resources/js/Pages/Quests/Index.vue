<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DataTable from "@/Components/Common/DataTable.vue";
import {onMounted, ref} from "vue";
import {useRouter} from "vue-router";

const router = useRouter()

const dataToPreload = ref(null)

onMounted(() => {
    axios.get(route('quests.index')).then((resp) => {
        dataToPreload.value = resp.data
        console.log(dataToPreload.value)
    })
})

const tableProps = ref({
    records: [
        {
            name: 'Название',
            getValue: (quest) => {
                return quest.name || 'Нет'
            },
        },
        {
            name: 'Порядок',
            getValue: (quest) => {
                return quest.order || 'Не указан'
            },
        },
        {
            name: 'Доступен',
            getValue: (quest) => {
                return quest.is_active
            },
        },
        {
            name: 'Просмотров',
            getValue: (quest) => {
                return quest.views || 0
            },
        },
    ],
    actions: [
        {
            name: 'Редактировать',
            trigger: (quest) => {
                router.push(`/quests/${quest.id}`)
            }
        }
    ],
    pagination: {
        isRequired: true,
    }
})
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Таблица квестов</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <data-table :delete-many-route="route('quests.destroy-many')" :create-link="'/quests/create'"
                                    :table-props="tableProps" :items-resource="dataToPreload"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

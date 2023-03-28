<script setup>
import {Head, router} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {ref} from "vue";
import DataTable from "@/Components/Common/DataTable.vue";

const props = defineProps({
    news: Object
})

const tableProps = ref({
    records: [
        {
            name: 'Заголовок',
            getValue: (news) => news.header
        },
        {
            name: 'URL',
            getValue: (news) => news.alias
        },
        {
            name: 'Добавлена',
            getValue: (news) => news.created_at
        },
        {
            name: 'Опубликована',
            getValue: (news) => news.is_published
        },
    ],
    actions: [
        {
            name: 'Редактировать',
            trigger(news) {
                router.get(route('news.show', news.id))
            }
        }
    ],
    pagination: {
        isRequired: true,
    }
})
</script>

<template>
    <Head title="Таблица новостей"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Таблица новостей</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <data-table :create-link="route('news.create')"
                                    :delete-many-route="route('news.destroy-many')" :table-props="tableProps"
                                    :items-resource="props.news"/>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

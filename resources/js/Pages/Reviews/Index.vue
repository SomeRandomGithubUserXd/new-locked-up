<script setup>
import {Head, router} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {ref} from "vue";
import DataTable from "@/Components/Common/DataTable.vue";

const props = defineProps({
    reviews: Object
})

const tableProps = ref({
    records: [
        {
            name: 'Название',
            getValue: (review) => review.name
        },
        {
            name: 'Квест',
            getValue: (review) => review.quest
        },
        {
            name: 'Рейтинг',
            getValue: (review) => review.rate
        },
        {
            name: 'Одобрено',
            getValue: (review) => review.approved
        },
    ],
    actions: [
        {
            name: 'Редактировать',
            trigger(review) {
                router.get(route('reviews.show', review.id))
            }
        }
    ],
    pagination: {
        isRequired: true,
    }
})
</script>

<template>
    <Head title="Таблица отзывов"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Таблица отзывов</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <data-table :create-link="route('reviews.create')"
                                    :delete-many-route="route('reviews.destroy-many')" :table-props="tableProps"
                                    :items-resource="props.reviews"/>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<script setup>
import {Head, router} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {ref} from "vue";
import DataTable from "@/Components/Common/DataTable.vue";

const props = defineProps({
    questTopics: Object
})

const tableProps = ref({
    records: [
        {
            name: 'Название',
            getValue: (location) => location.name
        },
    ],
    actions: [
        {
            name: 'Редактировать',
            trigger(topic) {
                router.get(route('child-quest-topics.show', topic))
            }
        }
    ],
    pagination: {
        isRequired: true,
    }
})
</script>

<template>
    <Head title="Таблица детских рубрик"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Таблица детских рубрик</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <data-table :create-link="route('child-quest-topics.create')"
                                    :delete-many-route="route('child-quest-topics.destroy-many')" :table-props="tableProps"
                                    :items-resource="props.questTopics"/>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

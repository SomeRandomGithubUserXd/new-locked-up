<script setup>
import {Head, router} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {ref} from "vue";
import DataTable from "@/Components/Common/DataTable.vue";

const props = defineProps({
    lounges: Object
})

const tableProps = ref({
    records: [
        {
            name: 'Название',
            getValue: (lounge) => lounge.name_ru
        },
        {
            name: 'Активен',
            getValue: (lounge) => lounge.is_active
        },
    ],
    actions: [
        {
            name: 'Редактировать',
            trigger(lounge) {
                router.get(route('lounges.show', lounge))
            }
        }
    ],
    pagination: {
        isRequired: true,
    }
})
</script>

<template>
    <Head title="Таблица лаунжей"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Таблица лаунжей</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <data-table :create-link="route('lounges.create')"
                                    :delete-many-route="route('lounges.destroy-many')" :table-props="tableProps"
                                    :items-resource="props.lounges"/>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

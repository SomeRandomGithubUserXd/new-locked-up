a<script setup>
import {Head, router} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {ref} from "vue";
import DataTable from "@/Components/Common/DataTable.vue";

const props = defineProps({
    users: Object
})

const tableProps = ref({
    records: [
        {
            name: 'Имя пользователя',
            getValue: (user) => user.username
        },
        {
            name: 'E-Mail',
            getValue: (user) => user.email
        },
        {
            name: 'Роль',
            getValue: (user) => user.role
        },
        {
            name: 'Дата регистрации',
            getValue: (user) => user.created_at
        },
        {
            name: 'Последний раз был в сети',
            getValue: (user) => user.logged_at
        },
    ],
    actions: [
        {
            name: 'Редактировать',
            trigger(user) {
                router.get(route('users.show', user.id))
            }
        }
    ],
    pagination: {
        isRequired: true,
    }
})
</script>

<template>
    <Head title="Таблица пользователей"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Таблица пользователей</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <data-table :create-link="route('users.create')"
                                    :delete-many-route="route('users.destroy-many')" :table-props="tableProps"
                                    :items-resource="props.users"/>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

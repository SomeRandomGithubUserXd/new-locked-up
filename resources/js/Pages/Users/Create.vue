<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import LocationForm from "@/Components/Locations/LocationForm.vue";
import QuestOptionForm from "@/Components/Quest/QuestOptionForm.vue";
import QuestTopicForm from "@/Components/QuestTopics/QuestTopicForm.vue";
import UserForm from "@/Components/Users/UserForm.vue";

const props = defineProps({
    userRoles: Array,
    locations: Array,
})

const user = useForm({
    'username': '',
    'email': '',
    'name': '',
    'surname': '',
    'patronymic': '',
    'birth_date': '',
    'passport': '',
    'phone': '',
    'role': '',
    'location_ids': '',
    'password': '',
    'password_confirmation': ''
})

const store = () => {
    user.post(route('users.store'), {
        onError: (errs) => {
            console.log(errs)
        }
    })
}
</script>

<template>
    <Head title="Добавить пользователя"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Добавить пользователя</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <user-form :locations="props.locations" :user-roles="props.userRoles" @submit="store"
                                   v-model="user"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

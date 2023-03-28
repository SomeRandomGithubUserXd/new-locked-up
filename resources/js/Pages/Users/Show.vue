<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import LocationForm from "@/Components/Locations/LocationForm.vue";
import QuestOptionForm from "@/Components/Quest/QuestOptionForm.vue";
import QuestTopicForm from "@/Components/QuestTopics/QuestTopicForm.vue";
import UserForm from "@/Components/Users/UserForm.vue";

const props = defineProps({
    user: Object,
    userRoles: Array,
    locations: Array,
})

const userToUpdate = useForm(props.user)

const update = () => {
    userToUpdate.patch(route('users.update', props.user.id), {
        onError: (errs) => {
            console.log(errs)
        }
    })
}
</script>

<template>
    <Head title="Редактировать пользователя"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Редактировать пользователя</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <user-form :locations="props.locations" :user-roles="props.userRoles" @submit="update"
                                   v-model="userToUpdate"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import LocationForm from "@/Components/Locations/LocationForm.vue";
import QuestOptionForm from "@/Components/Quest/QuestOptionForm.vue";
import QuestTopicForm from "@/Components/QuestTopics/QuestTopicForm.vue";
import LoungeForm from "@/Components/Lounges/LoungeForm.vue";

const lounge = useForm({
    name_ru: '',
    name_en: '',
    is_active: true,
})

const update = () => {
    lounge.post(route('lounges.store'), {
        onError: (errs) => {
            console.log(errs)
        }
    })
}
</script>

<template>
    <Head title="Добавить лаунж"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Добавить лаунж</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <lounge-form @submit="update" v-model="lounge"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import LocationForm from "@/Components/Locations/LocationForm.vue";
import QuestOptionForm from "@/Components/Quest/QuestOptionForm.vue";
import QuestTopicForm from "@/Components/QuestTopics/QuestTopicForm.vue";
import OrderSourceForm from "@/Components/Orders/OrderSourceForm.vue";

const source = useForm({
    name: '',
    aggregator: false,
    color: '#fafafa'
})

const update = () => {
    source.post(route('order-sources.store'), {
        onError: (errs) => {
            console.log(errs)
        }
    })
}
</script>

<template>
    <Head title="Добавить источник"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Добавить источник</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <order-source-form @submit="update" v-model="source"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

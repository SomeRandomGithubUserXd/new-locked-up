<script setup>
import {Head, router, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";

const schedule = useForm({
    name: '',
    name_en: '',
})
const store = () => {
    schedule.post(route('lounge-schedules.store'))
}
</script>

<template>
    <Head title="Создать расписание"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Создать расписание</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form class="space-y-6" @submit.prevent="store">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-6">
                                    <input-label for="name" value="Наименование"/>
                                    <text-input
                                        id="name"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="schedule.name"
                                        autofocus
                                    />
                                    <input-error class="mt-2" :message="schedule.errors.name"/>
                                </div>
                            </div>
                            <button type="submit"
                                    class="w-full mb-5 shadow flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Сохранить
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

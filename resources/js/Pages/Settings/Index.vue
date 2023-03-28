<script setup>
import {Head, router, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DataTable from "@/Components/Common/DataTable.vue";
import {ref} from "vue";
import SettingsForm from "@/Components/Settings/SettingsForm.vue";

const props = defineProps({
    settings: Array
})

const settingsToUpdate = useForm(props.settings)
console.log(settingsToUpdate)
</script>

<template>
    <Head title="Настройки"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Настройки</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <settings-form v-model="settingsToUpdate"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

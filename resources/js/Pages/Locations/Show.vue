<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import LocationForm from "@/Components/Locations/LocationForm.vue";

const props = defineProps({
    location: Object
})

const locationToUpdate = useForm(props.location)
</script>

<template>
    <Head title="Редактировать локацию"/>

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <location-form v-model="locationToUpdate"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

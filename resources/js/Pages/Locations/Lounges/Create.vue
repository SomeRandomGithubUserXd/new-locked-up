<script setup>
import {useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {orderProps} from "@/Traits/OrderTrait";
import OrderFilter from "@/Components/Orders/OrderFilter.vue";
import {Head} from "@inertiajs/vue3";
import LocationForm from "@/Components/Locations/LocationForm.vue";
import LocationLoungeForm from "@/Components/Locations/LocationLoungeForm.vue";

const props = defineProps({
    locationId: Number
})

const lounge = useForm({
    name_ru: '',
    name_en: '',
    description_ru: '',
    description_en: '',
    gallery_id: 0,
})

const storeLounge = () => {
    lounge.post(route('locations.location_lounges.store', props.locationId))
}
</script>

<template>
    <Head title="Добавить лаунж к локации"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Добавить лаунж к локации</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <location-lounge-form @submit="storeLounge" v-model="lounge"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

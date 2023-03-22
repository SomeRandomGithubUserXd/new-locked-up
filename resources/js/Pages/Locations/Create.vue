<script setup>
import {useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {orderProps} from "@/Traits/OrderTrait";
import OrderFilter from "@/Components/Orders/OrderFilter.vue";
import {Head} from "@inertiajs/vue3";
import LocationForm from "@/Components/Locations/LocationForm.vue";

const location = useForm({
    name_ru: '',
    name_en: '',
    address_ru: '',
    show_at_kids_page: false,
    show_at_corporate_parties_page: false,
    phone: '',
    email: '',
    latitude: '',
    longitude: '',
})

const storeLocation = () => {
    location.post(route('locations.store'))
}
</script>

<template>
    <Head title="Добавить локацию"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Добавить локацию</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <location-form @submit="storeLocation" v-model="location"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

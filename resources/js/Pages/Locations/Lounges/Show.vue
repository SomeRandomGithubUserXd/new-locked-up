<script setup>
import {useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {orderProps} from "@/Traits/OrderTrait";
import OrderFilter from "@/Components/Orders/OrderFilter.vue";
import {Head} from "@inertiajs/vue3";
import LocationForm from "@/Components/Locations/LocationForm.vue";
import LocationLoungeForm from "@/Components/Locations/LocationLoungeForm.vue";
import InputLabel from "@/Components/InputLabel.vue";
import DataTable from "@/Components/Common/DataTable.vue";

const props = defineProps({
    locationId: Number,
    lounge: Object
})

const loungeToUpdate = useForm(props.lounge)

const updateLounge = () => {
    loungeToUpdate.patch(route('locations.location_lounges.update', {
        location: props.locationId,
        location_lounge: props.lounge.id
    }))
}
</script>

<template>
    <Head title="Редактировать лаунж у локации"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Редактировать лаунж у локации</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <location-lounge-form @submit="updateLounge" v-model="loungeToUpdate"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

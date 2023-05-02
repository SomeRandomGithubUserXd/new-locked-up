<script setup>
import {useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {orderProps} from "@/Traits/OrderTrait";
import OrderFilter from "@/Components/Orders/OrderFilter.vue";
import {Head} from "@inertiajs/vue3";
import ServiceForm from "@/Components/Services/ServiceForm.vue";

const service = useForm({
    name_ru: '',
    name_en: '',
})

const storeService = () => {
    service.post(route('services.store'))
}
</script>

<template>
    <Head title="Добавить услугу"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Добавить услугу</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <service-form
                            @submit="storeService"
                            v-model="service"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

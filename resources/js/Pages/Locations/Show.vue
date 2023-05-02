<script setup>
import {Head, router, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import LocationForm from "@/Components/Locations/LocationForm.vue";
import {computed} from "vue";
import InputLabel from "@/Components/InputLabel.vue";
import DataTable from "@/Components/Common/DataTable.vue";

const props = defineProps({
    location: Object
})

const locationToUpdate = useForm(props.location)

const update = () => {
    locationToUpdate.patch(route('locations.update', props.location), {
        onError: (errs) => {
            console.log(errs)
        }
    })
}
const loungeTableProps = computed({
    get: () => {
        return {
            records: [
                {
                    name: '№',
                    getValue: (item) => {
                        return item.id
                    },
                },
                {
                    name: 'Название',
                    getValue: (item) => {
                        return item.name_ru
                    },
                },
            ],
            pagination: {
                isRequired: false,
            },
            actions: [
                {
                    name: 'Редактировать',
                    trigger(item) {
                        console.log(props.location.id, item.id)
                        router.get(route('locations.location_lounges.show', {
                            location: props.location.id,
                            location_lounge: item.id
                        }))
                    }
                },
                {
                    name: 'Удалить',
                    trigger(item) {
                        router.delete(route('locations.location_lounges.destroy', {
                            location: props.location.id,
                            location_lounge: item.id
                        }))
                    }
                },
            ],
        }
    },
    set: () => {
    },
})
</script>

<template>
    <Head title="Редактировать локацию"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Редактировать локацию</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <location-form @submit="update" v-model="locationToUpdate"/>
                        <div class="col-span-6 sm:col-span-6 mt-5">
                            <input-label for="phone" value="Лаунжи"/>
                            <data-table
                                class="mt-3"
                                :create-link="route('locations.location_lounges.create', props.location.id)"
                                :allow-deletion="false"
                                :needs-selection="false"
                                :table-props="loungeTableProps"
                                :raw-data="props.location.lounges.data"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import {Head, router, useForm} from "@inertiajs/vue3";
import {computed, ref, watch} from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ScheduleForm from "@/Components/Schedules/ScheduleForm.vue";

const props = defineProps({
    schedule: Object
})

watch(() => props.schedule, value => {
    scheduleToUpdate.value = useForm(value)
})

const scheduleToUpdate = ref(useForm(props.schedule))


const handleUpdate = (val) => {
    scheduleToUpdate.value = val
}

const update = () => {
    scheduleToUpdate.value.patch(route('lounge-schedules.update', props.schedule.id))
}

const addItem = (type) => {
    router.post(route('lounge-schedule-items.store', props.schedule.id), {
        type
    })
}
</script>

<template>
    <Head title="Редактировать расписание"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Редактировать расписание</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <schedule-form
                            @add-item="addItem"
                            @submit="update"
                            :model-value="scheduleToUpdate"
                            destroy-route="lounge-schedule-items.destroy"
                            @update:model-value="handleUpdate"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

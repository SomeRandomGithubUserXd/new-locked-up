<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import {useForm} from "@inertiajs/vue3";
import AppealForm from "@/Components/Appeals/AppealForm.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";

const props = defineProps({
    appeal: Object,
    statuses: Array,
    sources: Array,
    forms: Array,
})

const save = () => {
    appealToUpdate.patch(route('appeals.update', props.appeal))
}

const appealToUpdate = useForm(props.appeal)
</script>

<template>
    <Head title="Редактировать заявку"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Редактировать заявку</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <appeal-form
                            v-model="appealToUpdate"
                            @submit="save"
                            :statuses="props.statuses"
                            :sources="props.sources"
                            :forms="props.forms"
                            :is-editable="true"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

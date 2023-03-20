<script setup>
import {useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {orderProps} from "@/Traits/OrderTrait";
import OrderFilter from "@/Components/Orders/OrderFilter.vue";
import {Head} from "@inertiajs/vue3";

const props = defineProps({
    filter: Object,
    ...orderProps
})

const filterToEdit = useForm(props.filter)

const updateFilter = () => {
    filterToEdit.patch(route('order-filters.update', props.filter.id))
}
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Редактировать фильтр"/>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Редактировать фильтр</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <order-filter
                            @submit="updateFilter"
                            :quest-list="props.questList"
                            :option-list="props.optionList"
                            :source-list="props.sourceList"
                            :promo-code-list="props.promoCodeList"
                            :certificate-list="props.certificateList"
                            :order-statuses="props.orderStatuses"
                            :quest-options="props.questOptions"
                            :is-limited="true"
                            :is-production="false"
                            v-model="filterToEdit"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

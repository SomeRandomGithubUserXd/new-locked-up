<script setup>
import {useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {orderProps} from "@/Traits/OrderTrait";
import OrderFilter from "@/Components/Orders/OrderFilter.vue";
import {Head} from "@inertiajs/vue3";

const props = defineProps(orderProps)
const filter = useForm({
    name: '',
    date_from: '',
    date_to: '',
    quest_ids: [],
    order_id: '',
    source_ids: [],
    statuses: [],
    promo_code_ids: [],
    with_options_only: false,
    order_by: '',
})

const storeFilter = () => {
    filter.post(route('order-filters.store'))
}
</script>

<template>
    <Head title="Добавить фильтр"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Добавить фильтр</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <order-filter
                            @submit="storeFilter"
                            :quest-list="props.questList"
                            :option-list="props.optionList"
                            :source-list="props.sourceList"
                            :promo-code-list="props.promoCodeList"
                            :certificate-list="props.certificateList"
                            :order-statuses="props.orderStatuses"
                            :quest-options="props.questOptions"
                            :is-production="false"
                            :is-limited="true"
                            v-model="filter"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

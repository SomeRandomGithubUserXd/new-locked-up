<script setup>
import Pagination from "@/Components/Common/Pagination.vue";
import {computed, ref, watch} from "vue";
import {collect} from "collect.js";
import {TrashIcon} from "@heroicons/vue/24/solid";
import {Link, router} from "@inertiajs/vue3";
import {PencilIcon} from "@heroicons/vue/24/solid";
import {data} from "autoprefixer";

const props = defineProps({
    tableProps: [Object, Array],
    itemsResource: Object,
    rawData: {
        required: false,
        default: [],
        type: Array
    },
    needsSelection: {
        required: false,
        default: true,
        type: Boolean
    },
    deleteManyRoute: {
        required: false,
        default: '',
        type: String
    },
    createLink: String
})

const triggerAllItemsSelectionCheckbox = ref(null)

const deleteMany = () => {
    if (props.deleteManyRoute) {
        if (confirm('Вы уверены?')) {
            router.post(props.deleteManyRoute, {
                ids: selectedItems.value
            }, {
                onSuccess: params => {
                    triggerAllItemsSelectionCheckbox.value.checked = false
                }
            })
        }
    }
}

const selectedItems = ref([])

const triggerAllItemsSelection = (val) => {
    if (val.target.checked) {
        selectedItems.value = collect(props.itemsResource?.data).pluck('id').all()
    } else {
        selectedItems.value = []
    }
}

const hasAnyItems = computed({
    get: () => {
        return props.itemsResource?.meta?.total || props.rawData.length
    },
    set: () => {
    }
})
</script>

<template>
    <div class="flex flex-col">
        <div class="flex justify-between pb-3">
            <button @click="deleteMany" type="button" v-if="hasAnyItems && deleteManyRoute"
                    :disabled="!selectedItems.length"
                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                <TrashIcon class="h-5 w-5 text-gray-400 mr-2" aria-hidden="true"/>
                <span>Удалить</span>
            </button>
            <Link v-if="props.createLink" :href="createLink"
                  class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                <PencilIcon class="h-5 w-5 text-gray-400 mr-2" aria-hidden="true"/>
                <span>Создать</span>
            </Link>
        </div>
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div v-if="hasAnyItems"
                 class="py-2 align-middle inline-block min-w-full sm:px-3 lg:px-8 max-w-full">
                <div
                    class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg overflow-scroll">
                    <table class="min-w-full divide-y divide-gray-200 font-size-all">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                v-if="needsSelection"
                                class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <span class="sr-only">Выбрать</span>
                                <input ref="triggerAllItemsSelectionCheckbox" @change="triggerAllItemsSelection"
                                       type="checkbox"
                                       class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"/>
                            </th>
                            <th scope="col"
                                v-for="record in props.tableProps?.records"
                                class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <span v-html="record.name"/>
                            </th>
                            <th scope="col"
                                v-if="props.tableProps?.actions?.length"
                                class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="item in props.itemsResource?.data || props.rawData">
                            <td
                                v-if="needsSelection"
                                class="px-2 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <div class="flex items-center h-5">
                                    <input :value="item.id" v-model="selectedItems" type="checkbox"
                                           class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"/>
                                </div>
                            </td>
                            <td v-for="record in props.tableProps?.records"
                                :style="record?.getRowStyle ? record?.getRowStyle(item) : ''"
                                class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                                <template v-if="typeof record.getValue(item) === 'object' && record.getValue(item)?.component">
                                    <component :meta="record.getValue(item).meta"
                                               :is="record.getValue(item).component"/>
                                </template>
                                <span v-else v-html="record.getValue(item)"/>
                            </td>
                            <td
                                v-if="props.tableProps.actions?.length"
                                class="px-3 py-4 whitespace-nowrap text-sm text-gray-500 flex d-flex flex-col">
                                <span @click="action.trigger(item)" class="text-indigo-600 cursor-pointer mb-3"
                                      v-for="action in props.tableProps?.actions">
                                    <component class="w-5 h-5 mr-3" v-if="action.icon" :is="action.icon"/>
                                    <span v-else>{{ action.name }}</span>
                                </span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <pagination
                    v-if="props.tableProps?.pagination?.isRequired && hasAnyItems"
                    :current-page="props.itemsResource?.meta?.current_page"
                    :max-page="props.itemsResource?.meta?.last_page"/>
            </div>
            <div class="text-center" v-else>
                Нет данных
            </div>
        </div>
    </div>

</template>

<style scoped>
.font-size-all * {
    font-size: 15px;
}
</style>

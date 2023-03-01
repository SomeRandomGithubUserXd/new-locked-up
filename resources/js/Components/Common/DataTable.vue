<script setup>
import Pagination from "@/Components/Common/Pagination.vue";
import {ref, watch} from "vue";
import {collect} from "collect.js";
import {TrashIcon} from "@heroicons/vue/24/solid";
import {Link} from "@inertiajs/vue3";
import {PencilIcon} from "@heroicons/vue/24/solid";

const props = defineProps({
    tableProps: Object,
    itemsResource: Object,
    createLink: String
})

const emit = defineEmits(['deleteMany'])

const selectedItems = ref([])

const triggerAllItemsSelection = (val) =>
{
    if(val.target.checked)
    {
        selectedItems.value = collect(props.itemsResource.data).pluck('id').all()
    } else {
        selectedItems.value = []
    }
}

const deleteMany = () =>
{
    emit('deleteMany', selectedItems.value)
}
</script>

<template>
    <div class="flex flex-col">
        <div class="flex justify-between pb-3">
            <button @click="deleteMany" type="button" :disabled="!selectedItems.length" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                <TrashIcon class="h-5 w-5 text-gray-400 mr-2" aria-hidden="true" />
                <span>Удалить</span>
            </button>
            <Link v-if="props.createLink" :href="createLink" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                <PencilIcon class="h-5 w-5 text-gray-400 mr-2" aria-hidden="true" />
                <span>Создать</span>
            </Link>
        </div>
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8 max-w-full">
                <div
                    class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg overflow-scroll">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Выбрать</span>
                                <input @change="triggerAllItemsSelection" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" />
                            </th>
                            <th scope="col"
                                v-for="record in props.tableProps.records"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ record.name }}
                            </th>
                            <th scope="col"
                                v-if="props.tableProps.actions.length"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Действия
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="item in props.itemsResource.data">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <div class="ml-3 flex items-center h-5">
                                    <input :value="item.id" v-model="selectedItems" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" />
                                </div>
                            </td>
                            <td v-for="record in props.tableProps.records"
                                :style="record?.rowStyle"
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span v-html="record.getValue(item)"/>
                            </td>
                            <td
                                v-if="props.tableProps.actions.length"
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <a @click="action.trigger(item)" class="text-indigo-600" v-for="action in props.tableProps.actions" href="#">
                                    {{ action.name }}
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <pagination
                    v-if="props.tableProps.pagination.isRequired"
                    :on-page-change="props.tableProps.pagination?.onPageChange"
                    :current-page="props.itemsResource.meta.current_page"
                    :max-page="props.itemsResource.meta.last_page"/>
            </div>
        </div>
    </div>

</template>

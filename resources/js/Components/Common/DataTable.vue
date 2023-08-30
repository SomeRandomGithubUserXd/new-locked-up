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

const hintBlocks = ref([]);

const getHalfOfAColor = (color) => {
    return color.replace(', 1)', ', 0.7)')
}
</script>

<template>
    <div class="flex flex-col">
        <div class="flex justify-between pb-3 desktop-only">
            <button @click="deleteMany" type="button" v-if="hasAnyItems && deleteManyRoute"
                    :disabled="!selectedItems.length"
                    class="relative inline-flex items-center px-4 py-2 border border-red-500 text-sm font-medium rounded-md focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                <span class="text-red-500 font-bold mr-2">Удалить</span>
                <TrashIcon class="h-5 w-5 text-red-500" aria-hidden="true"/>
            </button>
            <Link v-if="props.createLink" :href="createLink"
                  class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                <PencilIcon class="h-5 w-5 text-gray-400 mr-2" aria-hidden="true"/>
                <span>Создать</span>
            </Link>
        </div>
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8 rounded-3xl">
            <div v-if="hasAnyItems"
                 class="py-2 align-middle inline-block min-w-full sm:px-3 lg:px-8 max-w-full">
                <div
                    class="shadow overflow-hidden border-b border-gray-200 sm:rounded-2xl overflow-scroll">
                    <table class="min-w-full divide-y divide-gray-200 font-size-all">
                        <thead style="background: rgba(249, 250, 251, 1);color: rgba(113, 113, 113, 1);">
                        <tr>
                            <th scope="col"
                                v-if="needsSelection"
                                class="px-2 text-left font-medium   tracking-wider">
                                <span class="sr-only">Выбрать</span>
                                <input ref="triggerAllItemsSelectionCheckbox" @change="triggerAllItemsSelection"
                                       type="checkbox"
                                       class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"/>
                            </th>
                            <th scope="col"
                                v-for="record in props.tableProps?.records"
                                class="px-3 py-4 text-left font-bold  tracking-wider">
                                <span class="text-2xl" v-html="record.name"/>
                            </th>
                            <th scope="col"
                                v-if="props.tableProps?.actions?.length"
                                class="px-3 py-4 text-left font-medium   tracking-wider">
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        <template v-for="item in props.itemsResource?.data || props.rawData">
                            <tr @click.prevent="hintBlocks[item.id] = !hintBlocks[item.id]">
                                <td
                                    @click.stop
                                    v-if="needsSelection"
                                    class="px-2 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <div class="flex items-center h-5">
                                        <input :value="item.id" v-model="selectedItems" type="checkbox"
                                               class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"/>
                                    </div>
                                </td>
                                <td v-for="record in props.tableProps?.records"
                                    :style="record?.getRowStyle ? record?.getRowStyle(item) : ''"
                                    class="px-3 whitespace-nowrap text-sm  py-5">
                                    <template
                                        @click.stop
                                        v-if="typeof record.getValue(item) === 'object' && record.getValue(item)?.component">
                                        <component @click.stop :meta="record.getValue(item).meta"
                                                   :is="record.getValue(item).component"/>
                                    </template>
                                    <span @click.stop v-else v-html="record.getValue(item)"/>
                                </td>
                                <td
                                    class="px-3  whitespace-nowrap text-sm  h-full">
                                    <div class="flex d-flex items-center gap-x-3 h-full" @click.stop>

                                        <template v-for="action in props.tableProps?.actions">
                                <span v-if="typeof action?.condition === 'function' ? action?.condition(item) : true"
                                      @click="action.trigger(item)"
                                      class="text-gray-500 hover:text-indigo-600 transition-all cursor-pointer">
                                    <component class="w-5 h-5" v-if="action.icon" :is="action.icon"/>
                                    <span v-else>{{ action.name }}</span>
                                </span>
                                        </template>
                                    </div>
                                </td>
                            </tr>
                            <tr :hidden="!hintBlocks[item.id]" v-if="item.hints" class="w-full h-full">
                                <td></td>
                                <td
                                    :style="`background: ${getHalfOfAColor(item.hints.backgroundColor)};color: ${item.hints.color}`"
                                    colspan="999"
                                    class="px-2 whitespace-nowrap text-sm font-medium w-full h-full">
                                    <div class="py-4 px-1 grid grid-rows-2 grid-flow-col">
                                        <div v-for="hint in item.hints.items">
                                            <span class="font-medium" :style="`color: ${getHalfOfAColor(item.hints.color)}`">
                                                {{hint.name}}: &nbsp;
                                            </span>
                                            <span :style="`color: ${item.hints.color}`">
                                                {{hint.value}}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </template>
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
    font-size: 17px;
}
</style>

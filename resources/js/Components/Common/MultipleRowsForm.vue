<script setup>
import TextInput from "@/Components/TextInput.vue";
import {collect} from "collect.js";
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    modelValue: {
        required: false,
        default: [],
        type: Array
    },
    tableProps: Object
})

const emit = defineEmits(['update:modelValue'])

const handleUpdate = (val, item, row) => {
    let updated = props.modelValue
    updated.find(element => element.id === item.id)[row.attribute] = val
    emit('update:modelValue', updated)
}
</script>

<template>
    <div>
        <table class="min-w-full divide-y divide-gray-200 font-size-all">
            <thead class="bg-gray-50">
            <tr>
                <th scope="col"
                    v-for="item in props.tableProps?.data"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ item.name }}
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Действия
                </th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="item in props.modelValue">
                <td v-for="row in props.tableProps?.data"
                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <TextInput
                        id="name"
                        :disabled="row?.disabled || false"
                        :type="row.type"
                        class="mt-1 block w-full" :model-value="item[row.attribute]"
                        @update:model-value="handleUpdate($event, item, row)"/>
                </td>
                <td v-for="row in props.tableProps?.actions"
                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <a href="#" class="text-indigo-600" @click.prevent="row.action(item)">{{ row.name }}</a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

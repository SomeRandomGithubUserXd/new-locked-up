<script setup>
const props = defineProps({
    item: Object
})
</script>

<template>
    <div>
        <select :value="props.item.certificate_data_id"
                id="type"
                class="appearance-none mt-auto block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">>
            <option :value="type.key" v-for="type in []">
                {{ type.name }}
            </option>
        </select>
    </div>
</template>

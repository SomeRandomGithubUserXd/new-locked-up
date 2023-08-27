<script setup>
const props = defineProps({
    meta: Object
})

// TODO: complete
</script>

<template>
    <div>
        <select :value="props.meta.item.status"
                id="type"
                class="appearance-none mt-auto block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">>
            <option :value="status" v-for="status in props.meta.appealStatuses">
                {{ status }}
            </option>
        </select>
    </div>
</template>

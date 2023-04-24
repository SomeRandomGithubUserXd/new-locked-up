<script setup>
const props = defineProps({
    meta: Object
})

// TODO: complete
</script>

<template>
    <div>
        <select :value="props.meta.item.certificate_data_id"
                id="type"
                style="max-width: 100px"
                class="appearance-none mt-auto block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">>
            <option :value="certificate.id" v-for="certificate in props.meta.certificateList">
                {{ certificate.number }}
            </option>
        </select>
    </div>
</template>

<script setup>
import {ref} from "vue";

const props = defineProps({
    meta: Object
})
</script>

<template>
    <div class="w-full h-full">
        <p v-for="option in props.meta.item.options">
            {{option.name_ru}}
        </p>
    </div>
</template>

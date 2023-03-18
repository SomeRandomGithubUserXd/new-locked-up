<script setup>
import {router} from "@inertiajs/vue3";

const props = defineProps({
    id: Number,
    questId: Number,
    isActive: Boolean,
    price: String,
    time: String
})

const handleBlocking = () => {
    props.isActive ? emit('blockManually', props.id) : emit('unblockManually', props.id)
}

const emit = defineEmits(['blockManually', 'unblockManually', 'writeOrderUsingItem'])
</script>

<template>
    <div class="flex flex-col text-center" :class="!isActive ? 'opacity-50' : ''">
        <button :disabled="!isActive" @click="emit('writeOrderUsingItem', props.time, questId)" type="button" class="bg-green-600 hover:bg-green-700 text-white py-2 px-5 rounded-t-md">
            {{props.price}} руб.
        </button>
        <div class="bg-indigo-600 text-white py-2 px-5">
            {{props.time}}
        </div>
        <button @click="handleBlocking" type="button" class="bg-red-600 hover:bg-red-700 text-white py-2 px-5 rounded-b-md">
            {{ isActive ? 'Заблокировать' : 'Разблокировать' }}
        </button>
    </div>
</template>

<script setup>
import {router} from "@inertiajs/vue3";
import {ClockIcon} from "@heroicons/vue/24/outline";

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
    <div class="flex flex-col text-center py-5">
        <!--        @click="emit('writeOrderUsingItem', props.time, questId)"-->
        <!--        <button :disabled="!isActive"  type="button" class="bg-green-600 hover:bg-green-700 text-white py-2 px-5 rounded-t-md">-->
        <!--            {{props.price}} руб.-->
        <!--        </button>-->
        <!--        <div class="bg-indigo-600 text-white py-2 px-5">-->
        <!--            {{props.time}}-->
        <!--        </div>-->
        <!--        <button @click="handleBlocking" type="button" class="bg-red-600 hover:bg-red-700 text-white py-2 px-5 rounded-b-md">-->
        <!--            {{ isActive ? 'Заблокировать' : 'Разблокировать' }}-->
        <!--        </button>-->
        <div class="shadow rounded-2xl" :class="isActive ? 'bg-white' : 'bg-gray-200'">
            <div class="flex justify-center pb-2 pt-5 px-7 items-center">
                <ClockIcon class="w-6 h-6 mr-2"/>
                <span class="font-bold text-lg">
                    {{ props.time }}
                </span>
            </div>
            <hr class="mx-3" :class="isActive ? 'border-gray-300' : 'border-black'"/>
            <div class="flex justify-center py-2 px-7 items-center text-md">
               <span class="font-medium">
                    {{ props.price }}
                </span>
                &nbsp;
                <span>
                    руб.
                </span>
            </div>
            <div class="p-4">
                <button @click="handleBlocking" type="button"
                        :class="isActive ? 'border-indigo-600 text-indigo-600' : 'border-red-600 text-red-600'"
                        class="bg-white text-sm py-1 px-2 rounded-b-md font-bold border">
                    {{ isActive ? 'Заблокировать' : 'Разблокировать' }}
                </button>
            </div>
        </div>
    </div>
</template>

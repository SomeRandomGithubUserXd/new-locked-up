<script setup>
import {router, useForm} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import MultipleRowsForm from "@/Components/Common/MultipleRowsForm.vue";
import {computed, ref, watch} from "vue";
import Tabs from "@/Components/Common/Tabs.vue";
import {getCurrentUrlParam} from "@/Traits/Tools";
import {collect} from "collect.js";

const props = defineProps({
    modelValue: {
        required: true,
        default: useForm({})
    }
})

const emit = defineEmits(['submit', 'update:modelValue', 'addItem'])

const tableProps = {
    data: [
        {
            name: 'Время',
            attribute: 'time',
            type: 'text'
        },
        {
            name: 'Стоимость',
            attribute: 'price',
            type: 'number'
        },
        {
            name: 'Тип',
            attribute: 'type',
            type: 'text',
            disabled: true
        },
    ],
    actions: [
        {
            name: 'Удалить',
            action(item) {
                router.delete(route('schedule-items.destroy', item.id))
            }
        }
    ]
}

const tabsArray = [
    {
        name: 'Будни',
        value: 'weekdays'
    },
    {
        name: 'Пятница',
        value: 'friday'
    },
    {
        name: 'Выходные',
        value: 'weekend'
    },
]

const currentTab = ref(tabsArray.find(element => element.value === getCurrentUrlParam('type')) || tabsArray[0])

const scheduleItemsFiltered = computed({
    get: () => {
        return collect(props.modelValue.schedule_items).where('type', '===', currentTab.value.value).all()
    }, set: () => {
    }
})

const handleUpdate = (val) => {
    const updated = props.modelValue
    updated.schedule_items = props.modelValue.schedule_items.map(t1 => ({...t1, ...val.find(t2 => t2.id === t1.id)}))
    emit('update:modelValue', updated)
}

const handleNameUpdate = (val) => {
    const updated = props.modelValue
    updated.name = val
    emit('update:modelValue', updated)
}
</script>

<template>
    <form class="space-y-6" @submit.prevent="emit('submit')">
        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-6">
                <InputLabel for="name" value="Наименование"/>
                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    :model-value="modelValue.name"
                    @update:model-value="handleNameUpdate"
                    autofocus
                />
                <InputError class="mt-2" :message="modelValue.errors.name"/>
            </div>
            <div class="col-span-6 sm:col-span-6">
                <tabs class="mb-5" :tabs="tabsArray" v-model="currentTab"/>
                <button type="button"
                        @click="emit('addItem', currentTab.value)"
                        class="w-full mb-5 shadow flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Добавить
                </button>
                <multiple-rows-form
                    class="shadow"
                    :table-props="tableProps"
                    @update:model-value="handleUpdate"
                    :model-value="scheduleItemsFiltered"/>
            </div>
        </div>
        <button type="submit"
                class="w-full mb-5 shadow flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Сохранить
        </button>
    </form>
</template>

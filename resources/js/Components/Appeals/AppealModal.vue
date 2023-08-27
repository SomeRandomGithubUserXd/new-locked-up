<script setup>
import {DialogOverlay, DialogTitle, TransitionChild, TransitionRoot, Dialog} from "@headlessui/vue";
import OrderForm from "@/Components/Orders/OrderForm.vue";
import {orderProps} from "@/Traits/OrderTrait";
import {watch} from "vue";
import {useForm} from "@inertiajs/vue3";
import OrderFilter from "@/Components/Orders/OrderFilter.vue";
import AppealForm from "@/Components/Appeals/AppealForm.vue";

const props = defineProps({
    modelValue: Object,
    statuses: Array,
    sources: Array,
    forms: Array,
})

const emit = defineEmits(['update:modelValue'])

const closeSelf = () => {
    emit('update:modelValue', {...props.modelValue, show: false})
}

const handleSubmit = () => {
    const appeal = useForm(props.modelValue.appeal)
    appeal.patch(route('appeals.update', appeal.id), {
        onSuccess: closeSelf
    })
    // if (props.modelValue.mode === 0) {
    //     filter.post(route('order-filters.store'), {
    //         onSuccess: closeSelf
    //     })
    // } else {
    //     filter.patch(route('order-filters.update', filter.id), {
    //         onSuccess: closeSelf
    //     })
    // }
}

watch(() => props.modelValue, value => {
    // console.log(value)
}, {
    deep: true
})
</script>

<template>
    <TransitionRoot as="template" :show="props.modelValue.show">
        <Dialog as="div" class="fixed z-40 inset-0 overflow-y-auto"
                @close="closeSelf">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0"
                                 enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100"
                                 leave-to="opacity-0">
                    <DialogOverlay class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"/>
                </TransitionChild>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <TransitionChild as="template" enter="ease-out duration-300"
                                 enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                 enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                                 leave-from="opacity-100 translate-y-0 sm:scale-100"
                                 leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div
                        class="inline-block align-bottom bg-white rounded-2xl px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-screen-lg sm:w-full sm:py-6 sm:px-3">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 px-4 sm:text-left w-full">
                                <DialogTitle as="h2" class="text-2xl font-bold leading-6 text-black">
                                    {{ props.modelValue.mode ? 'Редактирование' : 'Создание' }} заявки
                                </DialogTitle>
                                <appeal-form
                                    @abort="closeSelf"
                                    class="mt-5"
                                    v-model="props.modelValue.appeal"
                                    @submit="handleSubmit"
                                    :statuses="props.statuses"
                                    :sources="props.sources"
                                    :forms="props.forms"
                                    :is-editable="true"
                                />
                            </div>
                        </div>
                    </div>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

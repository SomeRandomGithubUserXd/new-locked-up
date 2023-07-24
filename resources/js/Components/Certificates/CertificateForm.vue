<script setup>
import {router, useForm} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
const props = defineProps({
    modelValue: {
        type: Object,
        default: useForm({})
    },
    certificateInstances: Array,
    certificateStatuses: Array,
})

const emit = defineEmits(['submit'])
</script>

<template>
    <form class="space-y-6" @submit.prevent="emit('submit')">
        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-2">
                <InputLabel for="customer_name" value="Имя клиента"/>
                <TextInput
                    id="customer_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue.customer_name"
                    required
                />
                <InputError class="mt-2" :message="modelValue.errors.customer_name"/>
            </div>

            <div class="col-span-6 sm:col-span-2">
                <InputLabel for="customer_email" value="E-Mail клиента"/>
                <TextInput
                    id="customer_email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="modelValue.customer_email"
                />
                <InputError class="mt-2" :message="modelValue.errors.customer_email"/>
            </div>

            <div class="col-span-6 sm:col-span-2">
                <InputLabel for="customer_phone" value="Телефон клиента"/>
                <TextInput
                    id="customer_phone"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue.customer_phone"
                    required
                />
                <InputError class="mt-2" :message="modelValue.errors.customer_phone"/>
            </div>
        </div>
        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-2 flex flex-col">
                <InputLabel for="number" value="Номер"/>
                <select v-model="modelValue.certificate_id"
                        id="number"
                        class="appearance-none mt-auto block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">>
                    <option :value="certificate.id" v-for="certificate in props.certificateInstances">
                        {{ certificate.number}}
                    </option>
                </select>

                <InputError class="mt-2" :message="modelValue.errors.certificate_id"/>
            </div>
            <div class="col-span-6 sm:col-span-2">
                <InputLabel for="customer_address" value="Адрес"/>
                <TextInput
                    id="customer_address"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="modelValue.customer_address"
                    required
                />
                <InputError class="mt-2" :message="modelValue.errors.customer_address"/>
            </div>
            <div class="col-span-6 sm:col-span-1">
                <InputLabel for="price" value="Стоимость"/>
                <TextInput
                    id="customer_address"
                    type="number"
                    class="mt-1 block w-full"
                    v-model="modelValue.price"
                    required
                />
                <InputError class="mt-2" :message="modelValue.errors.price"/>
            </div>
            <div class="col-span-6 sm:col-span-1">
                <InputLabel for="delivery_cost" value="Стоимость доставки"/>
                <TextInput
                    id="delivery_cost"
                    type="number"
                    class="mt-1 block w-full"
                    v-model="modelValue.delivery_cost"
                    required
                />
                <InputError class="mt-2" :message="modelValue.errors.delivery_cost"/>
            </div>
        </div>
        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-2">
                <InputLabel for="paid_cash" value="Оплачено (нал.)"/>
                <TextInput
                    id="paid_cash"
                    type="number"
                    class="mt-1 block w-full"
                    v-model="modelValue.paid_cash"
                    required
                />
                <InputError class="mt-2" :message="modelValue.errors.paid_cash"/>
            </div>
            <div class="col-span-6 sm:col-span-2">
                <InputLabel for="paid_card" value="Оплачено (безнал.)"/>
                <TextInput
                    id="paid_card"
                    type="number"
                    class="mt-1 block w-full"
                    v-model="modelValue.paid_card"
                    required
                />
                <InputError class="mt-2" :message="modelValue.errors.paid_card"/>
            </div>
            <div class="col-span-6 sm:col-span-2">
                <InputLabel for="paid_online" value="Оплачено (онлайн)"/>
                <TextInput
                    id="paid_online"
                    type="number"
                    class="mt-1 block w-full"
                    v-model="modelValue.paid_online"
                    required
                />
                <InputError class="mt-2" :message="modelValue.errors.paid_online"/>
            </div>
        </div>
        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-3">
                <InputLabel for="expires_at" value="Истекает"/>
                <TextInput
                    id="expires_at"
                    type="date"
                    class="mt-1 block w-full"
                    v-model="modelValue.expires_at"
                    required
                />
                <InputError class="mt-2" :message="modelValue.errors.expires_at"/>
            </div>
            <div class="col-span-6 sm:col-span-3 flex flex-col">
                <InputLabel for="status" value="Статус"/>
                <select v-model="modelValue.status"
                        id="number"
                        class="mt-auto appearance-none mt-auto block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">>
                    <option :value="certificate.key" v-for="certificate in props.certificateStatuses">
                        {{ certificate.name}}
                    </option>
                </select>
                <InputError class="mt-2" :message="modelValue.errors.status"/>
            </div>
            <div class="col-span-6 sm:col-span-6 flex flex-col">
                <InputLabel for="comment" value="Комментарий"/>
                <textarea
                    id="comment"
                    v-model="modelValue.comment"
                    class="appearance-none block mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </textarea>
                <InputError class="mt-2" :message="modelValue.errors.comment"/>
            </div>
        </div>
        <div class="mt-5">
            <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Сохранить
            </button>
        </div>
    </form>
</template>

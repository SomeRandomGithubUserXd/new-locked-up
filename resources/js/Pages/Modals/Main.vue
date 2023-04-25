<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, useForm} from "@inertiajs/vue3";
import SwitchLangGroup from "@/Components/Quest/SwitchLangGroup.vue";
import {ref} from "vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import {getAttribute as getAttributeInstance} from "@/Traits/LocaleTrait";
import Checkbox from "@/Components/Checkbox.vue";

const props = defineProps({
    advertModal: Object
})

const advertModalToUpdate = useForm(props.advertModal)

const update = () => {
    advertModalToUpdate.patch(route('modals.update-advert-modal'))
}

const getAttribute = (name) => {
    return getAttributeInstance(name, locale.value)
}

const locale = ref('ru')
</script>

<template>
    <Head title="Модальные окна"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Модальные окна</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form class="space-y-6 flex flex-col" @submit.prevent="update">
                            <switch-lang-group class="mr-3" v-model="locale" @click.stop/>
                            <label for="enabled">
                                <Checkbox id="enabled"
                                          v-model:checked="advertModalToUpdate.enabled"/>
                                <span class="ml-2 text-sm text-gray-600">Активно</span>
                            </label>
                            <div class="grid grid-cols-6 gap-2">
                                <div class="col-span-6 sm:col-span-2">
                                    <input-label for="title" :value="`Заголовок (${locale})`"/>
                                    <text-input
                                        id="title"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="advertModalToUpdate[getAttribute('title')]"
                                        autofocus
                                    />
                                    <input-error
                                        class="mt-2"
                                        :message="advertModalToUpdate.errors[getAttribute('title')]"/>
                                </div>
                                <div class="col-span-6 sm:col-span-6">
                                    <input-label for="text" :value="`Текст (${locale})`"/>
                                    <text-input
                                        id="text"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="advertModalToUpdate[getAttribute('text')]"
                                        autofocus
                                    />
                                    <input-error
                                        class="mt-2"
                                        :message="advertModalToUpdate.errors[getAttribute('text')]"/>
                                </div>
                                <div class="col-span-6 sm:col-span-6">
                                    <input-label for="button_text" :value="`Текст кнопки (${locale})`"/>
                                    <text-input
                                        id="button_text"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="advertModalToUpdate[getAttribute('button_text')]"
                                        autofocus
                                    />
                                    <input-error
                                        class="mt-2"
                                        :message="advertModalToUpdate.errors[getAttribute('button_text')]"/>
                                </div>
                                <div class="col-span-6 sm:col-span-6">
                                    <input-label for="button_url" :value="`Ссылка (${locale})`"/>
                                    <text-input
                                        id="button_url"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="advertModalToUpdate[getAttribute('button_url')]"
                                        autofocus
                                    />
                                    <input-error
                                        class="mt-2"
                                        :message="advertModalToUpdate.errors[getAttribute('button_url')]"/>
                                </div>
                                <div class="col-span-6 sm:col-span-6">
                                    <input-label for="lead" :value="`Задержка появления (сек.) (${locale})`"/>
                                    <text-input
                                        id="lead"
                                        type="number"
                                        class="mt-1 block w-full"
                                        v-model="advertModalToUpdate[getAttribute('lead')]"
                                        autofocus
                                    />
                                    <input-error
                                        class="mt-2"
                                        :message="advertModalToUpdate.errors[getAttribute('lead')]"/>
                                </div>
                            </div>
                            <div class="mt-5">
                                <button type="submit"
                                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Сохранить
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

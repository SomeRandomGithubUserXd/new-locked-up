<script setup>
import {ArrowLeftIcon, ArrowRightIcon} from '@heroicons/vue/24/solid'
import {router} from "@inertiajs/vue3";

const props = defineProps({
    currentPage: Number,
    maxPage: Number,
})

const onPageChange = (page) => {
    router.reload({
        data: {
            page
        }
    })
}
</script>

<template>
    <nav v-if="currentPage <= maxPage" class="border-t border-gray-200 px-4 flex items-center justify-between sm:px-0">
        <div class="-mt-px w-0 flex-1 flex">
            <a href="#" @click="onPageChange(currentPage - 1)"
               v-if="currentPage != 1"
               class="border-t-2 border-transparent pt-4 pr-1 inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                <ArrowLeftIcon class="mr-3 h-5 w-5 text-gray-400" aria-hidden="true"/>
                Назад
            </a>
        </div>
        <div class="hidden md:-mt-px md:flex">
            <a href="#"
               @click="onPageChange(1)"
               v-if="currentPage !== 1 && currentPage - 1 != 1"
               class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 border-t-2 pt-4 px-4 inline-flex items-center text-sm font-medium">
                1
            </a>
            <a href="#"
               @click="onPageChange(currentPage - 1)"
               v-if="currentPage - 1"
               class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 border-t-2 pt-4 px-4 inline-flex items-center text-sm font-medium">
                {{ currentPage - 1 }}
            </a>
            <a href="#"
               class="border-indigo-500 text-indigo-600 border-t-2 pt-4 px-4 inline-flex items-center text-sm font-medium">
                {{ currentPage }}
            </a>
            <a href="#"
               @click="onPageChange(currentPage + 1)"
               v-if="currentPage + 1 < props.maxPage"
               class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 border-t-2 pt-4 px-4 inline-flex items-center text-sm font-medium">
                {{ currentPage + 1 }}
            </a>
            <a href="#"
               @click="onPageChange( maxPage )"
               v-if="props.maxPage !== currentPage"
               class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 border-t-2 pt-4 px-4 inline-flex items-center text-sm font-medium">
                {{ maxPage }}
            </a>
        </div>
        <div class="-mt-px w-0 flex-1 flex justify-end">
            <a href="#"
               v-if="currentPage < maxPage"
               @click="onPageChange( currentPage + 1 )"
               class="border-t-2 border-transparent pt-4 pl-1 inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                Вперед
                <ArrowRightIcon class="ml-3 h-5 w-5 text-gray-400" aria-hidden="true"/>
            </a>
        </div>
    </nav>
</template>

<script setup>
const props = defineProps({
    modelValue: Object,
    tabs: Array
})

const emit = defineEmits(['update:modelValue'])
</script>

<template>
    <div>
        <div class="sm:hidden">
            <label for="tabs" class="sr-only">Выберите вкладку</label>
            <select id="tabs" name="tabs"
                    :value="modelValue"
                    @change="emit('update:modelValue', $event)"
                    class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option v-for="(tab, key) in tabs" :key="key" :selected="modelValue === tab">{{ tab.name }}</option>
            </select>
        </div>
        <div class="hidden sm:block">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <a v-for="(tab, key) in tabs" :key="key"
                       href="#"
                       @click="emit('update:modelValue', tab)"
                       :class="[modelValue.value === tab.value ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300', 'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm']"
                       :aria-current="tab.current ? 'page' : undefined">
                        {{ tab.name }}
                    </a>
                </nav>
            </div>
        </div>
    </div>
</template>

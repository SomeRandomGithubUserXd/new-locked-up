<script setup>
const props = defineProps({
    modelValue: String
})

const localesAvailable = ['ru', 'en']

const emit = defineEmits(['update:modelValue'])
</script>

<template>
      <span class="relative z-0 inline-flex rounded-md">
          <button type="button"
                  @click="emit('update:modelValue', locale)"
                  v-for="(locale, key) in localesAvailable"
                  :class="{'hover:bg-indigo-500 bg-indigo-400 text-white': modelValue === locale, 'hover:bg-gray-100 bg-white text-black': modelValue !== locale, 'rounded-l-md border-l': key === 0, 'rounded-r-md border-r': key === localesAvailable.length - 1}"
                  class="uppercase relative inline-flex items-center border-t border-b px-2 py-2 border-gray-300 text-sm font-medium text-gray-500 focus:z-10">
              <span class="sr-only">{{locale}}</span>
              {{ locale }}
          </button>
      </span>
</template>

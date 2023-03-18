<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import {computed} from "vue";

const props = defineProps({
    modelValue: [Array, String, File],
    label: {
        required: false,
        type: String,
        default: 'Файл'
    },
    needsToBeMultiple: {
        required: false,
        type: Boolean,
        default: false
    },
})

const emit = defineEmits(['update:modelValue'])

const modelType = computed({
    get: () => {
        return props.modelValue.constructor
    },
    set: () => {}
})

const handleChange = (e) => {
    if(modelType.value === String)
    {
        emit('update:modelValue', e.target.files[0]);
    }
    // if (props.needsToBeMultiple) {
    //     props.modelValue.push(...e.target.files)
    // } else {
    //     props.modelValue.push(e.target.files[0])
    // }
}
</script>

<template>
    <div>
        <!--         TODO: label for ref-->
        <InputLabel for="file" :value="props.label"/>
        <input type="file" @change="handleChange">
    </div>
</template>

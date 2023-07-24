<template>
    <div class="mb-4">
        <label :for="id" class="block text-gray-700 text-sm font-bold mb-2">
            {{ label }}
        </label>
        <input
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            :class="{
                'border-red-500': validator?.$error,
                'border-2': validator?.$error,
            }"
            :id="id"
            :type="type"
            :placeholder="placeholder"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            @blur="validator?.$touch"
        />
        <div
            class="text-red-500 text-md mt-1"
            v-for="error of validator?.$errors"
            :key="error.$uid"
        >
            {{ error.$message }}
        </div>
    </div>
</template>

<script>
export default {
    props: {
        modelValue: {
            type: String,
            required: true,
        },
        id: {
            type: String,
            required: true,
        },
        label: {
            type: String,
            required: true,
        },
        type: {
            type: String,
            required: true,
        },
        placeholder: {
            type: String,
            default: "",
        },
        validator: {
            type: Object,
            default: () => ({}),
        },
    },
    emits: ["update:modelValue"],
};
</script>

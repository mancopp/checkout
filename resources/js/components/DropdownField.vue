<template>
    <div class="mb-4">
        <label :for="id" class="block text-gray-700 text-sm font-bold mb-2">
            {{ label }}
        </label>
        <div class="relative">
            <select
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline pr-10"
                :class="{
                    'border-red-500': validator?.$error,
                    'border-2': validator?.$error,
                }"
                :id="id"
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value)"
                @blur="validator?.$touch"
            >
                <option value="" disabled selected>{{ placeholder }}</option>
                <option
                    v-for="(item, index) in data"
                    :key="index"
                    :value="item"
                >
                    {{ item }}
                </option>
            </select>
            <font-awesome-icon
                icon="caret-down"
                class="absolute top-3 right-3 pointer-events-none text-gray-600"
            />
        </div>
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
        placeholder: {
            type: String,
            default: "",
        },
        validator: {
            type: Object,
        },
        data: {
            type: Array,
        },
    },
    emits: ["update:modelValue"],
};
</script>

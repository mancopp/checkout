<template>
    <div class="mb-4">
        <label :for="id" class="block text-gray-700 text-sm font-bold mb-2">
            {{ label }}
        </label>
        <div class="relative">
            <input
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                :class="{
                    'border-red-500': validator?.$error,
                    'border-2': validator?.$error,
                }"
                :id="id"
                :type="showPassword ? 'text' : 'password'"
                :placeholder="placeholder"
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value)"
                @blur="validator?.$touch"
            />
            <button
                @click="togglePasswordVisibility"
                type="button"
                class="absolute top-2 right-2"
            >
                <font-awesome-icon
                    :icon="showPassword ? 'eye' : 'eye-slash'"
                    class="w-5 h-5 text-gray-600"
                />
            </button>
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
    data() {
        return { showPassword: false };
    },
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
            default: () => ({}),
        },
    },
    methods: {
        togglePasswordVisibility() {
            this.showPassword = !this.showPassword;
        },
    },
    emits: ["update:modelValue"],
};
</script>

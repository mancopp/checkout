<template>
    <div
        class="fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black bg-opacity-50 z-50"
        v-if="showModal"
    >
        <div class="bg-white p-4 rounded shadow-md max-w-md">
            <button
                @click="closeModal"
                class="text-gray-500 hover:text-red-500 focus:outline-none"
            >
                <font-awesome-icon icon="times" class="w-5 h-5" />
            </button>
            <h3 class="text-xl">Validation Errors</h3>
            <ul>
                <li
                    v-for="(error, index) in errors"
                    :key="index"
                    class="bg-red-500 text-white rounded p-4 m-2"
                >
                    {{ error }}
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        errors: {
            type: Object,
        },
        showModal: {
            type: Boolean,
            default: false,
        },
    },
    methods: {
        closeModal() {
            this.$emit("close");
        },
    },
};
</script>

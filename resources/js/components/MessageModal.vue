<template>
    <div
        class="fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black bg-opacity-50 z-50"
    >
        <div class="bg-white p-4 rounded shadow-md w-full sm:w-2/3 lg:w-2/5">
            <button
                @click="closeModal"
                class="text-gray-500 hover:text-red-500 focus:outline-none"
            >
                <font-awesome-icon icon="times" class="w-5 h-5" />
            </button>

            <div class="text-center">
                <p class="font-bold text-xl">{{ message }}</p>
                <font-awesome-icon
                    :class="['text-8xl my-6', iconColor]"
                    :icon="iconName"
                />
            </div>

            <button
                type="submit"
                class="w-full bg-emerald-500 text-white py-4 px-6 rounded text-lg font-bold hover:bg-emerald-700 transition duration-300"
                @click="closeModal"
            >
                OK
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        message: {
            type: String,
            required: true,
        },
        icon: {
            type: String,
            required: true,
        },
    },
    data() {
        return {};
    },
    computed: {
        iconName() {
            const iconMappings = {
                success: "check-circle",
                failure: "xmark-circle",
            };

            return iconMappings[this.icon] || "";
        },
        iconColor() {
            const iconMappings = {
                success: "text-emerald-500",
                failure: "text-red-500",
            };

            return iconMappings[this.icon] || "";
        },
    },
    methods: {
        closeModal() {
            this.$emit("close");
        },
    },
};
</script>

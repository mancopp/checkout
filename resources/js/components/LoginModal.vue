<template>
    <div
        class="fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black bg-opacity-50 z-50"
    >
        <div class="bg-white p-4 rounded shadow-md w-full sm:w-2/3 lg:w-2/5">
            <!-- "Go back" button to close the modal -->

            <button
                @click="closeModal"
                class="text-gray-500 hover:text-red-500 focus:outline-none"
            >
                <font-awesome-icon icon="times" class="w-5 h-5" />
            </button>

            <form @submit.prevent="submitLogin">
                <!-- "Login" Field -->

                <InputField
                    id="email"
                    label="Email:"
                    type="email"
                    placeholder="Enter your email"
                    v-model="loginData.username"
                />

                <!-- "Password" Field -->

                <PasswordField
                    id="password"
                    label="Password:"
                    placeholder="Enter your password"
                    v-model="loginData.password"
                />

                <button
                    type="submit"
                    class="w-full bg-red-500 text-white py-4 px-6 rounded text-lg font-bold hover:bg-red-700 transition duration-300"
                >
                    Log in
                </button>
            </form>
        </div>
    </div>
</template>

<script>
import InputField from "./InputField.vue";
import PasswordField from "./PasswordField.vue";

export default {
    components: {
        InputField,
        PasswordField,
    },
    data() {
        return {
            loginData: {
                username: "",
                password: "",
            },
        };
    },
    methods: {
        closeModal() {
            this.$emit("close");
        },
        submitLogin() {
            this.closeModal();
        },
    },
};
</script>

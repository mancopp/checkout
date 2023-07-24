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
                <InputField
                    id="discountCode"
                    label="Discount code:"
                    type="text"
                    placeholder="Enter your discount code"
                    v-model="discountCode"
                />

                <button
                    type="submit"
                    class="w-full bg-emerald-500 text-white py-4 px-6 rounded text-lg font-bold hover:bg-emerald-700 transition duration-300"
                    @click="checkDiscountCode"
                >
                    Check
                </button>
            </form>
        </div>
    </div>
</template>

<script>
import InputField from "./InputField.vue";

export default {
    components: {
        InputField,
    },
    data() {
        return {
            discountCode: "",
        };
    },
    methods: {
        closeModal() {
            this.$emit("close");
        },
        messageModal(message, icon) {
            this.$emit("message-modal", message, icon);
        },
        addDiscount(value, code) {
            this.$emit("add-discount", value, code);
        },
        checkDiscountCode() {
            axios
                .post("/api/check-discount-code", {
                    discountCode: this.discountCode,
                })
                .then((response) => {
                    const isValidDiscount = response.data.isValid;
                    if (isValidDiscount) {
                        const isActiveDiscount = response.data.isActive;
                        if (isActiveDiscount) {
                            const discountValue = response.data.discountValue;
                            this.addDiscount(discountValue, this.discountCode);
                            this.closeModal();
                            this.messageModal(
                                `Discount code has been activated! Discount value: ${discountValue}`,
                                "success"
                            );
                        } else {
                            this.messageModal(
                                "The discount code is valid but currently inactive.",
                                "failure"
                            );
                        }
                    } else {
                        this.messageModal(
                            "Invalid discount code. Please try again.",
                            "failure"
                        );
                    }
                })
                .catch(() => {
                    this.messageModal(
                        "Failed to check discount code. Please try again later.",
                        "failure"
                    );
                });
        },
    },
};
</script>

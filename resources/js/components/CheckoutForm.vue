<template>
    <div class="bg-emerald-100 min-h-screen flex items-center justify-center">
        <div
            class="w-full sm:w-1/2 lg:w-1/3 px-4 py-8 bg-white rounded-xl border shadow-md"
            v-if="!loadingData"
        >
            <form @submit.prevent="submitForm">
                <SectionHeader icon="user" title="1. PERSONAL INFORMATION" />

                <!-- "Log in" Button -->
                <div class="mb-4">
                    <button
                        @click="showLoginModal"
                        type="button"
                        class="w-full bg-white border-2 border-red-500 text-red-500 py-2 px-4 rounded hover:bg-red-500 hover:text-white transition duration-300"
                    >
                        Log in
                    </button>
                    <span class="text-red-500"
                        >Already have an account? Click to login.</span
                    >
                </div>

                <!-- "Email" Field -->
                <InputField
                    id="email"
                    label="Email:"
                    type="email"
                    placeholder="Enter your email"
                    v-model="email"
                    :validator="v$.email"
                />

                <PasswordField
                    id="password"
                    label="Password:"
                    placeholder="Enter your password"
                    v-model="password"
                    :validator="v$.password"
                />

                <!-- "Confirm Password" Field -->

                <PasswordField
                    id="confirmPassword"
                    label="Confirm password:"
                    placeholder="Confirm your password"
                    v-model="confirmPassword"
                    :validator="v$.confirmPassword"
                />

                <!-- "First Name" Field -->
                <InputField
                    id="firstName"
                    label="First Name:"
                    type="text"
                    placeholder="Enter your first name"
                    v-model="firstName"
                    :validator="v$.firstName"
                />

                <!-- "Last Name" Field -->
                <InputField
                    id="lastName"
                    label="Last Name:"
                    type="text"
                    placeholder="Enter your last name"
                    v-model="lastName"
                    :validator="v$.lastName"
                />

                <!-- Main Account Address Fields -->
                <AddressFields
                    v-model:address="addressDataAccount.address"
                    v-model:zip-code="addressDataAccount.zipCode"
                    v-model:city="addressDataAccount.city"
                    v-model:selected-country="
                        addressDataAccount.selectedCountry
                    "
                    :validator="v$.addressDataAccount"
                />

                <InputField
                    id="phoneNumber"
                    label="Phone number:"
                    type="tel"
                    placeholder="Enter your phone number"
                    v-model="phoneNumber"
                    :validator="v$.phoneNumber"
                />

                <!-- Checkbox different address -->

                <div class="flex items-center mb-4">
                    <input
                        class="form-checkbox h-4 w-4 accent-emerald-700 text-red-500 focus:ring-red-600 border-gray-300 rounded"
                        type="checkbox"
                        id="differentAddr"
                        v-model="differentDeliveryAddress"
                    />
                    <label
                        for="differentAddr"
                        class="ml-2 text-gray-700 text-sm"
                    >
                        Deliver to different address
                    </label>
                </div>

                <!-- Additional fields -->
                <transition name="slide">
                    <div v-if="differentDeliveryAddress" class="md-4">
                        <AddressFields
                            v-model:address="addressDataDelivery.address"
                            v-model:zip-code="addressDataDelivery.zipCode"
                            v-model:city="addressDataDelivery.city"
                            v-model:selected-country="
                                addressDataDelivery.selectedCountry
                            "
                            :validator="v$.addressDataDelivery"
                        />
                    </div>
                </transition>

                <SectionHeader icon="truck" title="2. DELIVERY METHOD" />

                <div
                    class="mb-4"
                    v-for="(option, index) in deliveryOptions"
                    :key="index"
                >
                    <div class="flex items-center">
                        <input
                            type="radio"
                            name="deliveryOption"
                            class="mr-2 h-4 w-4 accent-emerald-700"
                            v-model="selectedDeliveryOption"
                            @change="onDeliveryOptionChange"
                            :value="option"
                        />
                        <img
                            :src="option.icon_link"
                            :alt="`Logo ${index + 1}`"
                            class="w-8 h-8 object-contain"
                        />
                        <div class="ml-2">
                            <div class="text-sm font-bold">
                                {{ option.name }}
                            </div>
                            <div class="text-gray-600">
                                {{ option.price }} zł
                            </div>
                        </div>
                    </div>
                </div>

                <SectionHeader icon="credit-card" title="3. PAYMENT METHOD" />

                <div
                    class="mb-4"
                    v-for="(option, index) in availablePaymentOptions"
                    :key="index"
                >
                    <div class="flex items-center">
                        <input
                            type="radio"
                            name="paymentOption"
                            class="mr-2 h-4 w-4 accent-emerald-700"
                            v-model="selectedPaymentOption"
                            :value="option"
                        />
                        <img
                            :src="option.icon_link"
                            :alt="`Logo ${index + 1}`"
                            class="w-8 h-8 object-contain"
                        />
                        <div class="ml-2">
                            <div class="text-sm font-bold">
                                {{ option.name }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- "Add discount code" Button -->
                <button
                    @click="showDiscountCodeModal"
                    :disabled="discountCode !== ''"
                    type="button"
                    :class="[
                        'w-full py-2 px-4 rounded mb-4 transition duration-300',
                        discountCode !== ''
                            ? 'bg-red-500 text-white'
                            : 'bg-white border-2 border-emerald-500 text-emerald-500 hover:bg-emerald-500 hover:text-white',
                    ]"
                >
                    {{
                        discountCode !== ""
                            ? "Code used: " + discountCode
                            : "Add discount code"
                    }}
                </button>

                <SectionHeader icon="clipboard" title="4. SUMMARY" />

                <!-- Display cart products -->
                <div class="mb-4" v-for="(product, index) in cart" :key="index">
                    <div class="flex items-center">
                        <img
                            :src="product.icon_link"
                            :alt="product.name"
                            class="w-8 h-8 object-contain"
                        />
                        <div class="ml-2">
                            <div class="text-sm font-bold">
                                {{ product.name }}
                            </div>
                            <div class="text-gray-600">
                                Quantity: {{ product.quantity }}
                            </div>
                        </div>
                        <div class="ml-auto">
                            <div class="text-gray-600">
                                {{ product.quantity * product.price }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Discount -->
                <div v-if="discountValue" class="border-t-2 py-4">
                    <div class="flex items-center">
                        <div class="font-medium">Full price:</div>
                        <div class="ml-auto font-bold">
                            {{ getTotalPrice() }} zł
                        </div>
                    </div>
                    <div class="flex items-center text-red-500">
                        <div class="font-medium">Discount:</div>
                        <div class="ml-auto font-bold">
                            -{{ discountValue }} zł
                        </div>
                    </div>
                </div>

                <!-- Total price -->
                <div class="border-y-2 py-4">
                    <div class="flex items-center">
                        <div class="font-bold">Total:</div>
                        <div class="ml-auto font-bold">
                            {{ getTotalPrice() - discountValue }}
                        </div>
                    </div>
                </div>

                <!-- Order comments -->
                <div class="my-4">
                    <label
                        class="block text-gray-700 text-sm font-bold mb-2"
                        for="order-comments"
                    >
                        Order Comments:
                    </label>
                    <textarea
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="order-comments"
                        rows="4"
                        placeholder="Enter your order comments here..."
                        v-model="orderComments"
                    ></textarea>
                </div>

                <!-- "Newsletter" Checkbox -->

                <div class="flex items-center mb-4">
                    <input
                        class="form-checkbox h-4 w-4 accent-emerald-700 text-red-500 focus:ring-red-600 border-gray-300 rounded"
                        type="checkbox"
                        id="newsletter"
                        v-model="subscribeToNewsletter"
                    />
                    <label for="newsletter" class="ml-2 text-gray-700 text-sm">
                        Subscribe to our newsletter
                    </label>
                </div>

                <!-- "Terms" Checkbox -->

                <div class="flex items-center mb-4">
                    <input
                        class="form-checkbox h-4 w-4 accent-emerald-700 text-red-500 focus:ring-red-600 border-gray-300 rounded"
                        type="checkbox"
                        id="terms"
                        v-model="acceptTerms"
                    />
                    <label for="terms" class="ml-2 text-gray-700 text-sm">
                        Accept our terms
                    </label>
                </div>

                <!-- "Buy" Button -->
                <button
                    type="submit"
                    class="w-full bg-red-500 text-white py-4 px-6 rounded text-lg font-bold hover:bg-red-700 transition duration-300"
                >
                    Buy
                </button>
            </form>
        </div>

        <!-- Modals -->

        <LoginModal v-if="isLoginModalVisible" @close="hideLoginModal" />

        <DiscountCodeModal
            v-if="isDiscountCodeModalVisible"
            @close="hideDiscountCodeModal"
            @add-discount="addDiscount"
            @message-modal="showMessageModal"
        />

        <MessageModal
            v-if="isMessageModalVisible"
            @close="hideMessageModal"
            :message="messageModalMessage"
            :icon="messageModalIcon"
        />

        <ErrorModal
            :showModal="errorModalVisible"
            :errors="validationErrors"
            @close="closeErrorModal"
        />

        <!-- Loader -->
        <div v-if="loadingData" class="text-center">
            <font-awesome-icon
                icon="spinner"
                class="animate-spin text-gray-600 text-4xl"
            />
            <div class="mt-2 text-gray-600">Loading...</div>
        </div>
    </div>
</template>

<script>
import SectionHeader from "./SectionHeader.vue";
import LoginModal from "./LoginModal.vue";
import DiscountCodeModal from "./DiscountCodeModal.vue";
import InputField from "./InputField.vue";
import PasswordField from "./PasswordField.vue";
import AddressFields from "./AddressFields.vue";
import ErrorModal from "./ErrorModal.vue";
import MessageModal from "./MessageModal.vue";

import { useVuelidate } from "@vuelidate/core";
import {
    required,
    email as emailValidation,
    sameAs,
    helpers,
    requiredIf,
    maxLength,
} from "@vuelidate/validators";

export default {
    setup() {
        return {
            v$: useVuelidate(),
        };
    },
    components: {
        SectionHeader,
        LoginModal,
        DiscountCodeModal,
        AddressFields,
        InputField,
        PasswordField,
        ErrorModal,
        MessageModal,
    },
    data() {
        return {
            errors: {
                email: "",
                firstName: "",
                lastName: "",
                phoneNumber: "",
            },
            subscribeToNewsletter: false,
            acceptTerms: false,
            isLoginModalVisible: false,
            isDiscountCodeModalVisible: false,
            isMessageModalVisible: false,
            errorModalVisible: false,
            messageModalMessage: "",
            messageModalMessage: "",
            loadingData: true,
            discountValue: null,
            email: "",
            password: "",
            confirmPassword: "",
            firstName: "",
            lastName: "",
            phoneNumber: "",
            addressDataAccount: {
                selectedCountry: "",
                address: "",
                zipCode: "",
                city: "",
            },
            addressDataDelivery: {
                selectedCountry: "",
                address: "",
                zipCode: "",
                city: "",
            },
            differentDeliveryAddress: false,
            discountCode: "",
            orderComments: "",
            selectedDeliveryOption: null,
            selectedPaymentOption: null,
            cart: [
                {
                    id: "1",
                    name: "Portable laptop",
                    icon_link:
                        "https://upload.wikimedia.org/wikipedia/commons/2/25/Laptop_z_tack%C4%85.svg",
                    quantity: 1,
                    price: 115.99,
                },
                {
                    id: "2",
                    name: "Computer mouse",
                    icon_link:
                        "https://upload.wikimedia.org/wikipedia/commons/2/22/3-Tasten-Maus_Microsoft.jpg",
                    quantity: 2,
                    price: 13.99,
                },
            ],
            showPassword: false,
            showConfirmPassword: false,
            deliveryOptions: [],
            paymentOptions: [],
            validationErrors: [],
        };
    },
    validations() {
        const zipCode = helpers.regex(/^\d{2}-\d{3}$/);
        const phoneNumber = helpers.regex(/^\d{3}-\d{3}-\d{3}$/);

        return {
            firstName: {
                required,
                maxLength: maxLength(255),
            },
            lastName: {
                required,
                maxLength: maxLength(255),
            },
            email: { required, emailValidation },
            password: { required },
            confirmPassword: { required, sameAs: sameAs(this.password) },
            phoneNumber: {
                required,
                phoneNumber: helpers.withMessage(
                    "Please enter a correct phone number (000-000-000)",
                    phoneNumber
                ),
            },
            // differentDeliveryAddress: {},
            //TODO
            // acceptTerms: {
            //     sameAs: (vueModel) => vueModel.terms === true,
            //     sameAs: helpers.withMessage(
            //         "You must accept our terms",
            //         sameAs
            //     ),
            // },
            // subscribeToNewsletter: {},
            addressDataAccount: {
                selectedCountry: { required },
                address: { required },
                zipCode: {
                    required,
                    zipCode: helpers.withMessage(
                        "Should be of format: 00-000",
                        zipCode
                    ),
                },
                city: {
                    required,
                    maxLength: maxLength(255),
                },
            },
            addressDataDelivery: {
                selectedCountry: {
                    requiredIf: requiredIf(this.differentDeliveryAddress),
                },
                address: {
                    requiredIf: requiredIf(this.differentDeliveryAddress),
                },
                zipCode: {
                    requiredIf: requiredIf(this.differentDeliveryAddress),
                    zipCode: helpers.withMessage(
                        "Should be of format: 00-000",
                        zipCode
                    ),
                },
                city: {
                    requiredIf: requiredIf(this.differentDeliveryAddress),
                    maxLength: maxLength(255),
                },
            },
        };
    },
    methods: {
        closeErrorModal() {
            this.errorModalVisible = false;
            this.validationErrors = [];
        },
        onDeliveryOptionChange() {
            if (
                this.selectedDeliveryOption &&
                !this.availablePaymentOptions.includes(
                    this.selectedPaymentOption
                )
            ) {
                this.selectedPaymentOption = null;
            }
        },
        addDiscount(value, code) {
            this.discountCode = code;
            this.discountValue = value;
        },
        showLoginModal() {
            this.isLoginModalVisible = true;
        },
        hideLoginModal() {
            this.isLoginModalVisible = false;
        },
        showDiscountCodeModal() {
            this.isDiscountCodeModalVisible = true;
        },
        hideDiscountCodeModal() {
            this.isDiscountCodeModalVisible = false;
        },
        showMessageModal(message, icon) {
            this.messageModalMessage = message;
            this.messageModalIcon = icon;
            this.isMessageModalVisible = true;
        },
        hideMessageModal() {
            this.isMessageModalVisible = false;
        },
        togglePasswordVisibility() {
            this.showPassword = !this.showPassword;
        },
        toggleConfirmPasswordVisibility() {
            this.showConfirmPassword = !this.showConfirmPassword;
        },
        getTotalPrice() {
            return this.cart.reduce(
                (total, product) => total + product.price * product.quantity,
                0
            );
        },
        async submitForm() {
            const isFormCorrect = await this.v$.$validate();

            if (!isFormCorrect) {
                window.scrollTo({ top: 0, left: 0, behavior: "smooth" });
                return;
            }

            const formData = {
                email: this.email,
                password: this.password,
                first_name: this.firstName,
                last_name: this.lastName,
                different_delivery_address: this.differentDeliveryAddress,
                discount_code: this.discountCode,
                order_comments: this.orderComments,
                delivery_method: this.selectedDeliveryOption.id,
                payment_method: this.selectedPaymentOption.id,
                address_data_account: this.addressDataAccount,
                address_data_delivery: this.addressDataDelivery,
                products_list: this.cart,
                phone_number: this.phoneNumber,
                accept_terms: this.acceptTerms,
                newsletter_subscription: this.subscribeToNewsletter,
            };

            axios
                .post("/api/submit-form", formData)
                .then((response) => {
                    this.messageModalMessage =
                        "Success! Your order id is: " + response.data;
                    this.messageModalIcon = "success";
                    this.isMessageModalVisible = true;
                })
                .catch((error) => {
                    if (error.response && error.response.status === 422) {
                        if (error.response.data) {
                            const joinedErrors = Object.values(
                                error.response.data.errors
                            ).map((ers) => ers.join(", "));
                            this.errorModalVisible = true;
                            this.validationErrors = joinedErrors;
                        }
                    }
                    if (error.response && error.response.status === 500) {
                        if (error.response.data) {
                            this.showMessageModal(
                                error.response.data,
                                "failure"
                            );
                        }
                    }
                });
        },
        async fetchDataFromApi() {
            try {
                const response = await axios.get("/api/get-data");
                this.deliveryOptions = response.data.deliveryOptions;
                this.paymentOptions = response.data.paymentOptions;
                this.loadingData = false;
            } catch (error) {
                console.error("Error fetching data from API:", error);
                this.loadingData = false;
                this.showMessageModal(
                    "Error fetching data from API",
                    "failure"
                );
            }

            if (this.deliveryOptions.length > 0) {
                this.selectedDeliveryOption = this.deliveryOptions[0];
            }

            if (this.paymentOptions.length > 0) {
                this.selectedPaymentOption = this.paymentOptions[0];
            }
        },
    },
    computed: {
        availablePaymentOptions() {
            if (!this.selectedDeliveryOption) return this.paymentOptions;

            return this.paymentOptions.filter((paymentOption) => {
                return paymentOption.delivery_methods.some(
                    (method) => method.id === this.selectedDeliveryOption.id
                );
            });
        },
    },
    created() {
        this.fetchDataFromApi();
    },
};
</script>

<style>
.slide-enter-active,
.slide-leave-active {
    transition: all 0.3s;
}

.slide-enter-from,
.slide-leave-to {
    transform: translateY(-20px);
    opacity: 0;
}
</style>

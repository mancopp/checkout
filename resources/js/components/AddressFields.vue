<template>
    <!-- "Country" Dropdown -->

    <DropdownFieldVue
        id="country"
        label="Country:"
        placeholder="Select a country"
        :data="countries"
        v-model="selectedCountry"
        :validator="validator?.selectedCountry"
        @input="$emit('update:selectedCountry', $event.target.value)"
    />

    <!-- "Address" Field -->

    <InputField
        id="address"
        label="Address:"
        type="text"
        placeholder="Enter your address"
        v-model="address"
        :validator="validator?.address"
        @input="$emit('update:address', $event.target.value)"
    />

    <!-- "ZIP Code" and "City" Fields -->

    <div class="flex">
        <div class="w-1/2 mr-2">
            <InputField
                id="zipcode"
                label="ZIP Code:"
                type="text"
                placeholder="Enter ZIP code"
                v-model="zipCode"
                :validator="validator?.zipCode"
                @input="$emit('update:zipCode', $event.target.value)"
            />
        </div>
        <div class="w-1/2 ml-2">
            <InputField
                id="city"
                label="City"
                type="text"
                placeholder="Enter city"
                v-model="city"
                :validator="validator?.city"
                @input="$emit('update:city', $event.target.value)"
            />
        </div>
    </div>
</template>

<script>
import InputField from "./InputField.vue";
import DropdownFieldVue from "./DropdownField.vue";

import { countries } from "countries-list";

export default {
    components: {
        InputField,
        DropdownFieldVue,
    },
    data() {
        return {
            countries: Object.values(countries).map((country) => country.name),
        };
    },
    props: {
        selectedCountry: String,
        zipCode: String,
        address: String,
        city: String,
        validator: {
            type: Object,
        },
    },
    emits: [
        "update:selectedCountry",
        "update:zipCode",
        "update:address",
        "update:city",
    ],
};
</script>

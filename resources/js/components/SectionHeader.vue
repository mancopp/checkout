<template>
    <div class="relative bg-emerald-500 text-white p-5 mb-4 rounded-md">
        <div class="flex items-center">
            <font-awesome-icon :icon="icon" class="mr-2" />
            <span class="font-bold">{{ title }}</span>
        </div>
    </div>
</template>

<script>
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

export default {
    props: {
        icon: {
            type: String,
            required: true,
        },
        title: {
            type: String,
            required: true,
        },
    },
    components: {
        FontAwesomeIcon,
    },
};
</script>

<template>
    <inertia-link :href="route('language', [selectable_locale])" class="ml-2">
        <icon class="w-4 h-4" :name="selectable_locale" />
    </inertia-link>
</template>

<script>
import Icon from "@/Language/Icon";

export default {
    components: {
        Icon,
    },

    computed: {
        selectable_locale() {
            if (this.$page.props.locale == "th") {
                return "en";
            }
            return "th";
        },
    },
};
</script>

<template>
    <img class="rd-logo" src="<%= BASE_URL %>assets/images/e-appointment.png" />
</template>

<script>
export default {
    data() {
        return {
            publicPath: process.env.BASE_URL,
        };
    },
};
</script>

<template>
    <EventLayout :event="event">
        <h2>Attendee Detail</h2>
        <pre>{{ attendee }}</pre>
    </EventLayout>
</template>

<script setup lang="ts">
import EventLayout from "@/Layouts/EventLayout.vue";

defineProps({
    event: {
        type: Object,
        required: true,
    },
    attendee: {
        type: Object,
        default: false,
    },
});
</script>

<style lang="scss" scoped>
</style>

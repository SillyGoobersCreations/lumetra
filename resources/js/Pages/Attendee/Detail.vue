<template>
    <EventLayout :event="event" :userAttendee="userAttendee">
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
    userAttendee: {
        type: [Object, Boolean],
        default: false,
    },
    attendee: {
        type: Object,
        default: false,
    },
});
</script>

<style lang="scss" scoped>
</style>

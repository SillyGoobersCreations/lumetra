<template>
    <EventLayout :event="event" :userAttendee="userAttendee">
        <h2>Event Agenda</h2>
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
    }
});
</script>

<style lang="scss" scoped>
</style>

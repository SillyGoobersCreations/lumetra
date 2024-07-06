<template>
    <EventLayout :event="event" :attendee="attendee">
        <h2>Event Notes</h2>
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
        type: [Object, Boolean],
        default: false,
    }
});
</script>

<style lang="scss" scoped>
</style>

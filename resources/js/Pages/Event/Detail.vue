<template>
    <EventLayout :event="event" :userAttendee="userAttendee" v-if="userAttendee">
        <Box padding="m">
            <h2>{{ event.title }}</h2>
            <p>{{ event.description }}</p>
        </Box>
        <Box padding="m">
            <Link :href="route('events.detail.leave', { eventId: event.id })" class="button danger">
                <i class="ri-coupon-3-line"></i>
                <span>Leave Event</span>
            </Link>
        </Box>
    </EventLayout>
    <DefaultLayout v-else>
        <Box padding="m">
            <h2>{{ event.title }}</h2>
            <p>{{ event.description }}</p>
        </Box>
        <Box padding="m">
            <Link :href="route('events.detail.enroll', { eventId: event.id })" class="button primary">
                <i class="ri-coupon-3-line"></i>
                <span>Join Event</span>
            </Link>
        </Box>
    </DefaultLayout>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import EventLayout from "@/Layouts/EventLayout.vue";
import Wrapper from "@/Components/Common/Wrapper.vue";
import Box from "@/Components/Common/Box.vue";
import DefaultLayout from "@/Layouts/DefaultLayout.vue";

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

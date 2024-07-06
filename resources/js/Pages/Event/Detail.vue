<template>
    <EventLayout :event="event" :attendee="attendee" v-if="attendee">
        <Box padding="m">
            <h2>{{ event.title }}</h2>
            <p>{{ event.description }}</p>
        </Box>
        <Box padding="m">
            <a href="" class="button danger">
                <i class="ri-coupon-3-line"></i>
                <span>Leave Event</span>
            </a>
        </Box>
    </EventLayout>
    <DefaultLayout v-else>
        <Box padding="m">
            <h2>{{ event.title }}</h2>
            <p>{{ event.description }}</p>
        </Box>
        <Box padding="m">
            <a href="" class="button primary">
                <i class="ri-coupon-3-line"></i>
                <span>Join Event</span>
            </a>
        </Box>
    </DefaultLayout>
</template>

<script setup lang="ts">
import EventLayout from "@/Layouts/EventLayout.vue";
import Wrapper from "@/Components/Common/Wrapper.vue";
import Box from "@/Components/Common/Box.vue";
import DefaultLayout from "@/Layouts/DefaultLayout.vue";

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

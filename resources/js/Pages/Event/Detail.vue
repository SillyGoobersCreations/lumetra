<template>
    <EventLayout :event="event" v-if="userAttendee">
        <section class="event-detail-enrolled">
            <div>
                <EventOverviewGeneral :event="event" />
                <EventOverviewProperties :event="event" />
            </div>
            <div>
                <Box>
                    TODO: Last 3 Chats, Button to Chat
                </Box>
                <Box>
                    TODO: Upcoming Events, Button to Agenda
                </Box>
                <Box>
                    <Link :href="route('events.detail.leave', { eventId: event.id })" class="button danger">
                        <i class="ri-coupon-3-line"></i>
                        <span>Leave Event</span>
                    </Link>
                </Box>
            </div>
        </section>
    </EventLayout>
    <DefaultLayout v-else>
        <section class="event-detail">
            <div>
                <EventOverviewGeneral :event="event" />
                <EventOverviewProperties :event="event" />
            </div>
            <div>
                <Box>
                    <Link :href="route('events.detail.enroll', { eventId: event.id })" class="button primary">
                        <i class="ri-coupon-3-line"></i>
                        <span>Join Event</span>
                    </Link>
                </Box>
            </div>
        </section>
    </DefaultLayout>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import EventLayout from "@/Layouts/EventLayout.vue";
import Box from "@/Components/Common/Box.vue";
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import EventOverviewGeneral from "@/Components/Event/EventOverview/EventOverviewGeneral.vue";
import EventOverviewProperties from "@/Components/Event/EventOverview/EventOverviewProperties.vue";

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
.event-detail-enrolled {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}
.event-detail {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 15px;
}
.event-detail-enrolled > div, .event-detail > div {
    display: flex;
    flex-direction: column;
    gap: 15px;
}
</style>

<template>
    <EventLayout :event="event" v-if="userAttendee">
        <section class="event-detail-enrolled">
            <div>
                <Box padding="l" class="general">
                    <h2>{{ event.title }}</h2>
                    <p>{{ event.description }}</p>
                </Box>
                <Box padding="m">
                    <pre>Id: {{ event.id ?? "null" }}</pre><br />
                    <pre>State: {{ event.state ?? "null" }}</pre><br />
                    <pre>Title: {{ event.title ?? "null" }}</pre><br />
                    <pre>Organizer: {{ event.organizer ?? "null" }}</pre><br />
                    <pre>Description: {{ event.description ?? "null" }}</pre><br />
                    <pre>StartDate: {{ event.start_date ?? "null" }}</pre><br />
                    <pre>EndDate: {{ event.end_date ?? "null" }}</pre><br />
                    <pre>ColorPrimary: {{ event.color_primary ?? "null" }}</pre><br />
                    <pre>ColorSecondary: {{ event.color_secondary ?? "null" }}</pre><br />
                    <pre>ConfirmationRequired: {{ event.confirmation_required ?? "null" }}</pre><br />
                    <pre>ConfirmationPersonalized: {{ event.confirmation_personalized ?? "null" }}</pre><br />
                    <pre>RoomSlotMaxPending: {{ event.room_slot_max_pending ?? "null" }}</pre><br />
                    <pre>RoomSlotMaxClaimed: {{ event.room_slot_max_claimed ?? "null" }}</pre><br />
                    <pre>RoomSlotTeamConfirmationRequired: {{ event.room_slot_team_confirmation_required ?? "null" }}</pre><br />
                    <pre>AttendeesMax: {{ event.attendees_max ?? "null" }}</pre><br />
                </Box>
            </div>
            <div>
                <Box padding="m">
                    TODO: Last 3 Chats, Button to Chat
                </Box>
                <Box padding="m">
                    TODO: Upcoming Events, Button to Agenda
                </Box>
                <Box padding="m">
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
                <Box padding="l" class="general">
                    <h2>{{ event.title }}</h2>
                    <p>{{ event.description }}</p>
                </Box>
            </div>
            <div>
                <Box padding="m">
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
.event-detail-enrolled {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 25px;
}
.event-detail {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 25px;
}
.event-detail-enrolled > div, .event-detail > div {
    display: flex;
    flex-direction: column;
    gap: 15px;

    & .general {
        display: flex;
        flex-direction: column;
        gap: 10px;

        & h2 {
            font-size: 1.5rem;
        }
    }
}
</style>

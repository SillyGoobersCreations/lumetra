<template>
    <EventLayout :event="event">
        <section class="attendee-detail">
            <div>
                <Box padding="l" class="details">
                    <div class="avatar" v-if="attendee.avatar_url"></div>
                    <div class="avatar fallback" v-else>{{ attendee.name_initials }}</div>
                    <div class="name">{{ attendee.name_full }}</div>
                    <div class="job-info" v-if="attendee.job_position || attendee.job_company">
                        <span v-if="attendee.job_position">{{ attendee.job_position }}</span>
                        <span v-if="attendee.job_company">{{ attendee.job_company }}</span>
                    </div>
                    <div class="actions">
                        <Link :href="route('events.attendees.detail', { eventId: attendee.event.id, attendeeId: attendee.id })" class="button primary">
                            <i class="ri-shake-hands-line"></i>
                            <span>Connect</span>
                        </Link>
                    </div>
                </Box>
            </div>
            <div>
                <Box padding="l">
                    {{ attendee.description }}
                </Box>
                <Box padding="l">
                    <pre>Handle: {{ attendee.handle ? attendee.handle : "null" }}</pre><br />
                    <pre>Confirmed: {{ attendee.confirmed ? attendee.confirmed : "null" }}</pre><br />
                    <pre>Active: {{ attendee.active ? attendee.active : "null" }}</pre><br />
                    <pre>Role: {{ attendee.role ? attendee.role : "null" }}</pre><br />
                    <pre>ContactInfos: {{ attendee.contact_infos }}</pre><br />
                </Box>
            </div>
        </section>
    </EventLayout>
</template>

<script setup lang="ts">
import EventLayout from "@/Layouts/EventLayout.vue";
import Box from "@/Components/Common/Box.vue";
import {Link} from "@inertiajs/vue3";

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
.attendee-detail {
    display: grid;
    grid-template-columns: 350px 1fr;
    gap: 15px;
}
.attendee-detail > div {
    display: flex;
    flex-direction: column;
    gap: 15px;
}
.details {
    display: flex;
    flex-direction: column;
    gap: 15px;
    overflow: hidden;

    & .avatar {
        margin: 0 auto;
        width: 128px;
        height: 128px;
        background: rgb(var(--color-base-200));
        background-position: center;
        background-size: cover;
        border-radius: 100px;

        &.fallback {
            font-size: 2rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgb(var(--color-base-200));
        }
    }
    & .name {
        font-size: 1.15rem;
        text-align: center;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    & .job-info {
        display: flex;
        flex-direction: column;
        gap: 5px;

        & span {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        & span:nth-child(2) {
            color: rgb(var(--color-base-400));
        }
    }
    & .actions {
        flex-grow: 1;
        display: flex;
        align-items: flex-end;
        gap: 5px;

        & button, & .button {
            flex-grow: 1;
        }
    }
}
</style>

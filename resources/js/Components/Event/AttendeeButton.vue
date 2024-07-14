<template>
    <div class="attendee-button">
        <div class="avatar" v-if="attendee.avatar_url"></div>
        <div class="avatar fallback" v-else>{{ attendee.name_initials }}</div>
        <div class="name">{{ attendee.name_full }}</div>
        <div class="job-info" v-if="attendee.job_position || attendee.job_company">
            <span v-if="attendee.job_position">{{ attendee.job_position }}</span>
            <span v-if="attendee.job_company">{{ attendee.job_company }}</span>
        </div>
        <div class="actions">
            <Link :href="route('events.attendees.detail', { eventId: attendee.event.id, attendeeId: attendee.id })" class="button">
                <i class="ri-arrow-right-up-line"></i>
                <span>Go to profile</span>
            </Link>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps({
    attendee: {
        type: Object,
        required: true,
    }
});
</script>

<style lang="scss" scoped>
.attendee-button {
    background: rgb(var(--color-base-50));
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    gap: 15px;
    padding: 20px;
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

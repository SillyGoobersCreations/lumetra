<template>
    <div class="attendee-button">
        <Avatar :attendee="attendee" :size="128" />
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
import {PropType} from "@vue/runtime-dom";
import {Attendee} from "@/types/models/Attendee";
import Avatar from "@/Components/Common/Avatar.vue";

defineProps({
    attendee: {
        type: Object as PropType<Attendee>,
        default: null,
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

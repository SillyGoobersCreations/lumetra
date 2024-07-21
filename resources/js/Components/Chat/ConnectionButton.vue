<template>
    <Link
        :href="route('events.chats.detail', {
            eventId: attendee.event_id,
            attendeeId: attendee.id,
        })"
        :class="`connection-button ${active ? 'active' : ''}`"
        v-if="attendee !== null"
    >
        <Avatar :attendee="attendee" />
        <div class="meta">
            <div class="name">{{ attendee.name_full }}</div>
            <div class="connected">Connected {{ moment(connection.created_at).fromNow() }}</div>
        </div>
    </Link>
</template>

<script setup lang="ts">
import {Link, usePage} from '@inertiajs/vue3';
import {PropType} from "@vue/runtime-dom";
import {AttendeeConnection} from "@/types/models/AttendeeConnection";
import {computed} from "vue";
import moment from "moment/moment";
import {Attendee} from "@/types/models/Attendee";
import Avatar from "@/Components/Common/Avatar.vue";

const props = defineProps({
    currentAttendeeId: {
        type: String,
        required: true,
    },
    connection: {
        type: Object as PropType<AttendeeConnection>,
        required: true,
    },
    active: {
        type: Boolean,
        default: false,
    }
});

const attendee = computed(() => {
    if(props.currentAttendeeId === props.connection?.inviter_attendee_id) {
        return props.connection?.invitee_attendee;
    } else {
        return props.connection?.inviter_attendee;
    }
});
</script>

<style lang="scss" scoped>
.connection-button {
    background: rgb(var(--color-base-50));
    border-radius: 5px;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 0 10px;
    overflow: hidden;
    text-decoration: none;
    color: inherit;
    height: 50px;
    transition: var(--transition-default);

    &.active {
        background: rgb(var(--color-base-200));
    }

    & .meta {
        display: flex;
        flex-direction: column;
        gap: 5px;
        flex-grow: 1;

        & .name {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            flex-grow: 1;
        }
        & .connected {
            font-size: 0.75rem;
            color: rgb(var(--color-base-400));
        }
    }

    &:hover {
        background: rgb(var(--color-base-100));
    }
}
</style>

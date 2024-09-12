<template>
    <Message :is-remote="isRemote">
        <template #default>
            {{ connection.intro_text }}
        </template>
        <template v-if="isRemote && connection.state === 'pending'" #actions>
            <Link
                :href="route('events.attendees.connect.accept', {
                    eventId: attendee?.event_id,
                    attendeeId: attendee?.id,
                    requestId: connection.id,
                })"
                class="button primary"
            >
                <i class="ri-shake-hands-line"></i>
                <span>Accept</span>
            </Link>
            <Link
                :href="route('events.attendees.connect.decline', {
                    eventId: attendee?.event_id,
                    attendeeId: attendee?.id,
                    requestId: connection.id,
                })"
                class="button danger"
            >
                <i class="ri-delete-bin-line"></i>
                <span>Decline</span>
            </Link>
        </template>
    </Message>
    <MessageSystem>
        {{ connectionState }}
    </MessageSystem>
</template>

<script setup lang="ts">
import {PropType} from "@vue/runtime-dom";
import {AttendeeConnection} from "@/types/models/AttendeeConnection";
import {computed} from "vue";
import Message from "@/components/Chat/Message.vue";
import MessageSystem from "@/components/Chat/MessageSystem.vue";
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    currentAttendeeId: {
        type: String,
        required: true,
    },
    connection: {
        type: Object as PropType<AttendeeConnection>,
        required: true,
    }
});

const isRemote = computed(() => {
    return props.currentAttendeeId !== props.connection?.inviter_attendee_id;
});

const attendee = computed(() => {
    if(props.currentAttendeeId === props.connection?.inviter_attendee_id) {
        return props.connection?.invitee_attendee;
    } else {
        return props.connection?.inviter_attendee;
    }
});

const connectionState = computed(() => {
    if(isRemote.value) {
        switch (props.connection.state) {
            case "pending":
            default:
                return "You have not responded to this connection request yet.";
            case "declined":
                return "You have declined this connection request.";
            case "confirmed":
                return "You have accepted this connection request.";
        }
    } else {
        switch (props.connection.state) {
            case "pending":
            default:
                return "The other attendee has not responded to your connection request yet.";
            case "declined":
                return "The other attendee has declined your connection request.";
            case "confirmed":
                return "The other attendee has accepted your connection request.";
        }
    }
});
</script>

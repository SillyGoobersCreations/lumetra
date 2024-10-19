<template>
    <Message :is-remote="isRemote">
        <template #default>
            {{ connection.intro_text }}
        </template>
        <template
            v-if="isRemote && connection.state === 'pending'"
            #actions
        >
            <Button
                as-child
                variant="secondary"
                size="xs"
            >
                <Link
                    :href="
                        route('events.attendees.connect.accept', {
                            eventId: attendee?.event_id,
                            attendeeId: attendee?.id,
                            requestId: connection.id,
                        })
                    "
                >
                    <i class="ri-shake-hands-line mr-2 text-lg"></i>
                    <span>Accept</span>
                </Link>
            </Button>
            <Button
                as-child
                size="xs"
                variant="destructive"
            >
                <Link
                    :href="
                        route('events.attendees.connect.decline', {
                            eventId: attendee?.event_id,
                            attendeeId: attendee?.id,
                            requestId: connection.id,
                        })
                    "
                >
                    <i class="ri-delete-bin-line mr-2 text-lg"></i>
                    <span>Decline</span>
                </Link>
            </Button>
        </template>
    </Message>
    <MessageSystem>
        {{ connectionState }}
    </MessageSystem>
</template>

<script setup lang="ts">
import Message from '@/components/Chat/Message.vue';
import MessageSystem from '@/components/Chat/MessageSystem.vue';
import { Button } from '@/components/ui/button';
import { Attendee } from '@/types/models/Attendee';
import { AttendeeConnection } from '@/types/models/AttendeeConnection';
import { Link } from '@inertiajs/vue3';
import { PropType, computed } from 'vue';

const props = defineProps({
    currentAttendeeId: {
        type: String,
        required: true,
    },
    connection: {
        type: Object as PropType<AttendeeConnection>,
        required: true,
    },
});

const isRemote = computed<boolean>(() => {
    return props.currentAttendeeId !== props.connection?.inviter_attendee_id;
});

/* Get the other Attendee */
const attendee = computed<Attendee>(() => {
    if (props.currentAttendeeId === props.connection?.inviter_attendee_id) {
        return props.connection?.invitee_attendee as Attendee;
    } else {
        return props.connection?.inviter_attendee as Attendee;
    }
});

const connectionState = computed<string>(() => {
    if (isRemote.value) {
        switch (props.connection.state) {
            case 'pending':
            default:
                return 'You have not responded to this connection request yet.';
            case 'declined':
                return 'You have declined this connection request.';
            case 'confirmed':
                return 'You have accepted this connection request.';
        }
    } else {
        switch (props.connection.state) {
            case 'pending':
            default:
                return 'The other attendee has not responded to your connection request yet.';
            case 'declined':
                return 'The other attendee has declined your connection request.';
            case 'confirmed':
                return 'The other attendee has accepted your connection request.';
        }
    }
});
</script>

<template>
    <Message :is-remote="isRemote">
        <template #default>
            <div class="flex flex-col gap-0">
                <span class="text-xs font-bold">Meet invite</span>
                <span class="mb-2"
                    >{{ moment(claim.slot.start_date).format('DD.MM.YYYY') }} @ {{ moment(claim.slot.start_date).format('HH:mm') }} <span class="text-muted-foreground">- {{ moment(claim.slot.end_date).format('HH:mm') }}</span></span
                >
                <span class="font-bold">{{ claim.slot.room.name }}</span>
                <span class="text-muted-foreground">{{ claim.slot.room.location }}</span>
                <div
                    class="mt-2 rounded-md bg-destructive p-2 text-xs text-destructive-foreground"
                    v-if="claim.state === 'pending' && isUserUnavailable"
                >
                    You already have a confirmed invite at this time.
                </div>
            </div>
        </template>
        <template
            v-if="claim.state === 'pending'"
            #actions
        >
            <template v-if="isRemote">
                <Button
                    as-child
                    variant="secondary"
                    size="xs"
                >
                    <Link
                        :href="
                            route('events.chats.roomSlotInvite.answer', {
                                eventId: eventId,
                                attendeeId: attendeeId,
                                inviteId: claim.id,
                                acceptInvite: true,
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
                            route('events.chats.roomSlotInvite.answer', {
                                eventId: eventId,
                                attendeeId: attendeeId,
                                inviteId: claim.id,
                                acceptInvite: false,
                            })
                        "
                    >
                        <i class="ri-delete-bin-line mr-2 text-lg"></i>
                        <span>Decline</span>
                    </Link>
                </Button>
            </template>
            <template v-else>
                <div class="text-xs text-muted-foreground">Awaiting response</div>
            </template>
        </template>
        <template
            v-if="claim.state === 'attendee_confirmed'"
            #actions
        >
            <div class="text-xs text-muted-foreground">Awaiting organizer approval</div>
        </template>
        <template
            v-if="claim.state === 'confirmed'"
            #actions
        >
            <Badge>Invite confirmed</Badge>
        </template>
        <template
            v-if="claim.state === 'attendee_declined'"
            #actions
        >
            <Badge variant="destructive">Invite declined</Badge>
        </template>
    </Message>
</template>

<script setup lang="ts">
import Message from '@/components/Chat/Message.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { EventRoomSlotClaim } from '@/types/models/EventRoomSlotClaim';
import { Link } from '@inertiajs/vue3';
import moment from 'moment/moment';
import { PropType, computed } from 'vue';

const props = defineProps({
    isRemote: {
        type: Boolean,
        default: false,
    },
    eventId: {
        type: String,
        required: true,
    },
    attendeeId: {
        type: String,
        required: true,
    },
    claim: {
        type: Object as PropType<EventRoomSlotClaim>,
        required: true,
    },
    confirmedUserSlots: {
        type: Array,
        default: () => [],
    },
});

const isUserUnavailable = computed(() => {
    return props.confirmedUserSlots.includes(props.claim.slot.start_date);
});
</script>

<template>
    <div :class="`flex gap-2 rounded-md border-[1px] border-accent p-2 ${roomSlot.state === 'unavailable' ? 'opacity-40' : ''}`">
        <div class="flex grow flex-col justify-center gap-1">
            <div class="flex items-center gap-1 text-xs">
                <span class="font-bold">{{ moment(roomSlot.start_date).format('HH:mm') }}</span>
                <span>-</span>
                <span class="text-muted-foreground">{{ moment(roomSlot.end_date).format('HH:mm') }}</span>
            </div>
            <div
                v-if="['claimed', 'claim_open'].includes(roomSlot.state)"
                class="mt-2 flex flex-col gap-2"
            >
                <div class="flex items-center gap-2">
                    <Avatar class="mr-2 h-8 w-8">
                        <AvatarImage
                            :src="`/storage/avatars/${roomSlot.claims.invitee_attendee.avatar_url}?v=${roomSlot.claims.invitee_attendee.updated_at}`"
                            v-if="roomSlot.claims.invitee_attendee.avatar_url"
                        />
                        <AvatarFallback>{{ roomSlot.claims.invitee_attendee.name_initials }}</AvatarFallback>
                    </Avatar>
                    <p class="text-sm font-medium leading-none">
                        {{ roomSlot.claims.invitee_attendee.name_full }}
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <Avatar class="mr-2 h-8 w-8">
                        <AvatarImage
                            :src="`/storage/avatars/${roomSlot.claims.inviter_attendee.avatar_url}?v=${roomSlot.claims.inviter_attendee.updated_at}`"
                            v-if="roomSlot.claims.inviter_attendee.avatar_url"
                        />
                        <AvatarFallback>{{ roomSlot.claims.inviter_attendee.name_initials }}</AvatarFallback>
                    </Avatar>
                    <p class="text-sm font-medium leading-none">
                        {{ roomSlot.claims.inviter_attendee.name_full }}
                    </p>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <!-- TODO
            <Button variant="secondary" size="icon" v-if="event.room_slot_team_confirmation_required">
                <i class="ri-check-line text-lg"></i>
            </Button>
            <Button variant="secondary" size="icon" v-if="event.room_slot_team_confirmation_required">
                <i class="ri-close-line text-lg"></i>
            </Button> -->
            <DropdownMenu>
                <DropdownMenuTrigger as-child>
                    <Button
                        variant="secondary"
                        :disabled="roomSlot.state === 'claimed'"
                    >
                        <span>{{ stateToText(roomSlot.state) }}</span>
                    </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent>
                    <DropdownMenuItem as-child>
                        <Link
                            :href="
                                route('events.admin.rooms.slots.changeState', {
                                    eventId: event.id,
                                    roomId: room.id,
                                    slotId: roomSlot.id,
                                    state: 'open',
                                })
                            "
                        >
                            <span>{{ stateToText('open') }}</span>
                        </Link>
                    </DropdownMenuItem>
                    <DropdownMenuItem as-child>
                        <Link
                            :href="
                                route('events.admin.rooms.slots.changeState', {
                                    eventId: event.id,
                                    roomId: room.id,
                                    slotId: roomSlot.id,
                                    state: 'reserved',
                                })
                            "
                        >
                            <span>{{ stateToText('reserved') }}</span>
                        </Link>
                    </DropdownMenuItem>
                    <DropdownMenuItem as-child>
                        <Link
                            :href="
                                route('events.admin.rooms.slots.changeState', {
                                    eventId: event.id,
                                    roomId: room.id,
                                    slotId: roomSlot.id,
                                    state: 'unavailable',
                                })
                            "
                        >
                            <span>{{ stateToText('unavailable') }}</span>
                        </Link>
                    </DropdownMenuItem>
                </DropdownMenuContent>
            </DropdownMenu>
            <Button
                size="icon"
                variant="destructive"
                as-child
            >
                <Link
                    :href="
                        route('events.admin.rooms.slots.delete', {
                            eventId: event.id,
                            roomId: room.id,
                            slotId: roomSlot.id,
                        })
                    "
                >
                    <i class="ri-delete-bin-5-line"></i>
                </Link>
            </Button>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Event } from '@/types/models/Event';
import { EventRoom } from '@/types/models/EventRoom';
import { EventRoomSlot } from '@/types/models/EventRoomSlot';
import { Link } from '@inertiajs/vue3';
import moment from 'moment/moment';
import { PropType } from 'vue';

const props = defineProps({
    event: {
        type: Object as PropType<Event>,
        required: true,
    },
    room: {
        type: Object as PropType<EventRoom>,
        required: true,
    },
    roomSlot: {
        type: Object as PropType<EventRoomSlot>,
        required: true,
    },
});

function stateToText(state) {
    switch (state) {
        case 'open':
            return 'Available';
        case 'reserved':
            return 'Reserved';
        case 'claim_open':
            return 'Open Claim';
        case 'claimed':
            return 'Claimed';
        case 'unavailable':
            return 'Unavailable';
    }
}
</script>

<style scoped lang="scss"></style>

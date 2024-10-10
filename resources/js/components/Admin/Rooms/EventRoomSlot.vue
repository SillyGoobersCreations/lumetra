<template>
    <div
        :class="`border-[1px] border-accent flex gap-2 p-2 rounded-md ${slot.state === 'unavailable' ? 'opacity-40' : ''}`"
    >
        <div class="grow flex flex-col gap-1 justify-center">
            <div class="text-xs flex gap-1 items-center">
                <span class="font-bold">{{ moment(slot.start_date).format("HH:mm") }}</span>
                <span>-</span>
                <span class="text-muted-foreground">{{ moment(slot.end_date).format("HH:mm") }}</span>
            </div>
            <div v-if="['claimed', 'claim_open'].includes(slot.state)" class="flex flex-col gap-2 mt-2">
                <div class="flex gap-2 items-center">
                    <Avatar class="h-8 w-8 mr-2">
                        <AvatarImage :src="`/storage/avatars/${slot.claims.invitee_attendee.avatar_url}`" v-if="slot.claims.invitee_attendee.avatar_url" />
                        <AvatarFallback>{{ slot.claims.invitee_attendee.name_initials }}</AvatarFallback>
                    </Avatar>
                    <p class="text-sm font-medium leading-none">
                        {{ slot.claims.invitee_attendee.name_full }}
                    </p>
                </div>
                <div class="flex gap-2 items-center">
                    <Avatar class="h-8 w-8 mr-2">
                        <AvatarImage :src="`/storage/avatars/${slot.claims.inviter_attendee.avatar_url}`" v-if="slot.claims.inviter_attendee.avatar_url" />
                        <AvatarFallback>{{ slot.claims.inviter_attendee.name_initials }}</AvatarFallback>
                    </Avatar>
                    <p class="text-sm font-medium leading-none">
                        {{ slot.claims.inviter_attendee.name_full }}
                    </p>
                </div>
            </div>
        </div>
        <div class="flex gap-2 items-center">
            <!-- TODO
            <Button variant="secondary" size="icon" v-if="event.room_slot_team_confirmation_required">
                <i class="ri-check-line text-lg"></i>
            </Button>
            <Button variant="secondary" size="icon" v-if="event.room_slot_team_confirmation_required">
                <i class="ri-close-line text-lg"></i>
            </Button> -->
            <DropdownMenu>
                <DropdownMenuTrigger as-child>
                    <Button variant="secondary" :disabled="slot.state === 'claimed'">
                        <span>{{ stateToText(slot.state) }}</span>
                    </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent>
                    <DropdownMenuItem as-child>
                        <Link :href="route('events.admin.rooms.slots.changeState', {
                            eventId: event.id,
                            roomId: room.id,
                            slotId: slot.id,
                            state: 'open'
                        })">
                            <span>{{ stateToText('open') }}</span>
                        </Link>
                    </DropdownMenuItem>
                    <DropdownMenuItem as-child>
                        <Link :href="route('events.admin.rooms.slots.changeState', {
                            eventId: event.id,
                            roomId: room.id,
                            slotId: slot.id,
                            state: 'reserved'
                        })">
                            <span>{{ stateToText('reserved') }}</span>
                        </Link>
                    </DropdownMenuItem>
                    <DropdownMenuItem as-child>
                        <Link :href="route('events.admin.rooms.slots.changeState', {
                            eventId: event.id,
                            roomId: room.id,
                            slotId: slot.id,
                            state: 'unavailable'
                        })">
                            <span>{{ stateToText('unavailable') }}</span>
                        </Link>
                    </DropdownMenuItem>
                </DropdownMenuContent>
            </DropdownMenu>
            <Button size="icon" variant="destructive" as-child>
                <Link
                    :href="route('events.admin.rooms.slots.delete', {
                        eventId: event.id,
                        roomId: room.id,
                        slotId: slot.id,
                    })"
                >
                    <i class="ri-delete-bin-5-line"></i>
                </Link>
            </Button>
        </div>
    </div>
</template>

<script setup lang="ts">
import moment from "moment/moment";
import {PropType} from "@vue/runtime-dom";
import {Event} from "@/types/models/Event";
import {EventRoom} from "@/types/models/EventRoom";
import {EventRoomSlot} from "@/types/models/EventRoomSlot";
import {Button} from "@/components/ui/button";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger
} from "@/components/ui/dropdown-menu";
import {Link} from "@inertiajs/vue3";
import {Avatar, AvatarFallback, AvatarImage} from "@/components/ui/avatar";

const props = defineProps({
    event: {
        type: Object as PropType<Event>,
        required: true,
    },
    room: {
        type: Object as PropType<EventRoom>,
        required: true,
    },
    slot: {
        type: Object as PropType<EventRoomSlot>,
        required: true,
    },
});

function stateToText (state) {
    switch(state) {
        case "open":
            return "Available";
        case "reserved":
            return "Reserved";
        case "claim_open":
            return "Open Claim";
        case "claimed":
            return "Claimed";
        case "unavailable":
            return "Unavailable";
    }
}
</script>

<style scoped lang="scss">

</style>

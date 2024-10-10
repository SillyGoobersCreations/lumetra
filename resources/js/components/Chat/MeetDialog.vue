<template>
    <Dialog
        v-model:open="dialogOpen"
    >
        <DialogTrigger as-child>
            <Button variant="secondary">
                <span>Meet</span>
            </Button>
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Meet with {{ attendee.name_full }}</DialogTitle>
                <DialogDescription>Select a date and time slot</DialogDescription>
            </DialogHeader>
            <div class="flex flex-col gap-4">
                <FormRow label="Date" variant="wide">
                    <Popover>
                        <PopoverTrigger as-child>
                            <Button
                                variant="outline"
                                :class="`justify-start ${ !value && 'text-muted-foreground' }`"
                            >
                                <i class="ri-calendar-2-line mr-2 text-lg"></i>
                                {{ value ? df.format(value.toDate(getLocalTimeZone())) : "Pick a date" }}
                            </Button>
                        </PopoverTrigger>
                        <PopoverContent class="w-auto p-0">
                            <Calendar
                                v-model="value"
                                initial-focus
                                :min-value="parseDate(event.start_date?.split(' ')[0])"
                                :max-value="parseDate(event.end_date?.split(' ')[0])"
                            />
                        </PopoverContent>
                    </Popover>
                </FormRow>
                <FormRow label="Room" variant="wide" v-if="rooms.length > 0">
                    <Select v-model="selectedRoomId">
                        <SelectTrigger class="h-14">
                            <SelectValue placeholder="Select a room" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem :disabled="!room.available" v-for="room in rooms" :key="room.id" :value="room.id">
                                <div class="flex flex-col">
                                    <span>{{ room.name }}</span>
                                    <span class="text-muted-foreground">{{ room.location }}</span>
                                </div>
                            </SelectItem>
                        </SelectContent>
                    </Select>
                </FormRow>
                <template v-if="selectedRoom">
                    <FormRow v-if="selectedRoom.notes" label="Room notes" variant="wide">
                        <span class="text-muted-foreground">{{ selectedRoom.notes }}</span>
                    </FormRow>
                    <FormRow label="Slot" variant="wide">
                        <Select v-model="selectedSlotId">
                            <SelectTrigger class="h-14">
                                <SelectValue placeholder="Select a slot" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem :disabled="slot.state !== 'open'" v-for="slot in selectedRoom.slots" :key="slot.id" :value="slot.id">
                                    <div class="flex flex-col">
                                        <span>{{ moment(slot.start_date).format('HH:mm') }} <span class="text-muted-foreground">- {{ moment(slot.end_date).format('HH:mm') }}</span></span>
                                        <span class="text-muted-foreground">{{ stateToText(slot.state) }}</span>
                                    </div>
                                </SelectItem>
                            </SelectContent>
                        </Select>
                    </FormRow>
                    <template v-if="selectedSlot">
                        <FormRow v-if="selectedSlot.notes" label="Slot notes" variant="wide">
                            <span class="text-muted-foreground">{{ selectedSlot.notes }}</span>
                        </FormRow>
                    </template>
                </template>

                <div class="text-muted-foreground">Can't find a suitable slot? You'll also be able to meet in common areas such as the Courtyard without booking a slot.</div>
            </div>
            <DialogFooter>
                <Button @click="sendInvite" :disabled="!selectedRoomId || !selectedSlotId">
                    <span>Send Invite</span>
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

<script setup lang="ts">
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger
} from "@/components/ui/dialog";
import {Button} from "@/components/ui/button";
import FormRow from "@/components/Common/FormRow.vue";
import {parseDate} from '@internationalized/date';
import moment from "moment/moment";

import {
    DateFormatter,
    type DateValue,
    getLocalTimeZone,
} from '@internationalized/date';

import { Calendar } from '@/components/ui/calendar';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import {computed, ref, watch} from "vue";
import {PropType} from "@vue/runtime-dom";
import {Event} from "@/types/models/Event";
import {AttendeeConnection} from "@/types/models/AttendeeConnection";
import {usePage} from "@inertiajs/vue3";
import {Select, SelectContent, SelectItem, SelectTrigger, SelectValue} from "@/components/ui/select";
import {EventRoom} from "@/types/models/EventRoom";

const df = new DateFormatter('en-US', {
    dateStyle: 'long',
});

const value = ref<DateValue>();
const rooms = ref<EventRoom[]>([]);
const selectedRoomId = ref<string>(null);
const selectedRoom = computed(() => rooms.value.find((room) => room.id === selectedRoomId.value));
const selectedSlotId = ref<string>(null);
const selectedSlot = computed(() => selectedRoom.value.slots.find((slot) => slot.id === selectedSlotId.value));
const dialogOpen = ref(false);

const props = defineProps({
    event: {
        type: Object as PropType<Event>,
        required: true,
    },
    selectedConnection: {
        type: Object as PropType<AttendeeConnection>,
        required: true,
    },
});

const page = usePage();
const attendees = computed(() => page.props.auth.attendees);
const currentAttendee = computed(() => {
    let foundAttendee = null;

    attendees.value.forEach((attendee) => {
        if(attendee.event_id === props.event.id) {
            foundAttendee = attendee;
        }
    })

    return foundAttendee;
});

const attendee = computed(() => {
    if(currentAttendee.value?.id === props.selectedConnection?.inviter_attendee_id) {
        return props.selectedConnection.invitee_attendee;
    } else {
        return props.selectedConnection.inviter_attendee;
    }
});

watch(value, async (newValue) => {
    rooms.value = [];
    selectedSlotId.value = null;
    selectedRoomId.value = null;

    if(newValue === null) {
        return;
    }

    let response = await fetch(route('events.rooms.index', { eventId: props.event.id, date: newValue?.toString() }));
    rooms.value = await response.json();
});

async function sendInvite() {
    let response = await fetch(route('events.chats.roomSlotInvite.send', {
        eventId: props.event.id,
        attendeeId: attendee.value.id,
        slotId: selectedSlotId.value,
    }));
    let data = await response.json();

    dialogOpen.value = false;
    selectedSlotId.value = null;
    selectedRoomId.value = null;
    value.value = null;
}

function stateToText (state) {
    switch(state) {
        case "open":
            return "Available";
        case "reserved":
            return "Reserved";
        case "claimed":
            return "Claimed";
        case "claim_open":
        case "unavailable":
            return "Unavailable";
    }
}
</script>

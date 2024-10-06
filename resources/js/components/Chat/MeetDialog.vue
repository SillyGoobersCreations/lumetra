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
            </div>
            <DialogFooter>
                <Button @click="sendInvite">
                    <span>Send Invite</span>
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

<script setup lang="ts">
import {Dialog, DialogContent, DialogFooter, DialogHeader, DialogTitle, DialogTrigger} from "@/components/ui/dialog";
import {Button} from "@/components/ui/button";
import FormRow from "@/components/Common/FormRow.vue";
import {parseDate} from '@internationalized/date';

import {
    DateFormatter,
    type DateValue,
    getLocalTimeZone,
} from '@internationalized/date';

import { Calendar } from '@/components/ui/calendar';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import {computed, ref} from "vue";
import {PropType} from "@vue/runtime-dom";
import {Event} from "@/types/models/Event";
import {AttendeeConnection} from "@/types/models/AttendeeConnection";
import {usePage} from "@inertiajs/vue3";

const df = new DateFormatter('en-US', {
    dateStyle: 'long',
});

const value = ref<DateValue>();
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

function sendInvite() {
    dialogOpen.value = false;
}
</script>

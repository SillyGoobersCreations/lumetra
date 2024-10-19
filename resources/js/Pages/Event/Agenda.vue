<template>
    <Head title="Agenda" />

    <EventLayout :event="event">
        <section class="page-event-agenda">
            <div>
                <Card>
                    <CardHeader>
                        <CardTitle>Upcoming</CardTitle>
                        <CardDescription>Events and meetups</CardDescription>
                    </CardHeader>
                    <CardContent class="flex flex-col gap-2">
                        <div
                            class="flex flex-col items-center gap-1 p-3"
                            v-if="slotClaims.length === 0"
                        >
                            <i class="ri-chat-1-line mb-2 text-4xl"></i>
                            <h1>No meetups yet</h1>
                            <p class="text-muted-foreground">Invite another attendee to begin.</p>
                        </div>
                        <Card
                            v-for="meet in slotClaims"
                            :key="meet.id"
                        >
                            <CardContent class="grid grid-cols-[auto_1fr_auto] items-center gap-2 p-4 px-4">
                                <Avatar class="mr-2 h-8 w-8">
                                    <AvatarImage
                                        v-if="getOtherAttendeeRoomClaim(meet).avatar_url"
                                        :src="`/storage/avatars/${getOtherAttendeeRoomClaim(meet).avatar_url}?v=${getOtherAttendeeRoomClaim(meet).updated_at}`"
                                    />
                                    <AvatarFallback>{{ getOtherAttendeeRoomClaim(meet).name_initials }}</AvatarFallback>
                                </Avatar>
                                <div class="flex flex-col gap-1">
                                    <CardTitle>{{ getOtherAttendeeRoomClaim(meet).name_full }}</CardTitle>
                                    <CardDescription v-if="getOtherAttendeeRoomClaim(meet).job_company">{{ getOtherAttendeeRoomClaim(meet).job_company }}</CardDescription>
                                </div>
                                <Badge variant="secondary">{{ moment(meet.slot?.start_date).fromNow() }}</Badge>
                            </CardContent>
                            <CardContent>
                                <div class="flex flex-col gap-0">
                                    <span class="mb-2"
                                        >{{ moment(meet.slot?.start_date).format('DD.MM.YYYY') }} @ {{ moment(meet.slot?.start_date).format('HH:mm') }} <span class="text-muted-foreground">- {{ moment(meet.slot?.end_date).format('HH:mm') }}</span></span
                                    >
                                    <span class="font-bold">{{ meet.slot?.room?.name }}</span>
                                    <span class="text-muted-foreground">{{ meet.slot?.room?.location }}</span>
                                </div>
                            </CardContent>
                            <CardFooter class="flex gap-2">
                                <Button
                                    class="grow"
                                    variant="secondary"
                                    as-child
                                >
                                    <Link :href="route('events.chats.detail', { eventId: event.id, attendeeId: getOtherAttendeeRoomClaim(meet).id })">
                                        <span>Chat</span>
                                    </Link>
                                </Button>
                                <Button
                                    class="grow"
                                    variant="secondary"
                                    as-child
                                >
                                    <Link :href="route('events.attendees.detail', { eventId: event.id, attendeeId: getOtherAttendeeRoomClaim(meet).id })">
                                        <span>Profile</span>
                                    </Link>
                                </Button>
                            </CardFooter>
                        </Card>
                    </CardContent>
                </Card>
            </div>
            <div>
                <Card
                    v-for="note in event.notes"
                    :key="note.id"
                >
                    <CardHeader>
                        <CardTitle class="flex items-center gap-2">
                            <span>{{ note.title }}</span>
                            <Badge variant="secondary">{{ moment(note.created_at).fromNow() }}</Badge>
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        {{ note.text }}
                    </CardContent>
                </Card>
            </div>
        </section>
    </EventLayout>
</template>

<script setup lang="ts">
import EventLayout from '@/Layouts/EventLayout.vue';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Attendee } from '@/types/models/Attendee';
import { Event } from '@/types/models/Event';
import { EventRoomSlotClaim } from '@/types/models/EventRoomSlotClaim';
import { Head, Link, usePage } from '@inertiajs/vue3';
import moment from 'moment';
import { PropType, computed } from 'vue';

const props = defineProps({
    event: {
        type: Object as PropType<Event>,
        required: true,
    },
    slotClaims: {
        type: Array as PropType<EventRoomSlotClaim[]>,
        default: () => [],
    },
});

/* Get Current Users Attendee */
const page = usePage();
const attendees = computed(() => page.props.auth.attendees);
const currentAttendee = computed<Attendee | null>(() => {
    let foundAttendee: Attendee | null = null;

    attendees.value.forEach((attendee) => {
        if (attendee.event_id === props.event.id) {
            foundAttendee = attendee;
        }
    });

    return foundAttendee;
});
function getOtherAttendeeRoomClaim(eventRoomSlotClaim: EventRoomSlotClaim): Attendee {
    if (eventRoomSlotClaim.inviter_attendee_id === currentAttendee.value?.id) {
        return eventRoomSlotClaim.invitee_attendee as Attendee;
    } else {
        return eventRoomSlotClaim.inviter_attendee as Attendee;
    }
}
</script>

<style lang="scss" scoped>
.page-event-agenda {
    @apply flex flex-col gap-4 lg:grid lg:grid-cols-2;
}
.page-event-agenda > div {
    @apply flex flex-col gap-4;
}
</style>

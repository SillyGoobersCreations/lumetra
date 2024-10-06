<template>
    <EventLayout :event="event" v-if="userAttendee">
        <Alert v-if="event.state !== 'public'" variant="destructive" class="mb-5">
            <AlertTitle>This event is not public.</AlertTitle>
            <AlertDescription>You can see this event, because you are an event organizer.</AlertDescription>
        </Alert>
        <section class="event-detail-enrolled">
            <div>
                <EventOverviewGeneral :event="event" />
                <EventOverviewProperties :event="event" />
                <Card>
                    <CardHeader>
                        <CardTitle>Leave event</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p>Your account will not be shown in the attendee list, other attendees will not be able to chat with you anymore. You can re-join this event at any time.</p>
                    </CardContent>
                    <CardFooter>
                        <Button
                            class="w-full justify-start"
                            variant="destructive"
                            as-child
                        >
                            <Link :href="route('events.detail.leave', { eventId: event.id })">
                                <i class="ri-coupon-3-line mr-2 text-lg"></i>
                                <span>Leave event</span>
                            </Link>
                        </Button>
                    </CardFooter>
                </Card>
            </div>
            <div>
                <Card>
                    <CardHeader>
                        <CardTitle>Recent Chats</CardTitle>
                    </CardHeader>
                    <CardContent class="flex flex-col gap-2">
                        <Card
                            v-for="chat in lastThreeChats"
                            :key="chat.id"
                        >
                            <CardContent
                                class="p-4 px-4 gap-2 grid grid-cols-[auto_1fr_auto] items-center"
                            >
                                <Avatar class="h-8 w-8 mr-2">
                                    <AvatarImage :src="`/storage/avatars/${getOtherAttendee(chat).avatar_url}`" alt="@shadcn" />
                                    <AvatarFallback>{{ getOtherAttendee(chat).name_initials }}</AvatarFallback>
                                </Avatar>
                                <div class="flex flex-col gap-1">
                                    <CardTitle>{{ getOtherAttendee(chat).name_full }}</CardTitle>
                                    <CardDescription class="line-clamp-2">{{ chat.message }}</CardDescription>
                                </div>
                                <Button
                                    variant="secondary"
                                    as-child
                                >
                                    <Link :href="route('events.chats.detail', { eventId: event.id, attendeeId: getOtherAttendee(chat).id })">
                                        Open
                                    </Link>
                                </Button>
                            </CardContent>
                        </Card>
                    </CardContent>
                    <CardFooter class="justify-end">
                        <Button
                            variant="secondary"
                            as-child
                        >
                            <Link :href="route('events.chats.index', { eventId: event.id })">
                                <span>Show all chats</span>
                            </Link>
                        </Button>
                    </CardFooter>
                </Card>
                <Card>
                    <CardHeader>
                        <CardTitle>Upcoming</CardTitle>
                        <CardDescription>Events and meetups</CardDescription>
                    </CardHeader>
                    <CardContent class="flex flex-col gap-2">
                        <Card
                            v-for="n in 3"
                            :key="n"
                        >
                            <CardContent class="p-4 px-4 gap-2 grid grid-cols-[1fr_auto] items-center">
                                <div class="flex flex-col gap-0">
                                    <CardTitle>Lorem</CardTitle>
                                    <CardDescription>Lorem Ipsum</CardDescription>
                                </div>
                                <Button>
                                    More
                                </Button>
                            </CardContent>
                        </Card>
                    </CardContent>
                    <CardFooter class="justify-end">
                        <Button variant="secondary" as-child>
                            <Link :href="route('events.detail.agenda', { eventId: event.id })">
                                <span>Go to your agenda</span>
                            </Link>
                        </Button>
                    </CardFooter>
                </Card>
            </div>
        </section>
    </EventLayout>
    <DefaultLayout v-else>
        <Alert v-if="event.state !== 'public'" variant="destructive" class="mb-5">
            <AlertTitle>This event is not public.</AlertTitle>
            <AlertDescription>You can see this event, because you are an event organizer.</AlertDescription>
        </Alert>
        <section class="event-detail">
            <div>
                <EventOverviewGeneral :event="event" />
                <EventOverviewProperties :event="event" />
            </div>
            <div>
                <Card>
                    <CardHeader>
                        <CardTitle>Join Event</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p>Join this event to connect with other attendees and keep up-to-date with {{ event.title }}</p>
                        <p class="text-muted-foreground mt-2" v-if="event.confirmation_required">This event requires a confirmation key.</p>
                        <p class="text-muted-foreground mt-2" v-else>This event does not require a confirmation key.</p>
                    </CardContent>
                    <CardFooter>
                        <Button class="w-full" disabled v-if="!canJoin">
                            This event is full
                        </Button>
                        <Button class="w-full" as-child v-else>
                            <Link :href="route('events.detail.enroll', { eventId: event.id })">
                                Join Event
                            </Link>
                        </Button>
                    </CardFooter>
                </Card>
            </div>
        </section>
    </DefaultLayout>
</template>

<script setup lang="ts">
import {Link, usePage} from '@inertiajs/vue3';
import EventLayout from "@/Layouts/EventLayout.vue";
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import EventOverviewGeneral from "@/components/Event/EventOverview/EventOverviewGeneral.vue";
import EventOverviewProperties from "@/components/Event/EventOverview/EventOverviewProperties.vue";
import {Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle} from "@/components/ui/card";
import {Button} from "@/components/ui/button";
import {Alert, AlertDescription, AlertTitle} from "@/components/ui/alert";
import {PropType} from "@vue/runtime-dom";
import {ChatMessage} from "@/types/models/ChatMessage";
import {Event} from "@/types/models/Event";
import {Attendee} from "@/types/models/Attendee";
import {computed} from "vue";
import {Avatar, AvatarFallback, AvatarImage} from "@/components/ui/avatar";

const props = defineProps({
    event: {
        type: Object as PropType<Event>,
        required: true,
    },
    canJoin: {
        type: Boolean,
        default: true,
    },
    lastThreeChats: {
        type: Object as PropType<ChatMessage>,
        default: () => [],
    },
    userAttendee: {
        type: [Object as PropType<Attendee>, Boolean],
        default: false,
    }
});


/* Get Current Users Attendee */
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
function getOtherAttendee(chatMessage) {
    if(chatMessage.sender_attendee_id === currentAttendee.value.id) {
        return chatMessage.receiver_attendee;
    } else {
        return chatMessage.sender_attendee;
    }
}
</script>

<style lang="scss" scoped>
.event-detail-enrolled {
    @apply flex flex-col gap-4 lg:grid lg:grid-cols-2;
}
.event-detail {
    @apply flex flex-col gap-4 lg:grid lg:grid-cols-[1fr_350px];
}
.event-detail-enrolled > div, .event-detail > div {
    @apply flex flex-col gap-4;
}
</style>

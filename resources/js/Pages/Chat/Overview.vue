<template>
    <EventLayout :event="event">
        <section
            class="chat-overview"
            v-if="currentAttendee !== null"
        >
            <aside>
                <Card>
                    <CardContent class="p-2 gap-2 flex flex-col">
                        <ConnectionButton
                            v-for="connection in connections"
                            :key="connection.id"
                            :current-attendee-id="currentAttendee.id"
                            :connection="connection"
                        />
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle>Connect with attendees</CardTitle>
                    </CardHeader>
                    <CardContent class="text-muted-foreground">
                        By connecting with other attendees, you can chat and schedule meetups during the event.
                    </CardContent>
                    <CardFooter>
                        <Button
                            variant="secondary"
                            class="w-full"
                            as-child
                        >
                            <Link
                                :href="route('events.attendees.index', {
                                eventId: event.id,
                            })"
                            >
                                <i class="ri-shake-hands-line mr-2 text-lg"></i>
                                <span>Connect with attendees</span>
                            </Link>
                        </Button>
                    </CardFooter>
                </Card>
            </aside>
            <main>
                <Card>
                    <CardHeader>
                        <CardTitle>Chat</CardTitle>
                    </CardHeader>
                    <CardContent>
                        Select an attendee to start chatting. Find other attendees in the attendee list and send them a connect request to be able to chat and schedule meetups.
                    </CardContent>
                </Card>
            </main>
        </section>
    </EventLayout>
</template>

<script setup lang="ts">
import {Link, usePage} from '@inertiajs/vue3';
import EventLayout from "@/Layouts/EventLayout.vue";
import {PropType} from "@vue/runtime-dom";
import {Event} from "@/types/models/Event";
import {AttendeeConnection} from "@/types/models/AttendeeConnection";
import ConnectionButton from "@/components/Chat/ConnectionButton.vue";
import {computed} from "vue";
import {Card, CardContent, CardFooter, CardHeader, CardTitle} from "@/components/ui/card";
import {Button} from "@/components/ui/button";

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

const props = defineProps({
    event: {
        type: Object as PropType<Event>,
        required: true,
    },
    connections: {
        type: Array as PropType<AttendeeConnection[]>,
        default: () => []
    },
});
</script>

<style lang="scss" scoped>
.chat-overview {
    @apply flex flex-col lg:grid lg:grid-cols-[1fr_2fr] gap-5;

    & aside {
        @apply flex flex-col gap-5;
    }
}
</style>

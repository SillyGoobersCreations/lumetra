<template>
    <Head title="Chat" />

    <EventLayout :event="event">
        <section
            class="chat-overview"
            v-if="currentAttendee !== null"
        >
            <aside>
                <Card>
                    <CardContent class="flex flex-col gap-2 p-2">
                        <ConnectionButton
                            v-for="connection in connections"
                            :key="connection.id"
                            :current-attendee-id="currentAttendee.id"
                            :active="connection.id === selectedConnection.id"
                            :connection="connection"
                        />
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle>Connect with attendees</CardTitle>
                    </CardHeader>
                    <CardContent class="text-muted-foreground"> By connecting with other attendees, you can chat and schedule meetups during the event. </CardContent>
                    <CardFooter>
                        <Button
                            variant="secondary"
                            class="w-full"
                            as-child
                        >
                            <Link
                                :href="
                                    route('events.attendees.index', {
                                        eventId: event.id,
                                    })
                                "
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
                    <CardHeader class="flex-row items-center py-4">
                        <Avatar class="mr-2 h-8 w-8">
                            <AvatarImage
                                :src="`/storage/avatars/${attendee.avatar_url}?v=${attendee.updated_at}`"
                                v-if="attendee.avatar_url"
                            />
                            <AvatarFallback>{{ attendee.name_initials }}</AvatarFallback>
                        </Avatar>
                        <div class="flex grow flex-col space-y-1">
                            <p class="text-sm font-medium leading-none">
                                {{ attendee.name_full }}
                            </p>
                            <p class="text-xs leading-none text-muted-foreground">Connected {{ moment(selectedConnection.created_at).fromNow() }}</p>
                        </div>
                        <div>
                            <Button
                                variant="secondary"
                                size="icon"
                                as-child
                            >
                                <Link :href="route('events.attendees.detail', { eventId: event.id, attendeeId: attendee.id })">
                                    <i class="ri-arrow-right-up-line text-lg"></i>
                                </Link>
                            </Button>
                        </div>
                    </CardHeader>
                    <CardContent class="chat-messages">
                        <MessageConnection
                            :connection="selectedConnection"
                            :current-attendee-id="currentAttendee.id"
                        />
                        <template
                            v-for="message in loadedMessages"
                            :key="message.id"
                        >
                            <MessageRoomSlotClaim
                                v-if="message.is_room_slot_invite"
                                :is-remote="message.sender_attendee_id !== currentAttendee.id"
                                :claim="parseRoomSlotClaim(message.message)"
                                :event-id="event.id"
                                :attendee-id="attendee.id"
                                :confirmedUserSlots="confirmedUserSlots"
                            />
                            <Message
                                v-else
                                :is-remote="message.sender_attendee_id !== currentAttendee.id"
                            >
                                <template #default>
                                    {{ message.message }}
                                </template>
                            </Message>
                        </template>
                    </CardContent>
                    <CardFooter
                        class="flex gap-2"
                        v-if="selectedConnection.state === 'confirmed'"
                    >
                        <MeetDialog
                            :event="event"
                            :selectedConnection="selectedConnection"
                            :confirmedUserSlots="confirmedUserSlots"
                            :confirmedAttendeeSlots="confirmedAttendeeSlots"
                        />
                        <Input
                            placeholder="Message..."
                            v-model="messageForm.message"
                            @keyup.enter="sendChat"
                        />
                        <Button @click="sendChat">
                            <span>Send</span>
                        </Button>
                    </CardFooter>
                </Card>
            </main>
        </section>
    </EventLayout>
</template>

<script setup lang="ts">
import EventLayout from '@/Layouts/EventLayout.vue';
import ConnectionButton from '@/components/Chat/ConnectionButton.vue';
import MeetDialog from '@/components/Chat/MeetDialog.vue';
import Message from '@/components/Chat/Message.vue';
import MessageConnection from '@/components/Chat/MessageConnection.vue';
import MessageRoomSlotClaim from '@/components/Chat/MessageRoomSlotClaim.vue';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { AttendeeConnection } from '@/types/models/AttendeeConnection';
import { Event } from '@/types/models/Event';
import { EventRoomSlotClaim } from '@/types/models/EventRoomSlotClaim';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import moment from 'moment';
import { PropType, computed, onMounted, onUnmounted, ref } from 'vue';

const loadedMessages = ref([]);
let messageTimer: number | undefined;

/* Get Current Users Attendee */
const page = usePage();
const attendees = computed(() => page.props.auth.attendees);
const currentAttendee = computed(() => {
    let foundAttendee = null;

    attendees.value.forEach((attendee) => {
        if (attendee.event_id === props.event.id) {
            foundAttendee = attendee;
        }
    });

    return foundAttendee;
});

const props = defineProps({
    event: {
        type: Object as PropType<Event>,
        required: true,
    },
    connections: {
        type: Array as PropType<AttendeeConnection[]>,
        default: () => [],
    },
    selectedConnection: {
        type: Object as PropType<AttendeeConnection>,
        required: true,
    },
    confirmedUserSlots: {
        type: Array,
        default: () => [],
    },
    confirmedAttendeeSlots: {
        type: Array,
        default: () => [],
    },
});

/* Get the other Attendee */
const attendee = computed(() => {
    if (currentAttendee.value?.id === props.selectedConnection?.inviter_attendee_id) {
        return props.selectedConnection.invitee_attendee;
    } else {
        return props.selectedConnection.inviter_attendee;
    }
});

const messageForm = useForm({
    message: '',
});

async function sendChat() {
    messageForm.post(
        route('events.chats.sendMessage', {
            eventId: props.event.id,
            attendeeId: attendee.value.id,
        }),
        {
            onSuccess: () => {
                messageForm.reset('message');
                updateChat();
            },
        },
    );
}

async function updateChat() {
    const url = route('events.chats.receive', {
        eventId: props.event.id,
        attendeeId: attendee.value?.id,
    });
    const response = await fetch(url);
    loadedMessages.value = await response.json();
}

function parseRoomSlotClaim(message: string): EventRoomSlotClaim {
    const parsed = JSON.parse(message);
    return parsed as EventRoomSlotClaim;
}

onMounted(() => {
    messageTimer = setInterval(updateChat, 2000);
    updateChat();
});
onUnmounted(() => {
    clearInterval(messageTimer);
});
</script>

<style lang="scss" scoped>
.chat-overview {
    @apply flex flex-col gap-5 lg:grid lg:grid-cols-[1fr_2fr];

    & aside {
        @apply flex flex-col gap-5;
    }
    & .chat-messages {
        @apply mb-4 flex flex-col gap-2 border-b border-t p-6;
    }
}
</style>

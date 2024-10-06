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
                            :active="connection.id === selectedConnection.id"
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
                    <CardHeader class="flex-row items-center">
                        <Avatar class="h-8 w-8 mr-2">
                            <AvatarImage :src="`/storage/avatars/${attendee.avatar_url}`" alt="@shadcn" />
                            <AvatarFallback>{{ attendee.name_initials }}</AvatarFallback>
                        </Avatar>
                        <div class="flex flex-col space-y-1">
                            <p class="text-sm font-medium leading-none">
                                {{ attendee.name_full }}
                            </p>
                            <p class="text-xs leading-none text-muted-foreground">
                                Connected {{ moment(selectedConnection.created_at).fromNow() }}
                            </p>
                        </div>
                    </CardHeader>
                    <CardContent class="flex flex-col gap-2">
                        <MessageConnection
                            :connection="selectedConnection"
                            :current-attendee-id="currentAttendee.id"
                        />
                        <Message
                            v-for="message in messages"
                            :key="message.id"
                            :is-remote="message.sender_attendee_id !== currentAttendee.id"
                        >
                            <template #default>
                                {{ message.message }}
                            </template>
                        </Message>
                    </CardContent>
                    <CardFooter class="flex gap-2">

                        <MeetDialog
                            :event="event"
                            :selectedConnection="selectedConnection"
                        />
                        <Input placeholder="Message..." v-model="messageForm.message" @keyup.enter="sendChat"/>
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
import {Link, useForm, usePage} from '@inertiajs/vue3';
import EventLayout from "@/Layouts/EventLayout.vue";
import {PropType} from "@vue/runtime-dom";
import {Event} from "@/types/models/Event";
import {AttendeeConnection} from "@/types/models/AttendeeConnection";
import ConnectionButton from "@/components/Chat/ConnectionButton.vue";
import {computed, onMounted, onUnmounted, ref} from "vue";
import {ChatMessage} from "@/types/models/ChatMessage";
import moment from "moment";
import MessageConnection from "@/components/Chat/MessageConnection.vue";
import Message from "@/components/Chat/Message.vue";
import {Card, CardContent, CardFooter, CardHeader, CardTitle} from "@/components/ui/card";
import {Button} from "@/components/ui/button";
import {Avatar, AvatarFallback, AvatarImage} from "@/components/ui/avatar";
import {Input} from "@/components/ui/input";
import MeetDialog from "@/components/Chat/MeetDialog.vue";

const messages = ref([]);
let messageTimer : number|undefined;

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

const props = defineProps({
    event: {
        type: Object as PropType<Event>,
        required: true,
    },
    connections: {
        type: Array as PropType<AttendeeConnection[]>,
        default: () => []
    },
    selectedConnection: {
        type: Object as PropType<AttendeeConnection>,
        required: true,
    },
    messages: {
        type: Array as PropType<ChatMessage[]>,
        default: () => []
    }
});

/* Get the other Attendee */
const attendee = computed(() => {
    if(currentAttendee.value?.id === props.selectedConnection?.inviter_attendee_id) {
        return props.selectedConnection.invitee_attendee;
    } else {
        return props.selectedConnection.inviter_attendee;
    }
});

const messageForm = useForm({
    message: '',
});

async function sendChat() {
    messageForm.post(route('events.chats.sendMessage', {
        eventId: props.event.id,
        attendeeId: attendee.value.id,
    }), {
        onSuccess: () => {
            messageForm.reset('message');
            updateChat();
        },
    });
}

async function updateChat() {
    const url = route('events.chats.receive', {
        eventId: props.event.id,
        attendeeId: attendee.value?.id,
    });
    const response = await fetch(url);
    messages.value = await response.json();
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
    @apply flex flex-col lg:grid lg:grid-cols-[1fr_2fr] gap-5;

    & aside {
        @apply flex flex-col gap-5;
    }

    /*
    & > aside {
        display: flex;
        flex-direction: column;
        gap: 20px;

        & .connection-list {
            padding: 5px;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        & .more-button {
            justify-content: center;
        }
    }
    & > main {
        display: flex;
        flex-direction: column;

        & .box {
            flex-grow: 1;
            overflow: hidden;
            display: grid;
            grid-template-rows: auto 1fr auto;

            & header {
                padding: 10px 20px;
                border-bottom: 1px solid rgb(var(--color-base-200));

                & .attendee {
                    background: rgb(var(--color-base-50));
                    border-radius: 5px;
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    overflow: hidden;
                    text-decoration: none;
                    color: inherit;
                    transition: var(--transition-default);

                    &.active {
                        background: rgb(var(--color-base-200));
                    }

                    & .meta {
                        display: flex;
                        flex-direction: column;
                        gap: 5px;
                        flex-grow: 1;

                        & .name {
                            overflow: hidden;
                            text-overflow: ellipsis;
                            white-space: nowrap;
                            flex-grow: 1;
                        }
                        & .connected {
                            font-size: 0.75rem;
                            color: rgb(var(--color-base-400));
                        }
                    }
                }
            }
            & main {
                min-height: 250px;
                padding: 20px;
                display: flex;
                flex-direction: column;
                gap: 10px;
            }
            & footer {
                border-top: 1px solid rgb(var(--color-base-200));
                padding: 10px 20px;
            }
        }
    } */
}
</style>

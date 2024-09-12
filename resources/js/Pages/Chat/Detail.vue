<template>
    <EventLayout :event="event">
        <section
            class="chat-overview"
            v-if="currentAttendee !== null"
        >
            <aside>
                <Box :no-padding="true" class="connection-list">
                    <ConnectionButton
                        v-for="connection in connections"
                        :key="connection.id"
                        :current-attendee-id="currentAttendee.id"
                        :active="connection.id === selectedConnection.id"
                        :connection="connection"
                    />
                </Box>

                <Link
                    :href="route('events.attendees.index', {
                        eventId: event.id,
                    })"
                    class="button primary more-button"
                >
                    <i class="ri-shake-hands-line"></i>
                    <span>Connect with attendees</span>
                </Link>
            </aside>
            <main>
                <Box :no-padding="true">
                    <header>
                        <div class="attendee">
                            <Avatar :attendee="attendee" />
                            <div class="meta">
                                <div class="name">{{ attendee.name_full }}</div>
                                <div class="connected">Connected {{ moment(selectedConnection.created_at).fromNow() }}</div>
                            </div>
                        </div>
                    </header>
                    <main>
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
                    </main>
                    <footer>
                        <!-- TODO Tara: This needs a text input and a button to submit. Pressing enter in the text input should also submit -->
                        <!-- TODO Tara: The submit needs useForm to send to route('events.chats.sendMessage') and onFinish clear the text -->
                        Chat Box + Invite Button
                    </footer>
                </Box>
            </main>
        </section>
    </EventLayout>
</template>

<script setup lang="ts">
import {Link, usePage} from '@inertiajs/vue3';
import EventLayout from "@/Layouts/EventLayout.vue";
import Box from "@/components/Common/Box.vue";
import {PropType} from "@vue/runtime-dom";
import {Event} from "@/types/models/Event";
import {AttendeeConnection} from "@/types/models/AttendeeConnection";
import ConnectionButton from "@/components/Chat/ConnectionButton.vue";
import {computed, onMounted, onUnmounted, ref} from "vue";
import {ChatMessage} from "@/types/models/ChatMessage";
import moment from "moment";
import Avatar from "@/components/Common/Avatar.vue";
import MessageConnection from "@/components/Chat/MessageConnection.vue";
import Message from "@/components/Chat/Message.vue";

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

/* TODO Tara: Form to Send to 'events.chats.sendMessage' */
/* TODO Tara: Function to send the form and clear the input */

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
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 20px;
    position: relative;

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
    }
}
</style>

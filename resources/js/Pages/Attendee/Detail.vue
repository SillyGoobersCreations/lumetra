<template>
    <EventLayout :event="event">
        <section class="attendee-deactivated" v-if="!attendee.active">
            DEACTIVATED
            <!-- TODO -->
        </section>
        <section class="attendee-detail" v-if="attendee.active">
            <div>
                <div class="avatar-and-name">
                    <Avatar :attendee="attendee" :size="128" />
                    <div class="name">
                        <span>{{ attendee.name_full }}</span>
                        <span>{{ attendee.handle }}</span>
                    </div>
                </div>
                <Box class="details">
                    <div class="info-item" v-if="attendee.job_position || attendee.job_company">
                        <span v-if="attendee.job_position">{{ attendee.job_position }}</span>
                        <span v-if="attendee.job_company">{{ attendee.job_company }}</span>
                    </div>
                    <div class="info-item">
                        <span>Confirmation Status</span>
                        <span>{{ attendee.confirmed ? 'Confirmed Attendee' : 'Unconfirmed Attendee' }}</span>
                    </div>
                    <div class="info-item">
                        <span>Registered</span>
                        <span>{{ moment(attendee.created_at).fromNow() }}</span>
                    </div>
                </Box>
                <Box class="description">
                    {{ attendee.description }}
                </Box>
                <div class="actions" v-if="attendee.id === currentAttendee.id">
                    <Link
                        :href="route('settings.event', {
                            eventId: event.id,
                        })"
                        class="button primary"
                    >
                        <i class="ri-settings-2-line"></i>
                        <span>Profile Settings</span>
                    </Link>
                </div>
                <div class="actions" v-if="attendee.id !== currentAttendee.id">
                    <button
                        @click="connectModal?.open()"
                        class="primary"
                        v-if="connection === null"
                    >
                        <i class="ri-shake-hands-line"></i>
                        <span>Connect</span>
                    </button>
                    <template v-if="connection !== null">
                        <Link
                            :href="route('events.attendees.disconnect', {
                                eventId: event.id,
                                attendeeId: attendee.id,
                            })"
                            v-if="connection.state === 'confirmed'"
                            method="post"
                            as="button"
                            type="button"
                            class="danger"
                        >
                            <i class="ri-delete-bin-line"></i>
                            <span>Disconnect</span>
                        </Link>
                        <template v-else>
                            <button
                                disabled
                                v-if="connection.inviter_attendee_id === currentAttendee.id"
                            >
                                <span>Connect request pending</span>
                            </button>
                            <template v-if="connection.inviter_attendee_id !== currentAttendee.id && connection.state === 'pending'">
                                <Link
                                    :href="route('events.attendees.connect.accept', {
                                        eventId: event.id,
                                        attendeeId: attendee.id,
                                        requestId: connection.id,
                                    })"
                                    class="button primary"
                                >
                                    <i class="ri-shake-hands-line"></i>
                                    <span>Accept</span>
                                </Link>
                                <Link
                                    :href="route('events.attendees.connect.decline', {
                                        eventId: event.id,
                                        attendeeId: attendee.id,
                                        requestId: connection.id,
                                    })"
                                    class="button danger"
                                >
                                    <i class="ri-delete-bin-line"></i>
                                    <span>Decline</span>
                                </Link>
                            </template>
                        </template>
                    </template>
                </div>
            </div>
            <div>
                <!-- TODO: Visibility -->
                <Box
                    v-if="attendee.contact_infos.length > 0"
                    class="contact-infos"
                    :noPadding="true"
                >
                    <div
                        class="item"
                        :key="contact_info.id"
                        v-for="contact_info in attendee.contact_infos"
                    >
                        <i :class="getContactInfoIcon(contact_info.type)"></i>
                        <span>{{ getContactInfoLabel(contact_info.type, contact_info.value) }}</span>
                        <a
                            :href="getContactInfoLink(contact_info.type, contact_info.value)"
                            target="_blank"
                            class="button"
                            v-if="contact_info.type !== 'discord'"
                        >
                            <i class="ri-external-link-line"></i>
                            <span>Visit</span>
                        </a>
                    </div>
                </Box>
            </div>
        </section>
    </EventLayout>

    <Modal
        ref="connectModal"
        class="modal-connect"
        size="s"
        :title="`Connect with ${ attendee.name_full }`"
        :can-close="!connectRequestForm.processing"
        @closed="connectRequestForm.clearErrors('intro_text')"
    >
        <template #actions>
            <button class="primary" :disabled="connectRequestForm.processing" @click="sendConnectRequest">
                <i class="ri-send-plane-2-line"></i>
                <span>Send Request</span>
            </button>
        </template>
        <template #default>
            <div class="loading" v-show="connectRequestForm.processing">
                <LoadingCircle />
            </div>
            <form
                @submit.prevent="sendConnectRequest"
                v-show="!connectRequestForm.processing"
            >
                <textarea
                    v-model="connectRequestForm.intro_text"
                    :disabled="connectRequestForm.processing"
                    placeholder="Hey, let's connect!"
                ></textarea>
                <div class="error" v-if="connectRequestForm.errors.intro_text">{{ connectRequestForm.errors.intro_text }}</div>
            </form>
        </template>
    </Modal>
</template>

<script setup lang="ts">
import moment from "moment";
import EventLayout from "@/Layouts/EventLayout.vue";
import Box from "@/Components/Common/Box.vue";
import {Link, useForm, usePage} from "@inertiajs/vue3";
import Modal from "@/Components/Common/Modal.vue";
import {computed, ref} from "vue";
import {PropType} from "@vue/runtime-dom";
import {Event} from "@/types/models/Event";
import {Attendee} from "@/types/models/Attendee";
import LoadingCircle from "@/Components/Common/LoadingCircle.vue";
import {AttendeeConnection} from "@/types/models/AttendeeConnection";
import Avatar from "@/Components/Common/Avatar.vue";

const connectModal = ref<InstanceType<typeof Modal> | null>(null);

const props = defineProps({
    event: {
        type: Object as PropType<Event>,
        required: true,
    },
    attendee: {
        type: Object as PropType<Attendee>,
        default: false,
    },
    connection: {
        type: Object as PropType<AttendeeConnection>,
        default: null,
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

/* CONNECT REQUEST */
const connectRequestForm = useForm({
    intro_text: '',
});

function sendConnectRequest() {
    connectRequestForm.post(route('events.attendees.connect', {
        eventId: props.event.id,
        attendeeId: props.attendee.id,
    }), {
        onSuccess: () => {
            connectRequestForm.reset('intro_text');
            connectModal.value?.close();
        },
    })
}

function getContactInfoIcon(type: string) {
    switch(type) {
        case "web":
            return "ri-earth-fill";
        case "twitter":
            return "ri-twitter-fill";
        case "bluesky":
            return "ri-bluesky-fill";
        case "facebook":
            return "ri-facebook-fill";
        case "linkedin":
            return "ri-linkedin-fill";
        case "discord":
            return "ri-discord-fill";
        case "mastodon":
            return "ri-mastodon-fill";
        case "github":
            return "ri-github-fill";
        case "youtube":
            return "ri-youtube-fill";
        case "reddit":
            return "ri-reddit-fill";
    }
}

function getContactInfoLabel(type: string, value: string) {
    switch(type) {
        case "web":
            return "Website";
        case "mastodon":
            return "Mastodon";
        case "reddit":
            return `/u/${value}`;
        default:
            return `@${value}`;
    }
}

function getContactInfoLink(type: string, value: string) {
    switch(type) {
        case "web":
            return value;
        case "twitter":
            return `https://x.com/${value}`;
        case "bluesky":
            return `https://bsky.app/profile/${value}`;
        case "facebook":
            return `https://www.facebook.com/${value}`;
        case "linkedin":
            return `https://www.linkedin.com/in/${value}`;
        case "discord":
            return "ri-discord-fill";
        case "mastodon":
            return value;
        case "github":
            return `https://github.com/${value}`;
        case "youtube":
            return `https://www.youtube.com/@${value}`;
        case "reddit":
            return `https://reddit.com/u/${value}`;
    }
}
</script>

<style lang="scss" scoped>
.attendee-detail {
    display: grid;
    grid-template-columns: 2fr 3fr;
    gap: 15px;
    margin: 30px auto;

    & > div {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
}
.avatar-and-name {
    display: flex;
    flex-direction: column;
    gap: 20px;

    & .avatar {
        margin: 0 auto;
    }
    & .name {
        text-align: center;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        gap: 2px;

        & span {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;

            &:nth-child(1) {
                font-size: 1.15rem;
            }
            &:nth-child(2) {
                color: rgb(var(--color-base-400));
            }
        }
    }
}
.details {
    display: flex;
    flex-direction: column;
    gap: 20px;
    overflow: hidden;

    & .info-item {
        display: flex;
        flex-direction: column;
        gap: 5px;

        & span {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        & span:nth-child(2) {
            color: rgb(var(--color-base-400));
        }
    }
}
.description {
    line-height: 1.5rem;
}
.actions {
    display: flex;
    gap: 5px;

    & button, & .button {
        flex-grow: 1;
    }
}
.contact-infos {
    display: flex;
    flex-direction: column;

    & .item {
        display: grid;
        grid-template-columns: auto 1fr auto;
        gap: 10px;
        align-items: center;
        padding: 10px;

        &:not(:last-of-type) {
            border-bottom: 1px solid rgb(var(--color-base-200));
        }

        & > *[class^="ri-"] {
            font-size: 22px;
            width: 36px;
            height: 36px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 100px;
            background: rgb(var(--color-primary-500));
            color: rgb(var(--color-primary-50));
        }
        & > span:nth-child(2) {
        }
    }
}
.modal-connect {
    & form {
        height: 100%;
        display: flex;
        flex-direction: column;
        gap: 20px;

        & textarea {
            flex-grow: 1;
        }
        & .error {
            color: rgb(var(--color-danger-500));
            font-size: 0.85rem;
        }
    }

    & .loading {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 50px 0;
        height: 100%;
    }
}
</style>

<template>
    <EventLayout :event="event">
        <section class="attendee-detail">
            <div>
                <Box class="details">
                    <div class="avatar" v-if="attendee.avatar_url"></div>
                    <div class="avatar fallback" v-else>{{ attendee.name_initials }}</div>
                    <div class="name">{{ attendee.name_full }}</div>
                    <div class="job-info" v-if="attendee.job_position || attendee.job_company">
                        <span v-if="attendee.job_position">{{ attendee.job_position }}</span>
                        <span v-if="attendee.job_company">{{ attendee.job_company }}</span>
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
                </Box>
            </div>
            <div>
                <Box>
                    {{ attendee.description }}
                </Box>
                <Box>
                    <pre>Handle: {{ attendee.handle ? attendee.handle : "null" }}</pre><br />
                    <pre>Confirmed: {{ attendee.confirmed ? attendee.confirmed : "null" }}</pre><br />
                    <pre>Active: {{ attendee.active ? attendee.active : "null" }}</pre><br />
                    <pre>Role: {{ attendee.role ? attendee.role : "null" }}</pre><br />
                    <pre>ContactInfos: {{ attendee.contact_infos }}</pre><br />
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
import EventLayout from "@/Layouts/EventLayout.vue";
import Box from "@/Components/Common/Box.vue";
import {Link, useForm, usePage} from "@inertiajs/vue3";
import Modal from "@/Components/Common/Modal.vue";
import {computed, ref} from "vue";
import {PropType} from "@vue/runtime-dom";
import {Event} from "@/types/models/Event";
import {Attendee} from "@/types/models/Attendee";
import AuthLayout from "@/Layouts/AuthLayout.vue";
import {send} from "vite";
import LoadingCircle from "@/Components/Common/LoadingCircle.vue";
import {AttendeeConnection} from "@/types/models/AttendeeConnection";

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
        type: [Object as PropType<AttendeeConnection>, null],
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
</script>

<style lang="scss" scoped>
.attendee-detail {
    display: grid;
    grid-template-columns: 350px 1fr;
    gap: 15px;
}
.attendee-detail > div {
    display: flex;
    flex-direction: column;
    gap: 15px;
}
.details {
    display: flex;
    flex-direction: column;
    gap: 15px;
    overflow: hidden;

    & .avatar {
        margin: 0 auto;
        width: 128px;
        height: 128px;
        background: rgb(var(--color-base-200));
        background-position: center;
        background-size: cover;
        border-radius: 100px;

        &.fallback {
            font-size: 2rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgb(var(--color-base-200));
        }
    }
    & .name {
        font-size: 1.15rem;
        text-align: center;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    & .job-info {
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
    & .actions {
        flex-grow: 1;
        display: flex;
        align-items: flex-end;
        gap: 5px;

        & button, & .button {
            flex-grow: 1;
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

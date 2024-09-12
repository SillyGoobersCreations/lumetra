<template>
    <EventLayout :event="event">
        <section class="attendee-deactivated" v-if="!attendee.active">
            <Alert variant="destructive">
                <AlertTitle>Deactivated attendee</AlertTitle>
                <AlertDescription>
                    This attendee decided to leave this event. It is not possible to see this profile or chat with them anymore unless they re-join this event.
                </AlertDescription>
            </Alert>
        </section>
        <section class="attendee-detail" v-if="attendee.active">
            <div>
                <div class="avatar-and-name">
                    <div class="flex w-full justify-center">
                        <Avatar class="h-[128px] w-[128px]">
                            <AvatarImage :src="`/storage/avatars/${attendee.avatar_url}`" alt="@shadcn" />
                            <AvatarFallback class="text-3xl">{{ attendee.name_initials }}</AvatarFallback>
                        </Avatar>
                    </div>
                    <div class="name">{{ attendee.name_full }}</div>
                </div>
                <Card>
                    <CardContent class="pt-6 flex flex-col gap-2">
                        <div class="grid grid-cols-[1fr_2fr] gap-2 items-center" v-if="attendee.job_company">
                            <Label>Company</Label>
                            <span class="text-muted-foreground">{{ attendee.job_company }}</span>
                        </div>
                        <div class="grid grid-cols-[1fr_2fr] gap-2 items-center" v-if="attendee.job_position">
                            <Label>Position</Label>
                            <span class="text-muted-foreground">{{ attendee.job_position }}</span>
                        </div>
                        <div class="grid grid-cols-[1fr_2fr] gap-2 items-center">
                            <Label>Registered</Label>
                            <span class="text-muted-foreground">{{ moment(attendee.created_at).fromNow() }}</span>
                        </div>
                    </CardContent>
                </Card>
                <Card>
                    <CardContent
                        v-if="attendee.description"
                        class="pt-6"
                    >
                        {{ attendee.description }}
                    </CardContent>
                    <CardContent
                        v-else
                        class="pt-6 text-muted-foreground"
                    >
                        No description has been provided yet.
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader>
                        <CardTitle>Confirmation status</CardTitle>
                    </CardHeader>
                    <CardContent v-if="attendee.confirmed" class="text-green-400">This attendee is a confirmed attendee for this event.</CardContent>
                    <CardContent v-if="!attendee.confirmed" class="text-red-400">This attendee is a not confirmed attendee for this event.</CardContent>
                </Card>
                <div class="flex flex-col gap-2">
                    <Button
                        v-if="attendee.id === currentAttendee.id"
                        class="w-full justify-start"
                        variant="secondary"
                        as-child
                    >
                        <Link
                            :href="route('settings.event', {
                            eventId: event.id,
                        })"
                        >
                            <i class="ri-settings-2-line mr-2 text-lg"></i>
                            <span>Profile Settings</span>
                        </Link>
                    </Button>

                    <template v-if="attendee.id !== currentAttendee.id">
                        <!-- Users are not connected, show modal -->
                        <Card
                            v-if="connection == null"
                        >
                            <CardHeader>
                                <CardTitle>Connection</CardTitle>
                            </CardHeader>
                            <CardContent>
                                Connect with this attendee to chat and schedule in-person meetings.
                            </CardContent>
                            <CardFooter>
                                <ConnectionRequestDialog
                                    :event="event"
                                    :attendee="attendee"
                                />
                            </CardFooter>
                        </Card>
                        <template v-if="connection !== null">
                            <Card
                                v-if="connection.state === 'confirmed'"
                            >
                                <CardHeader>
                                    <CardTitle>Connection</CardTitle>
                                </CardHeader>
                                <CardContent>
                                    You and this attendee have been connected for {{ moment(connection.updated_at).fromNow(true) }}
                                </CardContent>
                                <CardFooter>
                                    <Button
                                        as-child
                                        class="w-full"
                                        variant="destructive"
                                    >
                                        <!-- Users are connected, show disconnect -->
                                        <Link
                                            :href="route('events.attendees.disconnect', {
                                                eventId: event.id,
                                                attendeeId: attendee.id,
                                            })"
                                            method="post"
                                            as="button"
                                            type="button"
                                        >
                                            <i class="ri-delete-bin-line"></i>
                                            <span>Disconnect</span>
                                        </Link>
                                    </Button>
                                </CardFooter>
                            </Card>
                            <template v-else>
                                <!-- User was the one requesting, show pending -->
                                <Card
                                    v-if="connection.inviter_attendee_id === currentAttendee.id"
                                >
                                    <CardHeader>
                                        <CardTitle>Connection request</CardTitle>
                                    </CardHeader>
                                    <CardContent>
                                        This attendee did not accept or decline your request yet.
                                    </CardContent>
                                    <CardFooter>
                                        <Button
                                            disabled
                                            class="w-full"
                                        >
                                            <span>Request pending</span>
                                        </Button>
                                    </CardFooter>
                                </Card>
                                <!-- User was the one to be requested, show request and accept/decline -->
                                <template v-if="connection.inviter_attendee_id !== currentAttendee.id && connection.state === 'pending'">
                                    <Card>
                                        <CardHeader>
                                            <CardTitle>Connect request</CardTitle>
                                        </CardHeader>
                                        <CardContent>{{ connection.intro_text }}</CardContent>
                                        <CardFooter class="flex gap-2">
                                            <Button class="grow" variant="destructive" as-child>
                                                <Link
                                                    :href="route('events.attendees.connect.decline', {
                                                        eventId: event.id,
                                                        attendeeId: attendee.id,
                                                        requestId: connection.id,
                                                    })"
                                                >
                                                    <i class="ri-delete-bin-line mr-2 text-lg"></i>
                                                    <span>Decline</span>
                                                </Link>
                                            </Button>
                                            <Button class="grow" as-child>
                                                <Link
                                                    :href="route('events.attendees.connect.accept', {
                                                        eventId: event.id,
                                                        attendeeId: attendee.id,
                                                        requestId: connection.id,
                                                    })"
                                                >
                                                    <i class="ri-shake-hands-line mr-2 text-lg"></i>
                                                    <span>Accept</span>
                                                </Link>
                                            </Button>
                                        </CardFooter>
                                    </Card>
                                </template>
                            </template>
                        </template>
                    </template>
                </div>

                <!-- OLD -->
                <!--
                <div class="actions" v-if="attendee.id !== currentAttendee.id">
                    <button
                        @click="connectModal?.open()"
                        class="primary"
                        v-if="connection === null"
                    >
                    </button>
                    <template v-if="connection !== null">
                    </template>
                </div> -->
            </div>
            <div>
                <!-- TODO: Visibility -->
                <Card>
                    <CardHeader>
                        <CardTitle>Contact information</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div
                            v-if="attendee.contact_infos.length > 0"
                            class="flex flex-col gap-4"
                        >
                            <div
                                class="flex gap-2 items-center"
                                v-for="contact_info in attendee.contact_infos"
                                :key="contact_info.id"
                            >
                                <i :class="`${getContactInfoIcon(contact_info.type)} text-lg`"></i>
                                <span class="grow text-muted-foreground">{{ getContactInfoLabel(contact_info.type, contact_info.value) }}</span>
                                <Button
                                    v-if="contact_info.type !== 'discord'"
                                    variant="secondary"
                                    size="xs"
                                    as-child
                                >
                                    <a
                                        :href="getContactInfoLink(contact_info.type, contact_info.value)"
                                        target="_blank"
                                    >
                                        <i class="ri-external-link-line mr-2 text-lg"></i>
                                        <span>Visit</span>
                                    </a>
                                </Button>
                            </div>
                        </div>
                        <div v-else class="text-muted-foreground">
                            This user has not setup any contact information yet.
                        </div>
                    </CardContent>
                </Card>
            </div>
        </section>
    </EventLayout>
</template>

<script setup lang="ts">
import moment from "moment";
import EventLayout from "@/Layouts/EventLayout.vue";
import {Link, useForm, usePage} from "@inertiajs/vue3";
import Modal from "@/components/Common/Modal.vue";
import {computed, ref} from "vue";
import {PropType} from "@vue/runtime-dom";
import {Event} from "@/types/models/Event";
import {Attendee} from "@/types/models/Attendee";
import {AttendeeConnection} from "@/types/models/AttendeeConnection";
import {Alert, AlertDescription, AlertTitle} from "@/components/ui/alert";
import {Avatar, AvatarFallback, AvatarImage} from "@/components/ui/avatar";
import {Card, CardContent, CardFooter, CardHeader, CardTitle} from "@/components/ui/card";
import {Label} from "@/components/ui/label";
import {Button} from "@/components/ui/button";
import ConnectionRequestDialog from "@/components/Attendee/ConnectionRequestDialog.vue";

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
.attendee-deactivated {
    @apply my-10 md:my-20 max-w-xl mx-auto;
}
.attendee-detail {
    @apply grid grid-cols-[2fr_3fr] gap-4 my-8;

    & > div {
        @apply flex flex-col gap-4;
    }

    & .avatar-and-name {
        @apply flex flex-col gap-2;

        & .name {
            @apply line-clamp-1 text-center mt-2 font-bold;
        }
    }
}
.connect-dialog {
    & .loading {
        @apply w-full flex justify-center py-10;
    }
    & .error {
        @apply mt-2 text-sm text-red-400;
    }
}
/*
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
} */
</style>

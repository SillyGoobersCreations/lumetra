<template>
    <Dialog>
        <DialogTrigger as-child>
            <slot />
        </DialogTrigger>
        <DialogScrollContent class="max-w-3xl">
            <DialogHeader>
                <DialogTitle>{{ attendee.name_full }}</DialogTitle>
                <DialogDescription>{{ attendee.id }}</DialogDescription>
            </DialogHeader>
            <div class="flex flex-col gap-4">
                <Card>
                    <CardHeader>
                        <CardTitle>General</CardTitle>
                    </CardHeader>
                    <CardContent class="flex flex-col gap-4">
                        <FormRow
                            label="ID"
                            variant="wide"
                        >
                            <div class="text-muted-foreground">{{ attendee.id }}</div>
                        </FormRow>
                        <FormRow
                            label="User ID"
                            variant="wide"
                        >
                            <div class="text-muted-foreground">{{ attendee.user?.id }}</div>
                        </FormRow>
                        <FormRow
                            label="User Email"
                            variant="wide"
                        >
                            <div class="text-muted-foreground">{{ attendee.user?.email }}</div>
                        </FormRow>
                        <FormRow
                            label="Handle"
                            variant="wide"
                        >
                            <div class="text-muted-foreground">{{ attendee.handle }}</div>
                        </FormRow>
                        <FormRow
                            label="First name"
                            variant="wide"
                        >
                            <div class="text-muted-foreground">{{ attendee.first_name }}</div>
                        </FormRow>
                        <FormRow
                            label="Last name"
                            variant="wide"
                        >
                            <div class="text-muted-foreground">{{ attendee.last_name }}</div>
                        </FormRow>
                        <FormRow
                            label="Registration Date"
                            variant="wide"
                        >
                            <div class="text-muted-foreground">{{ moment(attendee.created_at).format('LLL') }}</div>
                        </FormRow>
                        <FormRow
                            label="Update Date"
                            variant="wide"
                        >
                            <div class="text-muted-foreground">{{ moment(attendee.updated_at).format('LLL') }}</div>
                        </FormRow>
                        <FormRow
                            label="Roles"
                            variant="wide"
                        >
                            <div class="flex gap-2">
                                <Badge>Attendee</Badge>
                                <Badge v-if="attendee.role === 'organizer'">Event organizer</Badge>
                                <Badge
                                    v-if="attendee.user?.is_admin"
                                    variant="secondary"
                                    >Admin</Badge
                                >
                                <Badge
                                    v-if="attendee.user?.is_event_creator"
                                    variant="secondary"
                                    >Can create events</Badge
                                >
                            </div>
                        </FormRow>
                    </CardContent>
                    <CardFooter class="flex justify-end gap-2">
                        <Button
                            variant="secondary"
                            as-child
                            v-if="attendee.role !== 'organizer'"
                        >
                            <Link :href="route('events.admin.attendees.organizer.make', { eventId: event.id, attendeeId: attendee.id })">
                                <i class="ri-key-line mr-2 text-lg"></i>
                                <span>Make Organizer</span>
                            </Link>
                        </Button>
                        <Button
                            variant="destructive"
                            as-child
                            v-if="attendee.role === 'organizer' && currentAttendee.id !== attendee.id"
                        >
                            <Link :href="route('events.admin.attendees.organizer.remove', { eventId: event.id, attendeeId: attendee.id })">
                                <i class="ri-key-line mr-2 text-lg"></i>
                                <span>Remove as Organizer</span>
                            </Link>
                        </Button>
                        <Button
                            variant="secondary"
                            as-child
                        >
                            <Link :href="route('events.attendees.detail', { eventId: event.id, attendeeId: attendee.id })">
                                <i class="ri-arrow-right-up-line mr-2 text-lg"></i>
                                <span>Go to profile</span>
                            </Link>
                        </Button>
                    </CardFooter>
                </Card>

                <div class="flex flex-col gap-4 md:grid md:grid-cols-2">
                    <Card>
                        <CardHeader>
                            <CardTitle>Confirmation Status</CardTitle>
                        </CardHeader>
                        <CardContent class="grow">
                            <div
                                class="text-green-400"
                                v-if="attendee.confirmed"
                            >
                                This attendee is confirmed.
                            </div>
                            <div
                                class="text-red-400"
                                v-else
                            >
                                This attendee is not confirmed.
                            </div>

                            <div class="mt-2 flex flex-wrap items-center gap-2">
                                <span class="text-muted-foreground">Confirmation Key:</span>
                                <Badge
                                    variant="secondary"
                                    v-if="event.confirmation_personalized"
                                    >{{ attendee.confirmation_key }}</Badge
                                >
                                <Badge
                                    variant="secondary"
                                    v-else
                                    >{{ event.confirmation_key || 'n/a' }}</Badge
                                >
                            </div>
                        </CardContent>
                        <CardFooter class="justify-end">
                            <Button
                                v-if="attendee.confirmed"
                                variant="destructive"
                                as-child
                            >
                                <Link
                                    :href="
                                        route('events.admin.attendees.confirmation.revoke', {
                                            eventId: event.id,
                                            attendeeId: attendee.id,
                                        })
                                    "
                                >
                                    <span class="ri-verified-badge-line mr-2 text-lg"></span>
                                    <span>Revoke confirmation</span>
                                </Link>
                            </Button>
                            <Button
                                v-else
                                variant="secondary"
                                as-child
                            >
                                <Link
                                    :href="
                                        route('events.admin.attendees.confirmation.confirm', {
                                            eventId: event.id,
                                            attendeeId: attendee.id,
                                        })
                                    "
                                >
                                    <span class="ri-verified-badge-line mr-2 text-lg"></span>
                                    <span>Confirm</span>
                                </Link>
                            </Button>
                        </CardFooter>
                    </Card>

                    <Card>
                        <CardHeader>
                            <CardTitle>Danger Zone</CardTitle>
                        </CardHeader>
                        <CardContent class="grow text-muted-foreground"> Removing an attendee will remove all messages, any profile data, all connections with other attendees and all room slot claims. This action cannot be reverted. </CardContent>
                        <CardFooter class="justify-end">
                            <Button
                                variant="destructive"
                                as-child
                            >
                                <Link
                                    :href="
                                        route('index', {
                                            eventId: event.id,
                                            attendeeId: attendee.id,
                                        })
                                    "
                                    method="post"
                                    as="button"
                                    type="button"
                                    disabled
                                >
                                    <span class="ri-delete-bin-line mr-2 text-lg"></span>
                                    <span>Remove</span>
                                </Link>
                            </Button>
                        </CardFooter>
                    </Card>
                </div>
            </div>
        </DialogScrollContent>
    </Dialog>
</template>
<script setup lang="ts">
import FormRow from '@/components/Common/FormRow.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Dialog, DialogDescription, DialogHeader, DialogScrollContent, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Attendee } from '@/types/models/Attendee';
import { Event } from '@/types/models/Event';
import { Link, usePage } from '@inertiajs/vue3';
import moment from 'moment';
import { PropType, computed } from 'vue';

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
    attendee: {
        type: Object as PropType<Attendee>,
        required: true,
    },
});
</script>

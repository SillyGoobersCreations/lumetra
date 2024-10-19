<template>
    <Dialog v-model:open="dialogOpen">
        <DialogTrigger as-child>
            <slot />
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Update {{ room.name }}</DialogTitle>
            </DialogHeader>
            <div class="mb-4 flex flex-col gap-4">
                <FormRow
                    label="Name"
                    :error="form.errors.name"
                >
                    <Input
                        placeholder="eg. Room #1 - Table #2"
                        v-model="form.name"
                    />
                </FormRow>
                <FormRow
                    label="Location"
                    :error="form.errors.location"
                >
                    <Input
                        placeholder="eg. Meetup Room"
                        v-model="form.location"
                    />
                </FormRow>
                <FormRow
                    label="Notes"
                    :error="form.errors.notes"
                >
                    <Input
                        placeholder="eg. Space for 2 people"
                        v-model="form.notes"
                    />
                </FormRow>
                <FormRow
                    label="Available"
                    :error="form.errors.available"
                >
                    <Switch
                        :checked="form.available"
                        @update:checked="
                            (val) => {
                                form.available = val;
                            }
                        "
                    />
                </FormRow>
            </div>

            <Card>
                <CardHeader>
                    <CardTitle>Danger Zone</CardTitle>
                    <CardDescription>Deleting this room will also remove all slots and slot claims.</CardDescription>
                </CardHeader>
                <CardFooter>
                    <Button
                        as-child
                        variant="destructive"
                    >
                        <Link
                            :href="
                                route('events.admin.rooms.delete', {
                                    eventId: event.id,
                                    roomId: room.id,
                                })
                            "
                        >
                            <span>Delete</span>
                        </Link>
                    </Button>
                </CardFooter>
            </Card>
            <DialogFooter>
                <Button @click="sendForm">
                    <span>Update</span>
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

<script setup lang="ts">
import FormRow from '@/components/Common/FormRow.vue';
import { Button } from '@/components/ui/button';
import { Card, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Dialog, DialogContent, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Switch } from '@/components/ui/switch';
import { toast } from '@/components/ui/toast';
import { Event } from '@/types/models/Event';
import { EventRoom } from '@/types/models/EventRoom';
import { Link, useForm } from '@inertiajs/vue3';
import { PropType, ref } from 'vue';

const dialogOpen = ref(false);

const props = defineProps({
    event: {
        type: Object as PropType<Event>,
        required: true,
    },
    room: {
        type: Object as PropType<EventRoom>,
        required: true,
    },
});

const form = useForm({
    name: props.room?.name,
    location: props.room?.location,
    notes: props.room?.notes,
    available: props.room?.available,
});

function sendForm() {
    form.post(
        route('events.admin.rooms.update', {
            eventId: props.event.id,
            roomId: props.room.id,
        }),
        {
            onSuccess: () => {
                dialogOpen.value = false;

                toast({
                    title: 'Successfully saved.',
                });
                form.reset();
            },
            onError: () => {
                toast({
                    title: 'Could not save.',
                    description: 'Please try again later.',
                    variant: 'destructive',
                });
            },
        },
    );
}
</script>

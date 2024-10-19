<template>
    <Dialog v-model:open="dialogOpen">
        <DialogTrigger as-child>
            <slot />
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Create slot for {{ room.name }}</DialogTitle>
            </DialogHeader>
            <div class="mb-2 flex flex-col gap-4">
                <FormRow
                    label="Start Time"
                    :error="false"
                >
                    <div class="flex items-center gap-2">
                        <Input
                            type="number"
                            placeholder="08"
                            v-model="form.start_hour"
                        />
                        <span>:</span>
                        <Input
                            type="number"
                            placeholder="00"
                            v-model="form.start_minute"
                        />
                    </div>
                </FormRow>
                <FormRow
                    label="End Time"
                    :error="false"
                >
                    <div class="flex items-center gap-2">
                        <Input
                            type="number"
                            placeholder="16"
                            v-model="form.end_hour"
                        />
                        <span>:</span>
                        <Input
                            type="number"
                            placeholder="00"
                            v-model="form.end_minute"
                        />
                    </div>
                </FormRow>
                <FormRow
                    label="Notes"
                    :error="form.errors.notes"
                >
                    <Textarea v-model="form.notes" />
                </FormRow>
                <FormRow
                    label="State"
                    :error="form.errors.state"
                >
                    <Select v-model="form.state">
                        <SelectTrigger>
                            <SelectValue placeholder="Select a state" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="open">Available</SelectItem>
                            <SelectItem value="reserved">Reserved</SelectItem>
                            <SelectItem value="unavailable">Unavailable</SelectItem>
                        </SelectContent>
                    </Select>
                </FormRow>
                <!-- TODO: Notes Field, State Select -->
            </div>
            <DialogFooter>
                <Button @click="sendForm">
                    <span>Create</span>
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

<script setup lang="ts">
import FormRow from '@/components/Common/FormRow.vue';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import { toast } from '@/components/ui/toast';
import { Event } from '@/types/models/Event';
import { EventRoom } from '@/types/models/EventRoom';
import { useForm } from '@inertiajs/vue3';
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
    start_hour: 10,
    start_minute: 0,
    end_hour: 10,
    end_minute: 45,
    notes: '',
    state: '',
});

function sendForm() {
    form.post(
        route('events.admin.rooms.slots.create', {
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

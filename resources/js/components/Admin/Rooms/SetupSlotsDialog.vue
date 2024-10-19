<template>
    <Dialog v-model:open="dialogOpen">
        <DialogTrigger as-child>
            <slot />
        </DialogTrigger>
        <DialogContent class="max-w-4xl">
            <DialogHeader>
                <DialogTitle>Set up slots for {{ room.name }}</DialogTitle>
            </DialogHeader>
            <div class="mb-2 grid grid-cols-2 gap-4">
                <Card>
                    <CardContent class="p-6">
                        <div class="flex flex-col gap-4">
                            <FormRow
                                label="Start Time"
                                :error="false"
                            >
                                <div class="flex items-center gap-2">
                                    <Input
                                        type="number"
                                        placeholder="08"
                                        v-model="form.start_hour"
                                        @input="generatePreviewSlots"
                                    />
                                    <span>:</span>
                                    <Input
                                        type="number"
                                        placeholder="00"
                                        v-model="form.start_minute"
                                        @input="generatePreviewSlots"
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
                                        @input="generatePreviewSlots"
                                    />
                                    <span>:</span>
                                    <Input
                                        type="number"
                                        placeholder="00"
                                        v-model="form.end_minute"
                                        @input="generatePreviewSlots"
                                    />
                                </div>
                            </FormRow>
                            <FormRow
                                label="Slot Duration (in minutes)"
                                :error="false"
                            >
                                <Input
                                    type="number"
                                    placeholder="30"
                                    v-model="form.duration"
                                    @input="generatePreviewSlots"
                                />
                            </FormRow>
                            <FormRow
                                label="Time Between Available Slots (in minutes)"
                                :error="false"
                            >
                                <Input
                                    type="number"
                                    placeholder="5"
                                    v-model="form.time_between_slots"
                                    @input="generatePreviewSlots"
                                />
                            </FormRow>
                        </div>
                    </CardContent>
                </Card>
                <Card>
                    <CardContent class="max-h-[50vh] overflow-y-auto p-4">
                        <div class="flex flex-col">
                            <template
                                v-for="(slot, n) in slotsPreview"
                                :key="slot"
                            >
                                <div class="flex flex-col gap-1 rounded-md bg-accent p-2">
                                    <div class="flex gap-1 text-xs">
                                        <span class="font-bold">{{ String(slot.start_hour).padStart(2, '0') }}:{{ String(slot.start_minute).padStart(2, '0') }}</span>
                                        <span>-</span>
                                        <span class="text-muted-foreground">{{ String(slot.end_hour).padStart(2, '0') }}:{{ String(slot.end_minute).padStart(2, '0') }}</span>
                                    </div>
                                    <div class="">Available</div>
                                </div>
                                <div
                                    v-if="n < slotsPreview.length - 1"
                                    class="py-1 text-center text-xs text-muted-foreground"
                                >
                                    {{ form.time_between_slots }} minute break
                                </div>
                            </template>
                        </div>
                    </CardContent>
                </Card>
            </div>
            <DialogFooter>
                <Button @click="sendForm">
                    <span>Set up</span>
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

<script setup lang="ts">
import FormRow from '@/components/Common/FormRow.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Dialog, DialogContent, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { toast } from '@/components/ui/toast';
import { Event } from '@/types/models/Event';
import { EventRoom } from '@/types/models/EventRoom';
import { useForm } from '@inertiajs/vue3';
import { PropType, onMounted, ref } from 'vue';

const dialogOpen = ref(false);

const props = defineProps({
    date: {
        type: String,
        required: true,
    },
    event: {
        type: Object as PropType<Event>,
        required: true,
    },
    room: {
        type: Object as PropType<EventRoom>,
        required: true,
    },
});

interface SlotPreview {
    start_hour: Number;
    start_minute: Number;
    end_hour: Number;
    end_minute: Number;
}
const slotsPreview = ref<SlotPreview[]>([]);

const form = useForm({
    date: props.date,
    start_hour: 8,
    start_minute: 0,
    end_hour: 16,
    end_minute: 0,
    duration: 30,
    time_between_slots: 15,
});

onMounted(() => {
    generatePreviewSlots();
});

function sendForm() {
    form.post(
        route('events.admin.rooms.slots.setup', {
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

function generatePreviewSlots() {
    const slots = [];

    const startTimeInMinutes = form.start_hour * 60 + form.start_minute;
    const endTimeInMinutes = form.end_hour * 60 + form.end_minute;

    let currentTime = startTimeInMinutes;

    while (currentTime + form.duration <= endTimeInMinutes) {
        const startHours = Math.floor(currentTime / 60);
        const startMinutes = currentTime % 60;

        const slotEndTime = currentTime + form.duration;
        const endHours = Math.floor(slotEndTime / 60);
        const endMinutes = slotEndTime % 60;

        slots.push({
            start_hour: startHours,
            start_minute: startMinutes,
            end_hour: endHours,
            end_minute: endMinutes,
        });

        currentTime += form.duration + form.time_between_slots;
    }

    slotsPreview.value = slots;
}
</script>

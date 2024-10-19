<template>
    <Head :title="room.name" />

    <AdminLayout
        :title="`Room: ${room.name}`"
        :event="event"
    >
        <template #header>
            <Button
                as-child
                variant="secondary"
            >
                <Link :href="route('events.admin.rooms', { eventId: event.id })">
                    <i class="ri-arrow-left-line text-lg md:mr-2"></i>
                    <span class="hidden md:block">Back to overview</span>
                </Link>
            </Button>

            <EditDialog
                :room="room"
                :event="event"
            >
                <Button variant="secondary">
                    <i class="ri-pencil-line text-lg md:mr-2"></i>
                    <span class="hidden md:block">Edit Room</span>
                </Button>
            </EditDialog>
        </template>

        <section class="page-rooms-detail">
            <Card
                v-for="(slots, date) in groupedSlots"
                :key="date"
            >
                <CardHeader>
                    <CardTitle class="flex flex-wrap items-center gap-2">
                        <span>{{ date }}</span>
                        <Badge variant="secondary">{{ slots.length }} Slots</Badge>
                    </CardTitle>
                </CardHeader>
                <CardContent>
                    <template v-if="slots.length === 0">
                        <Card>
                            <CardContent class="flex flex-col items-center gap-1 p-3 py-6">
                                <i class="ri-calendar-close-line mb-2 text-4xl"></i>
                                <h1>No slot setup yet</h1>
                                <p class="text-muted-foreground">You have not set up any room slots yet.</p>
                            </CardContent>
                        </Card>
                    </template>
                    <div
                        class="flex flex-col gap-1"
                        v-else
                    >
                        <template
                            v-for="slot in slots"
                            :key="slot"
                        >
                            <EventRoomSlot
                                :slot="slot"
                                :room="room"
                                :event="event"
                            />
                        </template>
                    </div>
                </CardContent>
                <CardFooter class="flex justify-end gap-2">
                    <SetupSlotsDialog
                        v-if="slots.length === 0"
                        :room="room"
                        :event="event"
                        :date="date"
                    >
                        <Button variant="secondary">Set up slots now</Button>
                    </SetupSlotsDialog>

                    <CreateSlotDialog
                        v-else
                        :room="room"
                        :event="event"
                    >
                        <Button variant="secondary">Create slot</Button>
                    </CreateSlotDialog>
                </CardFooter>
            </Card>
        </section>
    </AdminLayout>
</template>

<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import CreateSlotDialog from '@/components/Admin/Rooms/CreateSlotDialog.vue';
import EditDialog from '@/components/Admin/Rooms/EditDialog.vue';
import EventRoomSlot from '@/components/Admin/Rooms/EventRoomSlot.vue';
import SetupSlotsDialog from '@/components/Admin/Rooms/SetupSlotsDialog.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Event } from '@/types/models/Event';
import { EventRoom } from '@/types/models/EventRoom';
import { Head, Link } from '@inertiajs/vue3';
import { PropType } from 'vue';

defineProps({
    event: {
        type: Object as PropType<Event>,
        required: true,
    },
    room: {
        type: Object as PropType<EventRoom>,
        required: true,
    },
    groupedSlots: {
        type: Object,
        required: true,
    },
});
</script>

<style lang="scss" scoped>
.page-rooms-detail {
    @apply flex flex-col items-center gap-4 p-5;

    & > * {
        @apply w-full max-w-3xl;
    }
}
</style>

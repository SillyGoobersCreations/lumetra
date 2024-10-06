<template>
    <AdminLayout :title="`Room: ${room.name}`" :event="event">
        <template #header>
            <Button
                as-child
                variant="secondary"
            >
                <Link :href="route('events.admin.rooms', {eventId: event.id })">
                    <i class="ri-arrow-left-line text-lg mr-2"></i>
                    <span>Back to overview</span>
                </Link>
            </Button>

            <EditDialog :room="room" :event="event">
                <Button variant="secondary">
                    <i class="ri-pencil-line text-lg"></i>
                    <span>Edit Room</span>
                </Button>
            </EditDialog>
        </template>

        <section class="page-rooms-detail">
            <Card
                v-for="(slots, date) in groupedSlots"
                :key="date"
            >
                <CardHeader>
                    <CardTitle>{{ date }}</CardTitle>
                    <CardDescription class="flex gap-1">
                        <Badge variant="secondary">{{ slots.length }} Slots</Badge>
                        <Badge variant="secondary">{{ slots.length }} Claims</Badge>
                        <Badge variant="default">{{ slots.length }} Pending</Badge>
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <template v-if="slots.length === 0">
                        <Card>
                            <CardContent class="p-3 py-6 flex flex-col gap-1 items-center">
                                <i class="ri-calendar-close-line text-4xl mb-2"></i>
                                <h1>No slot setup yet</h1>
                                <p class="text-muted-foreground">You have not set up any room slots yet.</p>
                            </CardContent>
                        </Card>
                    </template>
                    <div class="flex flex-col gap-1" v-else>
                        <template
                            v-for="slot in slots"
                            :key="slot"
                        >
                            <EventRoomSlot :slot="slot" :room="room" :event="event" />
                        </template>
                    </div>
                </CardContent>
                <CardFooter class="justify-end flex gap-2">
                    <SetupSlotsDialog
                        v-if="slots.length === 0"
                        :room="room"
                        :event="event"
                        :date="date"
                    >
                        <Button variant="secondary">Set up slots now</Button>
                    </SetupSlotsDialog>

                    <CreateSlotDialog v-else :room="room" :event="event">
                        <Button variant="secondary">Create slot</Button>
                    </CreateSlotDialog>
                </CardFooter>
            </Card>
        </section>
    </AdminLayout>
</template>

<script setup lang="ts">
import {PropType} from "@vue/runtime-dom";
import {Event} from "@/types/models/Event";
import {EventRoom} from "@/types/models/EventRoom";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Button} from "@/components/ui/button";
import {Link} from "@inertiajs/vue3";
import EditDialog from "@/components/Admin/Rooms/EditDialog.vue";
import {Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle} from "@/components/ui/card";
import {Badge} from "@/components/ui/badge";
import SetupSlotsDialog from "@/components/Admin/Rooms/SetupSlotsDialog.vue";
import EventRoomSlot from "@/components/Admin/Rooms/EventRoomSlot.vue";
import CreateSlotDialog from "@/components/Admin/Rooms/CreateSlotDialog.vue";

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
    @apply flex flex-col gap-4 p-5 items-center;

    & > * {
        @apply max-w-3xl w-full;
    }
}

@media screen and (max-width: 1400px) {
    .page-rooms-detail {
        @apply grid-cols-1;
    }
}
</style>

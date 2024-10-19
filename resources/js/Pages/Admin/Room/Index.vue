<template>
    <Head title="Rooms" />

    <AdminLayout
        title="Rooms"
        :event="event"
    >
        <template #header>
            <AddDialog :event="event" />
        </template>

        <section class="page-rooms">
            <Card
                class="room-card"
                v-for="room in event.rooms"
                :key="room.id"
            >
                <CardContent class="content">
                    <div class="flex items-start gap-2">
                        <div class="flex grow flex-col gap-1">
                            <h1>{{ room.name }}</h1>
                            <p class="text-muted-foreground">{{ room.location }}</p>
                            <div class="meta">
                                <Badge v-if="room.available">Available</Badge>
                                <Badge
                                    v-else
                                    variant="destructive"
                                    >Not Available</Badge
                                >

                                <Badge variant="outline">{{ room.slots.length }} Slots</Badge>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <TooltipProvider>
                                <Tooltip>
                                    <TooltipTrigger as-child>
                                        <Button
                                            as-child
                                            variant="secondary"
                                            size="icon"
                                        >
                                            <Link :href="route('events.admin.rooms.detail', { eventId: event.id, roomId: room.id })">
                                                <i class="ri-calendar-view text-lg"></i>
                                            </Link>
                                        </Button>
                                    </TooltipTrigger>
                                    <TooltipContent>
                                        <p>View slots</p>
                                    </TooltipContent>
                                </Tooltip>
                            </TooltipProvider>
                            <EditDialog
                                :room="room"
                                :event="event"
                            >
                                <Button
                                    variant="secondary"
                                    size="icon"
                                >
                                    <i class="ri-pencil-line text-lg"></i>
                                </Button>
                            </EditDialog>
                        </div>
                    </div>
                </CardContent>
            </Card>
        </section>
    </AdminLayout>
</template>

<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import AddDialog from '@/components/Admin/Rooms/AddDialog.vue';
import EditDialog from '@/components/Admin/Rooms/EditDialog.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/components/ui/tooltip';
import { Event } from '@/types/models/Event';
import { Head, Link } from '@inertiajs/vue3';
import { PropType } from 'vue';

defineProps({
    event: {
        type: Object as PropType<Event>,
        required: true,
    },
});
</script>

<style lang="scss" scoped>
.page-rooms {
    @apply grid grid-cols-3 gap-4 p-5;

    & .room-card {
        & .content {
            @apply flex flex-col justify-end p-6;

            & h1 {
                @apply text-xl font-bold;
            }
            & .meta {
                @apply mt-2 flex flex-wrap gap-1;
            }
        }
    }
}

@media screen and (max-width: 1400px) {
    .page-rooms {
        @apply grid-cols-2;
    }
}
@media screen and (max-width: 1000px) {
    .page-rooms {
        @apply grid-cols-1;
    }
}
</style>

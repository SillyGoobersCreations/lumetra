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
            {{ room.slots }}
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
import {DialogTrigger} from "@/components/ui/dialog";

defineProps({
    event: {
        type: Object as PropType<Event>,
        required: true,
    },
    room: {
        type: Object as PropType<EventRoom>,
        required: true,
    },
});
</script>

<style lang="scss" scoped>
.page-rooms-detail {
    @apply grid grid-cols-[2fr_2fr] gap-4 p-5;
}

@media screen and (max-width: 1400px) {
    .page-rooms-detail {
        @apply grid-cols-1;
    }
}
</style>

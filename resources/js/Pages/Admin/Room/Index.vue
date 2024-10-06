<template>
    <AdminLayout title="Rooms" :event="event">
        <section class="page-rooms">
            <Card
                class="room-card"
                v-for="room in event.rooms"
            >
                <CardContent class="content">
                    <h1>{{ room.name }}</h1>
                    <p>{{ room.location }}</p>
                    <div class="meta">
                        <Badge v-if="room.available">Available</Badge>
                        <Badge v-else variant="destructive">Not Available</Badge>

                        <Badge variant="outline">0 Slots</Badge>
                    </div>
                </CardContent>
            </Card>
        </section>
    </AdminLayout>
</template>

<script setup lang="ts">
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Card, CardContent, CardHeader, CardTitle} from "@/components/ui/card";
import {PropType} from "@vue/runtime-dom";
import {Event} from "@/types/models/Event";
import {Badge} from "@/components/ui/badge";

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
            @apply p-6 flex flex-col justify-end;

            & h1 {
                @apply text-xl font-bold;
            }
            & .meta {
                @apply mt-2 flex gap-1 flex-wrap;
            }
        }
    }
}
</style>

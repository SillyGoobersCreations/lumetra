<template>
    <Head title="Dashboard" />

    <AdminLayout title="Dashboard" :event="event">
        <section class="page-dashboard">
            <Card>
                <CardHeader>
                    <CardTitle>Welcome!</CardTitle>
                </CardHeader>
                <CardContent class="text-muted-foreground">
                    Welcome to the Lumetra dashboard!
                </CardContent>
            </Card>

            <div class="flex flex-col lg:flex-row gap-4">
                <Card class="grow">
                    <CardHeader class="pb-1">
                        <CardTitle class="text-sm">
                            Attendees
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">
                            {{ event.attendees.length }}
                        </div>
                    </CardContent>
                </Card>
                <Card class="grow">
                    <CardHeader class="pb-1">
                        <CardTitle class="text-sm">
                            Room Slots
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">
                            {{ eventRoomSlotCount }}
                        </div>
                    </CardContent>
                </Card>
                <Card class="grow">
                    <CardHeader class="pb-1">
                        <CardTitle class="text-sm">
                            Remaining Days
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">
                            {{ eventRemainingDays }}
                        </div>
                    </CardContent>
                </Card>
            </div>
        </section>
    </AdminLayout>
</template>

<script setup lang="ts">
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Card, CardContent, CardHeader, CardTitle} from "@/components/ui/card";
import {PropType} from "@vue/runtime-dom";
import {Event} from "@/types/models/Event";
import {Head} from "@inertiajs/vue3";

defineProps({
    event: {
        type: Object as PropType<Event>,
        required: true,
    },
    eventRoomSlotCount: {
        type: Number,
        default: 0,
    },
    eventRemainingDays: {
        type: Number,
        default: 0,
    },
});
</script>

<style lang="scss" scoped>
.page-dashboard {
    @apply flex flex-col gap-4 p-5;
}
</style>

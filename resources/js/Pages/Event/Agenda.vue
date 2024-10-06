<template>
    <EventLayout :event="event">
        <section class="page-event-agenda">
            <div>
                <Card>
                    <CardHeader>
                        <CardTitle>Upcoming</CardTitle>
                        <CardDescription>Events and meetups</CardDescription>
                    </CardHeader>
                    <CardContent>
                        Test
                    </CardContent>
                </Card>
            </div>
            <div>
                <Card
                    v-for="note in event.notes"
                    :key="note.id"
                >
                    <CardHeader>
                        <CardTitle class="flex gap-2 items-center">
                            <span>{{ note.title }}</span>
                            <Badge variant="secondary">{{ moment(note.created_at).fromNow() }}</Badge>
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        {{ note.text }}
                    </CardContent>
                </Card>
            </div>
        </section>
    </EventLayout>
</template>

<script setup lang="ts">
import EventLayout from "@/Layouts/EventLayout.vue";
import {Card, CardContent, CardDescription, CardHeader, CardTitle} from "@/components/ui/card";
import moment from "moment";
import {Badge} from "@/components/ui/badge";

defineProps({
    event: {
        type: Object,
        required: true,
    }
});
</script>

<style lang="scss" scoped>
.page-event-agenda {
    @apply flex flex-col gap-4 lg:grid lg:grid-cols-2;
}
.page-event-agenda > div {
    @apply flex flex-col gap-4;
}
</style>

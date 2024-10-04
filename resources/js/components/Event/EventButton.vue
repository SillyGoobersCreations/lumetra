<template>
    <Card class="card">
        <CardHeader>
            <img v-if="event.logo" class="logo" :src="`/storage/logos/${event.logo}`" :alt="`${event.title} Logo`" />
            <CardTitle>{{ event.title }}</CardTitle>
            <CardDescription>Organized by: {{ event.organizer }}</CardDescription>
        </CardHeader>
        <CardContent class="content">
            <p class="description">{{ event.description }}</p>
        </CardContent>
        <CardFooter>
            <Button class="flex-1" variant="secondary" as-child>
                <Link :href="route('events.detail', { eventId: event.id })">
                    <i class="ri-arrow-right-up-line mr-2 text-lg"></i>
                    <span>Go to event</span>
                </Link>
            </Button>
        </CardFooter>
    </Card>
</template>

<script setup lang="ts">
import {Link} from "@inertiajs/vue3";
import {Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle} from "@/components/ui/card";
import {Button} from "@/components/ui/button";

defineProps({
    event: {
        type: Object,
        required: true,
    }
});
</script>

<style lang="scss" scoped>
.logo {
    @apply max-h-[150px] max-w-[80%] m-auto mb-6;
}
.content {
    @apply flex-grow;
}
</style>

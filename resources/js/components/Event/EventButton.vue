<template>
    <Card class="card">
        <CardHeader>
            <img
                v-if="event.logo"
                class="logo"
                :src="`/storage/logos/${event.logo}`"
                :alt="`${event.title} Logo`"
            />
            <CardTitle>{{ event.title }}</CardTitle>
            <CardDescription>Organized by: {{ event.organizer }}</CardDescription>
        </CardHeader>
        <CardContent class="content">
            <p class="description">{{ event.description }}</p>
        </CardContent>
        <CardFooter>
            <Button
                class="flex-1"
                variant="secondary"
                as-child
            >
                <Link :href="route('events.detail', { eventId: event.id })">
                    <i class="ri-arrow-right-up-line mr-2 text-lg"></i>
                    <span>Go to event</span>
                </Link>
            </Button>
        </CardFooter>
    </Card>
</template>

<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Link } from '@inertiajs/vue3';

defineProps({
    event: {
        type: Object,
        required: true,
    },
});
</script>

<style lang="scss" scoped>
.logo {
    @apply m-auto mb-6 max-h-[150px] max-w-[80%];
}
.content {
    @apply flex-grow;
}
</style>

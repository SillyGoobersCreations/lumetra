<template>
    <Head title="Events" />

    <DefaultLayout>
        <div class="events-grid">
            <EventButton
                :key="event.id"
                v-for="event in events"
                :event="event"
            />
        </div>
    </DefaultLayout>
</template>

<script setup lang="ts">
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import EventButton from '@/components/Event/EventButton.vue';
import { Event } from '@/types/models/Event';
import { Head } from '@inertiajs/vue3';
import { PropType } from 'vue';

defineProps({
    events: {
        type: Array as PropType<Event[]>,
        default: () => [],
    },
});
</script>

<style lang="scss" scoped>
.events-grid {
    @apply flex flex-col gap-4 md:grid md:grid-cols-2;
}
</style>

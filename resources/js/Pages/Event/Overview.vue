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
import {Head} from "@inertiajs/vue3";
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import EventButton from "@/components/Event/EventButton.vue";
import {PropType} from "@vue/runtime-dom";
import {Event} from "@/types/models/Event";

defineProps({
    events: {
        type: Array as PropType<Event[]>,
        default: () => [],
    }
});
</script>

<style lang="scss" scoped>
.events-grid {
    @apply flex flex-col md:grid md:grid-cols-2 gap-4;
}
</style>

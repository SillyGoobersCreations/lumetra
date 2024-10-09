<template>
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
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
}
</style>

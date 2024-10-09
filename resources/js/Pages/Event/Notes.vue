<template>
    <EventLayout :event="event">
        <h2>Event Notes</h2>
    </EventLayout>
</template>

<script setup lang="ts">
import EventLayout from "@/Layouts/EventLayout.vue";
import {PropType} from "@vue/runtime-dom";
import {Event} from "@/types/models/Event";

defineProps({
    event: {
        type: Object as PropType<Event>,
        required: true,
    }
});
</script>

<style lang="scss" scoped>
</style>

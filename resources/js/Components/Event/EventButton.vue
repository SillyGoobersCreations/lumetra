<template>
    <Box
        class="event-button"
    >
        <div class="logo">
            <img v-if="event.logo" :src="event.logo" :alt="`${event.title} Logo`" />
        </div>
        <h2>{{ event.title }}</h2>
        <p>{{ event.description }}</p>
        <div class="organizer">Organized by: {{ event.organizer }}</div>

        <Link :href="route('events.detail', { eventId: event.id })" class="button">
            <i class="ri-arrow-right-up-line"></i>
            <span>Go to event</span>
        </Link>
    </Box>
</template>

<script setup lang="ts">
import Box from "@/Components/Common/Box.vue";
import {Link} from "@inertiajs/vue3";

defineProps({
    event: {
        type: Object,
        required: true,
    }
});
</script>

<style lang="scss" scoped>
.event-button {
    & .logo {
        background: rgb(var(--color-base-200));
        border-radius: 10px;
        margin-bottom: 25px;
        height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;

        & img {
            max-width: 80%;
            max-height: 80%;
        }
    }
    & h2 {
        font-size: 1.25rem;
        margin-bottom: 10px;
    }
    & p {
        margin-bottom: 25px;
        line-height: 1.5rem;
        flex-grow: 1;
    }
    & .organizer {
        font-size: 0.75rem;
        color: rgb(var(--color-base-400));
        margin-bottom: 15px;
    }
    & a {
        //align-self: flex-end;
        justify-content: center;
    }
}
</style>

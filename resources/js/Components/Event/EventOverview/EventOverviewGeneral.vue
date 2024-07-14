<template>
    <Box padding="l" class="general">
        <h1>{{ event.title }}</h1>
        <p>{{ event.description }}</p>
        <div class="organizer">Organized by: {{ event.organizer }}</div>
    </Box>
</template>

<script setup lang="ts">
import Box from "@/Components/Common/Box.vue";

defineProps({
    event: {
        type: Object,
        required: true,
    }
});
</script>

<style lang="scss" scoped>
.general {
    display: flex;
    flex-direction: column;
    gap: 10px;

    & h1{
        font-size: 1.5rem;
    }
    & p {
        margin-bottom: 15px;
        line-height: 1.5rem;
        flex-grow: 1;
    }
    & .organizer {
        font-size: 0.75rem;
        color: rgb(var(--color-base-400));
    }
}
</style>

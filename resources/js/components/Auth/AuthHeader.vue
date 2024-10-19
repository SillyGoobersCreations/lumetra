<template>
    <header>
        <h1>{{ title }}</h1>
        <p v-if="subtitle">{{ subtitle }}</p>
    </header>
</template>

<script lang="ts" setup>
defineProps({
    title: {
        type: String,
        required: true,
    },
    subtitle: {
        type: [String, Boolean],
        default: false,
    },
});
</script>

<style lang="scss" scoped>
header {
    @apply mb-6 flex flex-col space-y-1 text-center;

    & h1 {
        @apply text-xl font-semibold tracking-tight;
    }
    & p {
        @apply text-sm text-muted-foreground;
    }
}
</style>

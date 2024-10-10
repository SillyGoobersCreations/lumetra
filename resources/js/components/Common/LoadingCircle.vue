<template>
    <div class="loading-circle"></div>
</template>

<style lang="scss" scoped>
.loading-circle {
    @apply w-8 h-8 rounded-full border-4 border-l-accent-foreground;
    animation: loadingLoop 0.5s linear infinite;
}
@keyframes loadingLoop {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}
</style>

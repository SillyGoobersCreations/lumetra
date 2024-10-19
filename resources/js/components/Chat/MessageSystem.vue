<template>
    <div class="message-system">
        <slot />
    </div>
</template>

<style lang="scss" scoped>
.message-system {
    @apply w-full p-2 text-center text-xs text-muted-foreground;
}
</style>

<template>
    <div class="message-system">
        <slot />
    </div>
</template>

<style lang="scss" scoped>
.message-system {
    text-align: center;
    width: 100%;
    padding: 10px 20px;
    color: rgb(var(--color-base-400));
    font-size: 0.75rem;
}
</style>

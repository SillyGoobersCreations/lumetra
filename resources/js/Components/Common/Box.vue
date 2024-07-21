<template>
    <div :class="`box ${!noPadding ? 'padding' : ''}`">
        <slot />
    </div>
</template>

<script setup lang="ts">
defineProps({
    noPadding: {
        type: Boolean,
        default: false,
    },
});
</script>

<style lang="scss" scoped>
    .box {
        background: rgb(var(--color-base-50));
        border-radius: 10px;
        display: flex;
        flex-direction: column;

        &.padding { padding: 20px; }
    }
</style>

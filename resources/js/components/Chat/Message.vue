<template>
    <div :class="`message ${isRemote ? 'remote' : 'local'}`">
        <div class="text">
            <slot />
        </div>
        <div class="actions" v-if="$slots.actions">
            <slot name="actions" />
        </div>
    </div>
</template>

<script setup lang="ts">
defineProps({
    isRemote: {
        type: Boolean,
        default: false,
    },
});
</script>

<style lang="scss" scoped>
.message {
    @apply rounded-xl min-w-[60%] max-w-[90%] flex flex-col gap-4 p-4 break-all;

    &.remote {
        @apply border self-start rounded-bl-none;
    }
    &.local {
        @apply bg-muted self-end rounded-br-none;
    }
    & .actions {
        @apply flex gap-2;
    }
}
</style>

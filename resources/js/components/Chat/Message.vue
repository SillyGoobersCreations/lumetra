<template>
    <div :class="`message ${isRemote ? 'remote' : 'local'}`">
        <div class="text">
            <slot />
        </div>
        <div
            class="actions"
            v-if="$slots.actions"
        >
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
    @apply flex min-w-[60%] max-w-[90%] flex-col gap-4 break-all rounded-xl p-4;

    &.remote {
        @apply self-start rounded-bl-none border;
    }
    &.local {
        @apply self-end rounded-br-none bg-muted;
    }
    & .actions {
        @apply flex gap-2;
    }
}
</style>

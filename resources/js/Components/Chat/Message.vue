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
    border-radius: 10px;
    min-width: 60%;
    max-width: 90%;
    display: flex;
    flex-direction: column;
    gap: 15px;
    padding: 15px;

    &.remote {
        background: rgb(var(--color-base-200));
        color: rgb(var(--color-base-950));
        align-self: flex-start;
        border-bottom-left-radius: 0;
    }
    &.local {
        background: rgb(var(--color-primary-200));
        color: rgb(var(--color-primary-950));
        align-self: flex-end;
        border-bottom-right-radius: 0;
    }

    & .text {
        line-height: 1.5rem;
    }
    & .actions {
        display: flex;
        gap: 5px;
    }
}
</style>

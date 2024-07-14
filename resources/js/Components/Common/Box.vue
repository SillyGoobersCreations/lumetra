<template>
    <div :class="`box padding-${padding}`">
        <slot />
    </div>
</template>

<script setup lang="ts">
enum PaddingValue { none, xs, s, m, l, xl }

defineProps({
    padding: {
        type: [PaddingValue, String, Number],
        default: PaddingValue.none,
    },
});
</script>

<style lang="scss" scoped>
    .box {
        background: rgb(var(--color-base-50));
        border-radius: 10px;
        display: flex;
        flex-direction: column;

        &.padding-none { padding: 0; }
        &.padding-xs { padding: 5px; }
        &.padding-s { padding: 10px; }
        &.padding-m { padding: 20px; }
        &.padding-l { padding: 25px; }
        &.padding-xl { padding: 50px; }
    }
</style>

<template>
    <Link :href="href" :class="`item ${active ? 'active' : ''}`">
        <i v-if="icon" :class="`ri-${icon}-line`"></i>
        <span v-if="label">{{ label }}</span>
    </Link>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps({
    href: {
        type: [String, Object],
        default: "/",
    },
    active: {
        type: Boolean,
        default: false,
    },
    icon: {
        type: [String, Boolean],
        default: false,
    },
    label: {
        type: [String, Boolean],
        default: false,
    },
});
</script>

<style lang="scss" scoped>
.item {
    display: flex;
    align-items: center;
    gap: 3px;
    text-decoration: none;
    color: rgb(var(--color-base-900));
    padding: 0 13px 0 10px;
    height: 40px;
    border-radius: 100px;
    transition: var(--transition-default);

    &:not(:has(i)) span {
        margin-left: 3px;
    }

    & i {
        width: 28px;
        height: 28px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 22px;
    }
    & span {
        font-weight: 600;
    }

    &:hover {
        background: rgb(var(--color-base-50));
    }
    &.active {
        background: rgb(var(--color-primary-700));
        color: rgb(var(--color-primary-50));
    }
}
</style>

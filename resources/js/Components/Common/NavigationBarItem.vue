<template>
    <Link :href="href" :class="`button ${active ? 'primary' : ''}`">
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
</style>

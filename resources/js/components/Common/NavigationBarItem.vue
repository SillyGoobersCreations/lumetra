<template>
    <Button
        :variant="`${active ? 'default' : 'ghost'}`"
        :size="label != false ? 'default' : 'icon'"
        class="justify-center"
        as-child
    >
        <Link :href="href">
            <i v-if="icon" :class="`ri-${icon}-line ${label ? 'mr-2' : ''} text-lg`"></i>
            <span v-if="label" class="label">{{ label }}</span>
        </Link>
    </Button>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {Button} from "@/components/ui/button";

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
.navigation-bar-item {
    @apply justify-start;
}
</style>

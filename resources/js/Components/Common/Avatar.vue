<template>
    <div :style="`width: ${size}px; height: ${size}px;`" class="avatar" v-if="attendee.avatar_url"></div>
    <div :style="`width: ${size}px; height: ${size}px; font-size: ${size * 0.4}px`" class="avatar fallback" v-else>{{ attendee.name_initials }}</div>
</template>

<script setup lang="ts">

import {Attendee} from "@/types/models/Attendee";
import {PropType} from "@vue/runtime-dom";

const props = defineProps({
    attendee: {
        type: Object as PropType<Attendee>,
        required: true,
    },
    size: {
        type: Number,
        default: 35,
    }
});
</script>

<style lang="scss" scoped>
.avatar {
    background: rgb(var(--color-base-200));
    background-position: center;
    background-size: cover;
    border-radius: 100px;

    &.fallback {
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        background: rgb(var(--color-primary-500));
        color: rgb(var(--color-primary-100));
    }
}
</style>

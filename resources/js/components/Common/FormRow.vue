<template>
    <div
        :class="`form-item `+ cn(buttonVariants({ variant }))"
    >
        <Label>{{ label }}</Label>
        <slot />
        <div class="error" v-if="error">{{ error }}</div>
    </div>
</template>

<script lang="ts" setup>
import {Label} from "@/components/ui/label";
import {cva} from "class-variance-authority";
import { cn } from '@/lib/utils';
import {Primitive} from "radix-vue";
import {PropType} from "@vue/runtime-dom";

defineProps({
    label: {
        type: String,
        required: true,
    },
    error: {
        type: [String, Boolean],
        default: false,
    },
    variant: {
        type: String as PropType<'default' | 'wide'>,
        default: "default",
    }
});

const buttonVariants = cva(
    'w-full gap-1.5',
    {
        variants: {
            variant: {
                default: 'flex flex-col',
                wide: 'grid grid-cols-[1fr_2fr] items-center',
            },
        },
        defaultVariants: {
            variant: 'default',
        },
    },
);
</script>

<style lang="scss" scoped>
.form-item {
    & .error {
        @apply text-sm text-red-400;
    }
}
</style>

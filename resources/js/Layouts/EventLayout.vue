<template>
    <EventNavigationBar :event="event" :style="eventStyles" />

    <Wrapper>
        <main :style="eventStyles">
            <slot />
        </main>
    </Wrapper>

    <Snackbars />
</template>

<script setup lang="ts">
import EventNavigationBar from "@/Components/Event/EventNavigationBar.vue";
import Wrapper from "@/Components/Common/Wrapper.vue";
import {computed} from "vue";
import Snackbars from "@/Components/Common/Snackbars.vue";

const props = defineProps({
    event: {
        type: Object,
        required: true,
    }
});

const eventStyles = computed(() => {
    return {
        '--color-primary-50': props.event.swatch[50],
        '--color-primary-100': props.event.swatch[100],
        '--color-primary-200': props.event.swatch[200],
        '--color-primary-300': props.event.swatch[300],
        '--color-primary-400': props.event.swatch[400],
        '--color-primary-500': props.event.swatch[500],
        '--color-primary-600': props.event.swatch[600],
        '--color-primary-700': props.event.swatch[700],
        '--color-primary-800': props.event.swatch[800],
        '--color-primary-900': props.event.swatch[900],
        '--color-primary-950': props.event.swatch[950],
    }
});
</script>

<style lang="scss" scoped>
</style>

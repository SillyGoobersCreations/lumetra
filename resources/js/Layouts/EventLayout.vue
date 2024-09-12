<template>
    <EventNavigationBar :event="event" />

    <Wrapper>
        <main>
            <slot />
        </main>
    </Wrapper>

    <Toaster />
</template>

<script setup lang="ts">
import EventNavigationBar from "@/components/Event/EventNavigationBar.vue";
import Wrapper from "@/components/Common/Wrapper.vue";
import Toaster from '@/components/ui/toast/Toaster.vue';
import {PropType} from "@vue/runtime-dom";
import {Event} from "@/types/models/Event";

const props = defineProps({
    event: {
        type: Object as PropType<Event>,
        required: true,
    },
});
</script>

<style lang="scss" scoped>
main {
    @apply mb-12;
}
</style>

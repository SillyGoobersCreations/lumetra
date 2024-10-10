<template>
    <template
        v-for="stickyNote in event.notes"
        :key="stickyNote.id"
    >
        <div
            v-if="stickyNote.sticky"
            class="bg-red-800 py-1 border-red-950 border-b-[1px]"
        >
            <Wrapper>
                <div class="flex gap-4 flex-wrap items-center">
                    <div class="font-bold text-white">{{ stickyNote.title }}</div>
                    <div class="text-white text-xs">{{ stickyNote.text }}</div>
                </div>
            </Wrapper>
        </div>
    </template>

    <EventNavigationBar :event="event" />

    <Wrapper>
        <main>
            <slot />
        </main>
    </Wrapper>

    <Button variant="secondary" class="fixed bottom-2 right-2" as-child>
        <a href="https://docs.google.com/forms/d/e/1FAIpQLScOxisj-288XQ7Vo5qHEf0CLoFZCe_ijBMIo-tBdy-FiFd91Q/viewform?usp=sf_link" target="_blank">
            <i class="ri-feedback-line text-lg mr-2"></i>
            <span>Feedback</span>
        </a>
    </Button>

    <Toaster />
</template>

<script setup lang="ts">
import EventNavigationBar from "@/components/Event/EventNavigationBar.vue";
import Wrapper from "@/components/Common/Wrapper.vue";
import Toaster from '@/components/ui/toast/Toaster.vue';
import {PropType} from "@vue/runtime-dom";
import {Event} from "@/types/models/Event";
import {Button} from "@/components/ui/button";

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

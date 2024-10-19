<template>
    <template
        v-for="stickyNote in event.notes"
        :key="stickyNote.id"
    >
        <div
            v-if="stickyNote.sticky"
            class="border-b-[1px] border-red-950 bg-red-800 py-1"
        >
            <Wrapper>
                <div class="flex flex-wrap items-center gap-4">
                    <div class="font-bold text-white">{{ stickyNote.title }}</div>
                    <div class="text-xs text-white">{{ stickyNote.text }}</div>
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

    <Button
        variant="secondary"
        class="fixed bottom-2 right-2"
        as-child
    >
        <a
            href="https://docs.google.com/forms/d/e/1FAIpQLScOxisj-288XQ7Vo5qHEf0CLoFZCe_ijBMIo-tBdy-FiFd91Q/viewform?usp=sf_link"
            target="_blank"
        >
            <i class="ri-feedback-line mr-2 text-lg"></i>
            <span>Feedback</span>
        </a>
    </Button>

    <Toaster />
</template>

<script setup lang="ts">
import Wrapper from '@/components/Common/Wrapper.vue';
import EventNavigationBar from '@/components/Event/EventNavigationBar.vue';
import { Button } from '@/components/ui/button';
import Toaster from '@/components/ui/toast/Toaster.vue';
import { Event } from '@/types/models/Event';
import { PropType } from 'vue';

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

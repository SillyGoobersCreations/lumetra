<template>
    <EventNavigationBar :event="event" :userAttendee="userAttendee" />

    <Wrapper>
        <main>
            <slot />
        </main>
    </Wrapper>
</template>

<script setup lang="ts">
import EventNavigationBar from "@/Components/Event/EventNavigationBar.vue";
import Wrapper from "@/Components/Common/Wrapper.vue";

defineProps({
    event: {
        type: Object,
        required: true,
    },
    userAttendee: {
        type: [Object, Boolean],
        default: false,
    }
});
</script>

<style lang="scss" scoped>
</style>

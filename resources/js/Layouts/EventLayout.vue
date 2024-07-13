<template>
    <EventNavigationBar :event="event" />

    <Wrapper>
        <main>
            <slot />
        </main>
    </Wrapper>
</template>

<script setup lang="ts">
import EventNavigationBar from "@/Components/Event/EventNavigationBar.vue";
import Wrapper from "@/Components/Common/Wrapper.vue";
import {computed} from "vue";

defineProps({
    event: {
        type: Object,
        required: true,
    }
});
</script>

<style lang="scss" scoped>
</style>

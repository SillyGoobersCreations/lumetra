<template>
    <EventNavigationBar />
    <main>
        <slot />
    </main>
</template>

<script setup lang="ts">
import EventNavigationBar from "@/Components/Event/EventNavigationBar.vue";
</script>

<style lang="scss" scoped>
</style>

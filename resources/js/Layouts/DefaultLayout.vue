<template>
    <DefaultNavigationBar />

    <Wrapper>
        <main>
            <slot />
        </main>
    </Wrapper>

    <Toaster />
</template>

<script setup lang="ts">
import DefaultNavigationBar from "@/components/Default/DefaultNavigationBar.vue";
import Wrapper from "@/components/Common/Wrapper.vue";
import Toaster from '@/components/ui/toast/Toaster.vue';
</script>

<style lang="scss" scoped>
main {
    @apply flex flex-col mb-12;
}
</style>

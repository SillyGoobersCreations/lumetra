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
import Wrapper from '@/components/Common/Wrapper.vue';
import DefaultNavigationBar from '@/components/Default/DefaultNavigationBar.vue';
import Toaster from '@/components/ui/toast/Toaster.vue';
</script>

<style lang="scss" scoped>
main {
    @apply mb-12 flex flex-col;
}
</style>

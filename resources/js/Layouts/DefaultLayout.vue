<template>
    <DefaultNavigationBar />

    <Wrapper>
        <main>
            <slot />
        </main>
    </Wrapper>
</template>

<script setup lang="ts">
import DefaultNavigationBar from "@/Components/Default/DefaultNavigationBar.vue";
import Wrapper from "@/Components/Common/Wrapper.vue";
</script>

<style lang="scss" scoped>
main {
    display: flex;
    flex-direction: column;
}
</style>

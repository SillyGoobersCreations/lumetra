<template>
    <main class="layout-auth">
        <header>
            <img :src="LumetraLightLogo" alt="Lumetra Logo" class="logo only-light" />
            <img :src="LumetraDarkLogo" alt="Lumetra Logo" class="logo only-dark" />
        </header>
        <Box padding="l">
            <slot />
        </Box>
    </main>
</template>

<script setup lang="ts">
import LumetraLightLogo from "@/../img/lumetra-logo-onlight.svg";
import LumetraDarkLogo from "@/../img/lumetra-logo-ondark.svg";
import Box from "@/Components/Common/Box.vue";
</script>

<style lang="scss">
#app:has(.layout-auth) {
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>

<style lang="scss" scoped>
main {
    display: flex;
    flex-direction: column;
    gap: 20px;
    width: calc(100% - 40px);
    max-width: 450px;

    & header {
        display: flex;

        & .logo {
            height: 30px;
        }
    }
}
</style>

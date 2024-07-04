<template>
    <NavigationBar>
        <template #branding>
            <img :src="LumetraLightLogo" alt="Lumetra Logo" class="logo only-light" />
            <img :src="LumetraDarkLogo" alt="Lumetra Logo" class="logo only-dark" />
        </template>
        <template #main>
            <NavigationBarItem
                href="/"
                icon="dashboard"
                label="Home"
                :active="$page.url === '/'"
            />
            <NavigationBarItem
                href="/events"
                icon="coupon-3"
                label="Events"
                :active="$page.url.startsWith('/events')"
            />
        </template>
        <template #user>
            User
        </template>
    </NavigationBar>
</template>

<script setup lang="ts">
import NavigationBar from "@/Components/Common/NavigationBar.vue";
import LumetraLightLogo from "@/../img/lumetra-logo-onlight.svg";
import LumetraDarkLogo from "@/../img/lumetra-logo-ondark.svg";
import NavigationBarItem from "@/Components/Common/NavigationBarItem.vue";
</script>

<style lang="scss" scoped>
.logo {
    height: 30px;
}
</style>

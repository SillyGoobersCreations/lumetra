<template>
    <NavigationBar>
        <template #branding>
            <img :src="LumetraLightLogo" alt="Lumetra Logo" class="logo only-light" />
            <img :src="LumetraDarkLogo" alt="Lumetra Logo" class="logo only-dark" />
        </template>
        <template #main>
            <NavigationBarItem
                :href="route('index')"
                icon="dashboard"
                label="Home"
                :active="$page.url === '/'"
            />
            <NavigationBarItem
                :href="route('events.index')"
                icon="coupon-3"
                label="Events"
                :active="$page.url.startsWith('/events')"
            />
        </template>
        <template #user v-if="user">
            <NavigationBarItem
                href="/logout"
                icon="door-closed"
                label="Logout"
            />
        </template>
        <template #user v-else>
            <NavigationBarItem
                :href="route('login')"
                label="Login"
            />
            <NavigationBarItem
                :href="route('register')"
                label="Register"
            />
        </template>
    </NavigationBar>
</template>

<script setup lang="ts">
import NavigationBar from "@/Components/Common/NavigationBar.vue";
import LumetraLightLogo from "@/../img/lumetra-logo-onlight.svg";
import LumetraDarkLogo from "@/../img/lumetra-logo-ondark.svg";
import NavigationBarItem from "@/Components/Common/NavigationBarItem.vue";
import {usePage} from "@inertiajs/vue3";
import {computed, ref} from "vue";

const page = usePage();
const user = computed(() => page.props.auth.user);
</script>

<style lang="scss" scoped>
.logo {
    height: 30px;
}
</style>

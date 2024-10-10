<template>
    <NavigationBar>
        <template #branding>
            <img :src="LumetraLightLogo" alt="Lumetra Logo" class="logo dark:hidden block" />
            <img :src="LumetraDarkLogo" alt="Lumetra Logo" class="logo dark:block hidden" />
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
                :href="route('settings.global')"
                icon="settings-2"
                :active="$page.url.startsWith('/settings') && $page.url.includes('settings')"
            />

            <NavigationBarItem
                :href="route('logout')"
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
        <template #user_sidebar v-if="user">
            <div class="flex flex-col gap-2 p-4">
                <NavigationBarItem
                    :href="route('settings.global')"
                    icon="settings-2"
                    label="Settings"
                    :active="$page.url.startsWith('/settings') && $page.url.includes('settings')"
                />

                <NavigationBarItem
                    :href="route('logout')"
                    icon="door-closed"
                    label="Logout"
                />
            </div>
        </template>
        <template #user_sidebar v-else>
            <div class="flex flex-col gap-2 p-4">
                <NavigationBarItem
                    :href="route('login')"
                    label="Login"
                />
                <NavigationBarItem
                    :href="route('register')"
                    label="Register"
                />
            </div>
        </template>
    </NavigationBar>
</template>

<script setup lang="ts">
import NavigationBar from "@/components/Common/NavigationBar.vue";
import LumetraLightLogo from "../../../img/lumetra-logo-onlight.svg";
import LumetraDarkLogo from "../../../img/lumetra-logo-ondark.svg";
import NavigationBarItem from "@/components/Common/NavigationBarItem.vue";
import {usePage} from "@inertiajs/vue3";
import {computed} from "vue";

const page = usePage();
const user = computed(() => page.props.auth.user);
</script>

<style lang="scss" scoped>
.logo {
    @apply h-5;
}
</style>

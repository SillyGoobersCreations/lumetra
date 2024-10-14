<template>
    <section class="layout-auth">
        <aside>
            <div class="top-left">
                <img :src="LumetraLightLogo" alt="Lumetra Logo" class="logo dark:hidden block" />
                <img :src="LumetraDarkLogo" alt="Lumetra Logo" class="logo dark:block hidden" />
            </div>
            <div class="version">
                <span>Version 1.1.0</span>
            </div>
        </aside>
        <main>
            <div class="content">
                <slot />
            </div>
        </main>
    </section>

    <Toaster />
</template>

<script setup lang="ts">
import LumetraLightLogo from "@/../img/lumetra-logo-onlight.svg";
import LumetraDarkLogo from "@/../img/lumetra-logo-ondark.svg";
import Toaster from '@/components/ui/toast/Toaster.vue';
import {onMounted, ref} from "vue";

const isDark = ref<boolean>(false);

onMounted(() => {
    isDark.value = localStorage.getItem("theme") === "dark";
    updateTheme();
});

function updateTheme() {
    let body = document.querySelector("body");

    if(isDark.value) {
        body?.classList.add("dark");
    } else {
        body?.classList.remove("dark");
    }
}
</script>

<style lang="scss" scoped>
.layout-auth {
    @apply container relative min-h-[100vh] flex-col items-center justify-center md:grid lg:max-w-none lg:grid-cols-2 lg:px-0;

    & aside {
        @apply relative hidden h-full flex-col bg-accent p-10 text-white lg:flex;
    }
    & main {
        @apply lg:p-8;

        & .content {
            @apply mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px] py-6 lg:py-0;
        }
    }
    & .top-left {
        @apply relative z-20 flex items-center text-lg font-medium;

        & .logo {
            @apply h-5;
        }
    }
    & .version {
        @apply relative z-20 mt-auto text-muted-foreground;
    }
}
</style>

<template>
    <header :class="`${isFloating ? 'floating' : ''}`">
        <Wrapper>
            <div class="branding">
                <slot name="branding" />
            </div>

            <nav>
                <slot name="main" />
            </nav>

            <aside>
                <slot name="user" />
            </aside>
        </Wrapper>
    </header>
</template>

<script setup>
import Wrapper from "@/Components/Common/Wrapper.vue";
import {onMounted, onUnmounted, ref} from "vue";

const isFloating = ref(false);

function checkIsFloating() {
    isFloating.value = window.scrollY > 0;
}

onMounted(() => {
    checkIsFloating();
    window.addEventListener("scroll", checkIsFloating);
});

onUnmounted(() => {
    window.addEventListener("scroll", checkIsFloating);
})
</script>

<style lang="scss" scoped>
header {
    position: sticky;
    top: 0;
    background: rgb(var(--color-base-200));
    z-index: 100;
    height: 80px;
    display: flex;
    align-items: center;
    transition: var(--transition-default);

    &.floating {
        background: rgb(var(--color-base-50));
        height: 60px;
    }

    & .wrapper {
        display: grid;
        grid-template-columns: auto 1fr auto;
        align-items: center;
        gap: 50px;

        & nav {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            align-items: center;
        }
        & aside {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            align-items: center;
        }
    }
}
</style>

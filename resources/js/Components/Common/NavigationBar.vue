<template>
    <header>
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
</script>

<style lang="scss" scoped>
header {
    height: 60px;
    display: flex;
    align-items: center;

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
    }
}
</style>

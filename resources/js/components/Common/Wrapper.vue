<template>
    <div class="wrapper">
        <slot />
    </div>
</template>

<style lang="scss" scoped>
.wrapper {
    @apply m-auto flex max-w-[1100px] flex-col;
    width: calc(100% - 40px);
}
</style>

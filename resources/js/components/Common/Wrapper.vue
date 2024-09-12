<template>
    <div class="wrapper">
        <slot />
    </div>
</template>

<style lang="scss" scoped>
.wrapper {
    @apply max-w-[1100px] flex flex-col m-auto;
    width: calc(100% - 40px);
}
</style>

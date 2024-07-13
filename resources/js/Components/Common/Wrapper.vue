<template>
    <div class="wrapper">
        <slot />
    </div>
</template>

<style lang="scss" scoped>
.wrapper {
    max-width: 1100px;
    width: calc(100% - 40px);
    margin: 0 auto;
    display: flex;
    flex-direction: column;
}
</style>

<template>
    <div class="loading-circle"></div>
</template>

<style lang="scss" scoped>
.loading-circle {
    width: 48px;
    height: 48px;
    border-radius: 100px;
    border: 5px solid rgb(var(--color-primary-200));
    border-left-color: rgb(var(--color-primary-500));
    animation: loadingLoop 0.5s linear infinite;
}
@keyframes loadingLoop {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}
</style>

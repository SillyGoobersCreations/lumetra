<template>
    <header :class="`${isFloating ? 'floating' : ''}`">
        <Wrapper>
            <div class="branding">
                <Sheet>
                    <SheetTrigger as-child>
                        <Button
                            variant="ghost"
                            class="flex lg:hidden"
                        >
                            <i class="ri-menu-line text-lg"></i>
                        </Button>
                    </SheetTrigger>
                    <SheetContent side="left">
                        <SheetContent class="flex flex-col gap-0 overflow-y-auto p-0">
                            <div class="flex flex-col gap-2 p-4">
                                <ThemeSwitcher />
                                <slot name="main" />
                            </div>
                            <Separator />
                            <slot name="user_sidebar" />
                        </SheetContent>
                    </SheetContent>
                </Sheet>
                <slot name="branding" />
            </div>

            <nav>
                <slot name="main" />
            </nav>

            <aside>
                <slot name="user" />
                <ThemeSwitcher />
            </aside>
        </Wrapper>
    </header>
</template>

<script setup>
import ThemeSwitcher from '@/components/Common/ThemeSwitcher.vue';
import Wrapper from '@/components/Common/Wrapper.vue';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { Sheet, SheetContent, SheetTrigger } from '@/components/ui/sheet';
import { onMounted, onUnmounted, ref } from 'vue';

const isFloating = ref(false);

function checkIsFloating() {
    isFloating.value = window.scrollY > 10;
}

onMounted(() => {
    checkIsFloating();
    window.addEventListener('scroll', checkIsFloating);
});

onUnmounted(() => {
    window.addEventListener('scroll', checkIsFloating);
});
</script>

<style lang="scss" scoped>
header {
    @apply sticky top-0 z-50 flex items-center py-4;

    &.floating {
        @apply bg-background;
    }

    & .wrapper {
        @apply grid items-center gap-12;
        grid-template-columns: auto 1fr auto;

        & .branding {
            @apply flex items-center gap-4;
        }

        & nav,
        & aside {
            @apply hidden items-center gap-2 lg:flex;
        }
    }
}
</style>

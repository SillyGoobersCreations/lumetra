<template>
    <Button
        variant="ghost"
        size="icon"
        @click="toggleTheme"
    >
        <i
            class="ri-sun-line text-lg"
            v-if="isDark"
        ></i>
        <i
            class="ri-moon-line text-lg"
            v-else
        ></i>
    </Button>
</template>

<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { onMounted, ref } from 'vue';

const isDark = ref<boolean>(false);

onMounted(() => {
    isDark.value = localStorage.getItem('theme') === 'dark';
    updateTheme();
});

function toggleTheme() {
    isDark.value = !isDark.value;
    localStorage.setItem('theme', isDark.value ? 'dark' : 'light');
    updateTheme();
}

function updateTheme() {
    let body = document.querySelector('body');

    if (isDark.value) {
        body?.classList.add('dark');
    } else {
        body?.classList.remove('dark');
    }
}
</script>

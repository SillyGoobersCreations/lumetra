<template>
    <DefaultLayout>
        <Card>
            <CardContent class="pt-6">
                Index
            </CardContent>
        </Card>
    </DefaultLayout>
</template>

<script setup lang="ts">
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import {Card, CardContent} from "@/components/ui/card";
</script>

<style lang="scss" scoped>
h2 {
    margin: 100px 0;
    text-align: center;
}
</style>

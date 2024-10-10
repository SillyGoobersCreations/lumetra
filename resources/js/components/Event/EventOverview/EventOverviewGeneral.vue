<template>
    <Card>
        <CardHeader>
            <CardTitle>{{ event.title }}</CardTitle>
            <CardDescription>Organized by: {{ event.organizer }}</CardDescription>
        </CardHeader>
        <CardContent>
            {{ event.description }}
        </CardContent>
    </Card>
</template>

<script setup lang="ts">
import {Card, CardContent, CardDescription, CardHeader, CardTitle} from "@/components/ui/card";

defineProps({
    event: {
        type: Object,
        required: true,
    }
});
</script>

<style lang="scss" scoped>
.general {
    display: flex;
    flex-direction: column;
    gap: 10px;

    & h1{
        font-size: 1.5rem;
    }
    & p {
        margin-bottom: 15px;
        line-height: 1.5rem;
        flex-grow: 1;
    }
    & .organizer {
        font-size: 0.75rem;
        color: rgb(var(--color-base-400));
    }
}
</style>

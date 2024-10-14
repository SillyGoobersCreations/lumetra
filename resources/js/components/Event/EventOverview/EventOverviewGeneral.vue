<template>
    <Card>
        <CardHeader>
            <CardTitle>{{ event.title }}</CardTitle>
            <CardDescription>Organized by: {{ event.organizer }}</CardDescription>
        </CardHeader>
        <CardContent class="flex flex-col gap-2">
            <div>{{ event.description }}</div>
            <div class="flex gap-2 flex-wrap">
                <Button variant="secondary" as-child>
                    <a :href="event.privacy_url" target="_blank">
                        <span>Privacy policy</span>
                    </a>
                </Button>
            </div>
        </CardContent>
    </Card>
</template>

<script setup lang="ts">
import {Card, CardContent, CardDescription, CardHeader, CardTitle} from "@/components/ui/card";
import {Button} from "@/components/ui/button";

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

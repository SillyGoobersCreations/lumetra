<template>
    <Card>
        <CardContent class="flex flex-col gap-4 pt-6">
            <div class="grid grid-cols-[1fr_2fr] items-center gap-2">
                <Label>Start date</Label>
                <p
                    class="text-muted-foreground"
                    v-if="event.start_date"
                >
                    {{ moment(event.start_date).format('D.MM.YYYY') }}
                </p>
                <p
                    class="text-muted-foreground"
                    v-else
                >
                    No date set.
                </p>
            </div>
            <div class="grid grid-cols-[1fr_2fr] items-center gap-2">
                <Label>End date</Label>
                <p
                    class="text-muted-foreground"
                    v-if="event.end_date"
                >
                    {{ moment(event.end_date).format('D.MM.YYYY') }}
                </p>
                <p
                    class="text-muted-foreground"
                    v-else
                >
                    No date set.
                </p>
            </div>
        </CardContent>
    </Card>
</template>
<script setup lang="ts">
import { Card, CardContent } from '@/components/ui/card';
import { Label } from '@/components/ui/label';
import moment from 'moment/moment';

defineProps({
    event: {
        type: Object,
        required: true,
    },
});
</script>

<style lang="scss" scoped>
.properties {
    display: flex;
    flex-direction: column;
    gap: 15px;

    & > div {
        display: flex;
        gap: 15px;
        align-items: center;

        & span:nth-child(1) {
            text-align: right;
        }
        & span:nth-child(2) {
            color: rgb(var(--color-base-400));
        }
    }
}
</style>

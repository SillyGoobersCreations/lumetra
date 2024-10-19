<template>
    <Card class="attendee-button">
        <CardContent class="flex grow flex-col gap-2 pt-6">
            <div class="flex w-full justify-center">
                <Avatar class="h-[128px] w-[128px]">
                    <AvatarImage
                        :src="`/storage/avatars/${attendee.avatar_url}?v=${attendee.updated_at}`"
                        v-if="attendee.avatar_url"
                    />
                    <AvatarFallback class="text-3xl">{{ attendee.name_initials }}</AvatarFallback>
                </Avatar>
            </div>
            <div class="name">{{ attendee.name_full }}</div>
            <div
                class="job-info"
                v-if="attendee.job_position || attendee.job_company"
            >
                <div v-if="attendee.job_position">{{ attendee.job_position }}</div>
                <div v-if="attendee.job_company">{{ attendee.job_company }}</div>
            </div>
        </CardContent>
        <CardFooter>
            <Button
                class="w-full justify-start"
                variant="secondary"
                as-child
            >
                <Link :href="route('events.attendees.detail', { eventId: eventId, attendeeId: attendee.id })">
                    <i class="ri-arrow-right-up-line mr-2 text-lg"></i>
                    <span>Go to profile</span>
                </Link>
            </Button>
        </CardFooter>
    </Card>
</template>

<script setup lang="ts">
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardFooter } from '@/components/ui/card';
import { Attendee } from '@/types/models/Attendee';
import { Link } from '@inertiajs/vue3';
import { PropType } from 'vue';

defineProps({
    attendee: {
        type: Object as PropType<Attendee>,
        default: null,
    },
    eventId: {
        type: String,
        default: '',
    },
});
</script>

<style lang="scss" scoped>
.attendee-button {
    & .name {
        @apply mt-2 line-clamp-1 text-center font-bold;
    }
    & .job-info {
        @apply mt-2 flex flex-col;

        & div {
            @apply line-clamp-1;
        }
        & div:nth-child(2) {
            @apply text-xs text-muted-foreground;
        }
    }
}
/*
.attendee-button {
    background: rgb(var(--color-base-50));
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    gap: 15px;
    padding: 20px;
    overflow: hidden;

    & .avatar {
        margin: 0 auto;
    }
    & .name {
        font-size: 1.15rem;
        text-align: center;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    & .job-info {
        display: flex;
        flex-direction: column;
        gap: 5px;

        & span {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        & span:nth-child(2) {
            color: rgb(var(--color-base-400));
        }
    }
    & .actions {
        flex-grow: 1;
        display: flex;
        align-items: flex-end;
        gap: 5px;

        & button, & .button {
            flex-grow: 1;
        }
    }
} */
</style>

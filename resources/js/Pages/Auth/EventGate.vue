<template>
    <AuthLayout>
        <AuthHeader
            title="Select an event"
        />

        <div class="event-gate">
            <div class="events">
                <Button
                    v-for="attendee in attendees"
                    :key="attendee.id"
                    class="attendee-item"
                    variant="default"
                    as-child
                >
                    <Link
                        :href="route('events.detail', { eventId: attendee.event?.id})"
                        class="button attendee-button"
                    >
                        <Avatar :attendee="attendee" />
                        <div class="meta">
                            <span>{{ attendee.name_full }}</span>
                            <span>{{ attendee.event?.title }}</span>
                        </div>
                    </Link>
                </Button>
            </div>
            <Button variant="secondary" as-child>
                <Link
                    :href="route('index')"
                >
                    <i class="ri-home-5-line mr-2 text-lg"></i>
                    <span>Back to Frontpage</span>
                </Link>
            </Button>
        </div>
    </AuthLayout>
</template>

<script setup lang="ts">
import {Link, usePage} from '@inertiajs/vue3';
import AuthLayout from "@/Layouts/AuthLayout.vue";
import {computed} from "vue";
import Avatar from "@/components/Common/Avatar.vue";
import AuthHeader from "@/components/Auth/AuthHeader.vue";
import {Button} from "@/components/ui/button";

const page = usePage();
const user = computed(() => page.props.auth.user);
const attendees = computed(() => page.props.auth.attendees);
</script>

<style lang="scss" scoped>
.event-gate {
    @apply flex flex-col gap-4;

    & .events {
        @apply flex flex-col gap-2;

        & .attendee-item {
            @apply h-[60px] flex gap-2 justify-start;

            & .meta {
                @apply flex flex-col;

                & span:nth-child(1) {
                    @apply text-lg;
                }
                & span:nth-child(2) {
                    @apply mt-[-5px] text-muted-foreground;
                }
            }
        }
    }
}
</style>

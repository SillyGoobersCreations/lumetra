<template>
    <aside>
        <Button
            :variant="$page.url.endsWith('/settings') ? 'secondary' : 'ghost'"
            class="button"
            as-child
        >
            <Link
                :href="route('settings.global')"
            >
                <span class="ri-settings-2-line mr-2 text-lg"></span>
                <span>General Settings</span>
            </Link>
        </Button>

        <Button
            v-for="attendee in attendees"
            :key="attendee.id"
            :variant="$page.url.includes(attendee.event?.id) ? 'secondary' : 'ghost'"
            class="button"
            as-child
        >
            <Link
                :href="route('settings.event', {eventId: attendee.event?.id})"
            >
                <span class="ri-coupon-3-line mr-2 text-lg"></span>
                <span>{{ attendee.event?.title }}</span>
            </Link>
        </Button>
    </aside>
</template>

<script lang="ts" setup>
import {Link, usePage} from "@inertiajs/vue3";
import {PropType} from "@vue/runtime-dom";
import {Attendee} from "@/types/models/Attendee";
import {Button} from "@/components/ui/button";

defineProps({
    attendees: {
        type: Object as PropType<Attendee[]>,
        default: () => [],
    }
});

const page = usePage();
</script>

<style lang="scss" scoped>
aside {
    @apply flex flex-col gap-1;

    & .button {
        @apply justify-start;
    }
}
</style>

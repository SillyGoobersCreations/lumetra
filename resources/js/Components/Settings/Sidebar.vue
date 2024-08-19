<template>
    <aside>
        <Link
            :href="route('settings.global')"
            :class="`button ${ $page.url.endsWith('/settings') ? 'primary' : 'reverse'}`"
        >
            <span class="ri-settings-2-line"></span>
            <span>General Settings</span>
        </Link>

        <Link
            v-for="attendee in attendees"
            :key="attendee.id"
            :href="route('settings.event', {eventId: attendee.event?.id})"
            :class="`button ${ $page.url.includes(attendee.event?.id) ? 'primary' : 'reverse'}`"
        >
            <span class="ri-coupon-3-line"></span>
            <span>{{ attendee.event?.title }}</span>
        </Link>
    </aside>
</template>

<script lang="ts" setup>
import {Link, usePage} from "@inertiajs/vue3";
import {PropType} from "@vue/runtime-dom";
import {User} from "@/types/models/User";
import {Attendee} from "@/types/models/Attendee";
import NavigationBarItem from "@/Components/Common/NavigationBarItem.vue";

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
    display: flex;
    flex-direction: column;
    gap: 5px;
}
</style>

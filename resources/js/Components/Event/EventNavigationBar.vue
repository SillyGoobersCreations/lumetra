<template>
    <NavigationBar>
        <template #branding>
            {{ event.title }}
        </template>
        <template #main>
            <NavigationBarItem
                :href="route('events.detail', { eventId: event.id })"
                icon="dashboard"
                label="Dashboard"
                :active="$page.url === `/events/${event.id}`"
            />
            <NavigationBarItem
                :href="route('events.detail.agenda', { eventId: event.id })"
                icon="calendar-2"
                label="Agenda"
                :active="$page.url.startsWith('/events') && $page.url.includes('agenda')"
            />
            <NavigationBarItem
                :href="route('events.attendees.index', { eventId: event.id })"
                icon="group-2"
                label="Attendees"
                :active="$page.url.startsWith('/events') && $page.url.includes('attendees')"
            />
            <NavigationBarItem
                :href="route('events.chats.index', { eventId: event.id })"
                icon="chat-1"
                label="Chat"
                :active="$page.url.startsWith('/events') && $page.url.includes('chats')"
            />
        </template>
        <template #user v-if="user">
            <NavigationBarItem
                href="/logout"
                icon="door-closed"
                label="Logout"
            />
        </template>
        <template #user v-else>
            <NavigationBarItem
                href="/login"
                label="Login"
            />
            <NavigationBarItem
                href="/register"
                label="Register"
            />
        </template>
    </NavigationBar>
</template>

<script setup lang="ts">
import NavigationBar from "@/Components/Common/NavigationBar.vue";
import NavigationBarItem from "@/Components/Common/NavigationBarItem.vue";
import {usePage} from "@inertiajs/vue3";
import {computed, ref} from "vue";

defineProps({
    event: {
        type: Object,
        required: true,
    },
    attendee: {
        type: [Object, Boolean],
        default: false,
    }
});

const page = usePage();
const user = computed(() => page.props.auth.user);
</script>

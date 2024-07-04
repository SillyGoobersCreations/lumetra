<template>
    <NavigationBar>
        <template #branding>
            Event
        </template>
        <template #main>
            <NavigationBarItem
                href="/"
                icon="dashboard"
                label="Dashboard"
                :active="$page.url === '/events'"
            />
            <NavigationBarItem
                href="/"
                icon="calendar-2"
                label="Agenda"
                :active="$page.url.startsWith('/events') && $page.url.contains('agenda')"
            />
            <NavigationBarItem
                href="/"
                icon="group-2"
                label="Attendees"
                :active="$page.url.startsWith('/events') && $page.url.contains('attendees')"
            />
            <NavigationBarItem
                href="/"
                icon="chat-1"
                label="Chat"
                :active="$page.url.startsWith('/events') && $page.url.contains('chats')"
            />
        </template>
        <template #user>
            User
        </template>
    </NavigationBar>
</template>

<script setup lang="ts">
import NavigationBar from "@/Components/Common/NavigationBar.vue";
import NavigationBarItem from "@/Components/Common/NavigationBarItem.vue";
</script>

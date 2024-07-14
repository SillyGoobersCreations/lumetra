<template>
    <NavigationBar>
        <template #branding>
            <div v-if="event.logo" class="logo">
                <img :src="event.logo" :alt="`${event.title} logo`" />
            </div>
            <div v-else>
                {{ event.title }}
            </div>
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
            <div class="dropdown">
                <div class="selected" @click="dropdownOpen = !dropdownOpen">
                    <span v-if="currentAttendee.first_name && currentAttendee.last_name">{{ currentAttendee.first_name }} {{ currentAttendee.last_name }}</span>
                    <span v-else>{{ currentAttendee.handle }}</span>
                    <span>{{ currentAttendee.event.title }}</span>
                </div>
                <div :class="`items ${dropdownOpen ? 'active' : ''}`">
                    <Link :href="route('index')" class="item">
                        Frontpage
                    </Link>
                    <Link :href="route('events.detail', { eventId: attendee.event.id })" class="item" v-for="attendee in attendees" :key="attendee.id">
                        <span v-if="attendee.first_name && attendee.last_name">{{ attendee.first_name }} {{ attendee.last_name }}</span>
                        <span v-else>{{ attendee.handle }}</span>
                        <span>{{ attendee.event.title }}</span>
                    </Link>
                </div>
            </div>

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
import { Link } from '@inertiajs/vue3';
import NavigationBar from "@/Components/Common/NavigationBar.vue";
import NavigationBarItem from "@/Components/Common/NavigationBarItem.vue";
import {usePage} from "@inertiajs/vue3";
import {computed, ref} from "vue";

const dropdownOpen = ref(false);

defineProps({
    event: {
        type: Object,
        required: true,
    }
});

const page = usePage();
const user = computed(() => page.props.auth.user);
const attendees = computed(() => page.props.auth.attendees);
const currentAttendee = computed(() => {
    let foundAttendee = null;

    attendees.value.forEach((attendee) => {
        if(attendee.user_id === user.value.id) {
            foundAttendee = attendee;
        }
    })

    return foundAttendee;
});
</script>

<style lang="scss" scoped>
.logo {
    & img {
        max-height: 45px;
    }
}
.dropdown {
    max-width: 250px;
    position: relative;
    z-index: 100;

    & .selected, .item {
        height: 45px;
        display: flex;
        flex-direction: column;
        gap: 3px;
        justify-content: center;
        padding: 0 10px;
        border-radius: 5px;
        color: inherit;
        text-decoration: none;

        & span {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;

            &:nth-child(2) {
                color: rgb(var(--color-base-500));
                font-size: 0.75rem;
            }
        }

        &:hover {
            background: rgb(var(--color-base-200));
            transition: var(--transition-default);
            cursor: pointer;
        }
    }
    & .selected {
        text-align: right;

        &:hover {
            background: rgb(var(--color-base-300));
        }
    }

    & .items {
        max-width: 250px;
        background: rgb(var(--color-base-50));
        box-shadow: 0 2px 16px rgb(var(--color-base-900), 0.4);
        padding: 5px;
        border-radius: 5px;
        position: absolute;
        top: 50px;
        display: none;
        flex-direction: column;
        gap: 5px;

        &.active {
            display: flex;
        }
    }
}
</style>

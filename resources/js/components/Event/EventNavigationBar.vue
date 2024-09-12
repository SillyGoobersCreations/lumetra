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
            <DropdownMenu>
                <DropdownMenuTrigger as-child>
                    <Button variant="ghost" class="relative h-8 w-8 rounded-full">
                        <Avatar class="h-8 w-8">
                            <AvatarImage :src="`/storage/avatars/${currentAttendee.avatar_url}`" alt="@shadcn" />
                            <AvatarFallback>{{ currentAttendee.name_initials }}</AvatarFallback>
                        </Avatar>
                    </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent class="w-56" align="end">
                    <DropdownMenuLabel class="font-normal flex">
                        <div class="flex flex-col space-y-1">
                            <p class="text-sm font-medium leading-none">
                                {{ currentAttendee.name_full }}
                            </p>
                            <p class="text-xs leading-none text-muted-foreground">
                                {{ currentAttendee.handle }}
                            </p>
                        </div>
                    </DropdownMenuLabel>
                    <DropdownMenuSeparator />
                    <DropdownMenuGroup>
                        <DropdownMenuItem as-child>
                            <Link
                                :href="route('events.attendees.detail', { eventId: currentAttendee.event.id, attendeeId: currentAttendee.id })"
                            >
                                <i class="ri-user-line mr-2 text-lg"></i>
                                <span>Profile</span>
                            </Link>
                        </DropdownMenuItem>
                        <DropdownMenuItem as-child>
                            <Link
                                :href="route('settings.event', { eventId: currentAttendee.event.id })"
                            >
                                <i class="ri-settings-2-line mr-2 text-lg"></i>
                                <span>Settings</span>
                            </Link>
                        </DropdownMenuItem>
                        <DropdownMenuItem as-child>
                            <Link
                                :href="route('events.admin', { eventId: currentAttendee.event.id })"
                            >
                                <i class="ri-key-line mr-2 text-lg"></i>
                                <span>Admin</span>
                            </Link>
                        </DropdownMenuItem>
                    </DropdownMenuGroup>
                    <DropdownMenuSeparator />
                    <DropdownMenuGroup>
                        <DropdownMenuItem
                            v-for="attendee in attendees"
                            :key="attendee.id"
                            as-child
                        >
                            <Link :href="route('events.detail', { eventId: attendee?.event?.id ?? 0 })">
                                <Avatar class="h-8 w-8 mr-2">
                                    <AvatarImage :src="`/storage/avatars/${attendee.avatar_url}`" alt="@shadcn" />
                                    <AvatarFallback>{{ attendee.name_initials }}</AvatarFallback>
                                </Avatar>
                                <div class="flex flex-col space-y-1">
                                    <p class="text-sm font-medium leading-none">
                                        {{ attendee.name_full }}
                                    </p>
                                    <p class="text-xs leading-none text-muted-foreground">
                                        {{ attendee.event.title }}
                                    </p>
                                </div>
                            </Link>
                        </DropdownMenuItem>
                    </DropdownMenuGroup>
                    <DropdownMenuSeparator />
                    <DropdownMenuGroup>
                        <DropdownMenuItem as-child>
                            <Link
                                :href="route('index')"
                            >
                                <i class="ri-home-3-line mr-2 text-lg"></i>
                                <span>Frontpage</span>
                            </Link>
                        </DropdownMenuItem>
                        <DropdownMenuItem as-child>
                            <Link
                                :href="route('logout')"
                            >
                                <i class="ri-door-open-line mr-2 text-lg"></i>
                                <span>Logout</span>
                            </Link>
                        </DropdownMenuItem>
                    </DropdownMenuGroup>
                </DropdownMenuContent>
            </DropdownMenu>
        </template>
        <template #user v-else>
            <NavigationBarItem
                :href="route('login')"
                label="Login"
            />
            <NavigationBarItem
                :href="route('register')"
                label="Register"
            />
        </template>
        <template #user_sidebar v-if="user">
            <div class="flex flex-col gap-2 p-4">
                <div class="flex gap-2 mb-2">
                    <Avatar class="h-8 w-8">
                        <AvatarImage :src="`/storage/avatars/${currentAttendee.avatar_url}`" alt="@shadcn" />
                        <AvatarFallback>{{ currentAttendee.name_initials }}</AvatarFallback>
                    </Avatar>
                    <div class="flex flex-col space-y-1">
                        <p class="text-sm font-medium leading-none">
                            {{ currentAttendee.name_full }}
                        </p>
                        <p class="text-xs leading-none text-muted-foreground">
                            {{ currentAttendee.handle }}
                        </p>
                    </div>
                </div>
                <NavigationBarItem
                    :href="route('events.attendees.detail', { eventId: currentAttendee.event.id, attendeeId: currentAttendee.id })"
                    icon="user"
                    label="Profile"
                />
                <NavigationBarItem
                    :href="route('settings.event', { eventId: currentAttendee.event.id })"
                    icon="settings-2"
                    label="Settings"
                />
                <NavigationBarItem
                    :href="route('events.admin', { eventId: currentAttendee.event.id })"
                    icon="key"
                    label="Admin"
                />
                <NavigationBarItem
                    :href="route('logout')"
                    icon="door-open"
                    label="Logout"
                />
            </div>
            <Separator />
            <div class="flex flex-col gap-2 p-4">
                <Label>Profiles</Label>
                <Button
                    v-for="attendee in attendees"
                    :key="attendee.id"
                    variant="ghost"
                    class="justify-start h-14"
                    as-child
                >
                    <Link :href="route('events.detail', { eventId: attendee?.event?.id ?? 0 })">
                        <Avatar class="h-8 w-8 mr-2">
                            <AvatarImage :src="`/storage/avatars/${attendee.avatar_url}`" alt="@shadcn" />
                            <AvatarFallback>{{ attendee.name_initials }}</AvatarFallback>
                        </Avatar>
                        <div class="flex flex-col space-y-1">
                            <p class="text-sm font-medium leading-none">
                                {{ attendee.name_full }}
                            </p>
                            <p class="text-xs leading-none text-muted-foreground">
                                {{ attendee.event.title }}
                            </p>
                        </div>
                    </Link>
                </Button>

                <NavigationBarItem
                    :href="route('index')"
                    icon="home-3"
                    label="Frontpage"
                />
            </div>
        </template>
        <template #user_sidebar v-else>
            <NavigationBarItem
                :href="route('login')"
                label="Login"
            />
            <NavigationBarItem
                :href="route('register')"
                label="Register"
            />
        </template>
    </NavigationBar>
</template>

<script setup lang="ts">
import NavigationBar from "@/components/Common/NavigationBar.vue";
import NavigationBarItem from "@/components/Common/NavigationBarItem.vue";
import {usePage, Link} from "@inertiajs/vue3";
import {computed} from "vue";
import { Button } from '@/components/ui/button'
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
import {Avatar, AvatarFallback, AvatarImage} from "@/components/ui/avatar";
import {Separator} from "@/components/ui/separator";
import {Label} from "@/components/ui/label";

const props = defineProps({
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
        if(attendee.event_id === props.event.id) {
            foundAttendee = attendee;
        }
    })

    return foundAttendee;
});
</script>

<style lang="scss" scoped>
.logo {
    & img {
        @apply max-h-[45px];
    }
}
</style>

<template>
    <section class="layout-admin">
        <aside>
            <div class="logo">
                <img
                    :src="LumetraLightLogo"
                    alt="Lumetra Logo"
                    class="hidden dark:hidden md:block"
                />
                <img
                    :src="LumetraDarkLogo"
                    alt="Lumetra Logo"
                    class="hidden dark:md:block"
                />
                <img
                    :src="LumetraIcon"
                    alt="Lumetra Logo"
                    class="block md:hidden"
                />
            </div>

            <Separator />

            <nav>
                <Button
                    :variant="$page.url.endsWith('/admin') ? 'secondary' : 'ghost'"
                    class="justify-start"
                    as-child
                >
                    <Link :href="route('events.admin', { eventId: event.id })">
                        <i class="ri-home-3-line mr-2 text-lg"></i>
                        <span>Dashboard</span>
                    </Link>
                </Button>
                <Button
                    :variant="$page.url.includes('notes') ? 'secondary' : 'ghost'"
                    class="justify-start"
                    as-child
                >
                    <Link :href="route('events.admin.notes', { eventId: event.id })">
                        <i class="ri-sticky-note-line mr-2 text-lg"></i>
                        <span>Notes</span>
                    </Link>
                </Button>
                <Button
                    :variant="$page.url.includes('eventSettings') ? 'secondary' : 'ghost'"
                    class="justify-start"
                    as-child
                >
                    <Link :href="route('events.admin.eventSettings', { eventId: event.id })">
                        <i class="ri-calendar-event-line mr-2 text-lg"></i>
                        <span>Event Settings</span>
                    </Link>
                </Button>
                <Button
                    :variant="$page.url.includes('rooms') ? 'secondary' : 'ghost'"
                    class="justify-start"
                    as-child
                >
                    <Link :href="route('events.admin.rooms', { eventId: event.id })">
                        <i class="ri-group-2-line mr-2 text-lg"></i>
                        <span>Rooms</span>
                    </Link>
                </Button>
                <Button
                    :variant="$page.url.includes('attendees') ? 'secondary' : 'ghost'"
                    class="justify-start"
                    as-child
                >
                    <Link :href="route('events.admin.attendees', { eventId: event.id })">
                        <i class="ri-user-line mr-2 text-lg"></i>
                        <span>Attendees</span>
                    </Link>
                </Button>
            </nav>
        </aside>
        <main>
            <header>
                <h4>{{ title }}</h4>

                <slot name="header" />

                <Button
                    variant="secondary"
                    as-child
                >
                    <Link :href="route('events.detail', { eventId: event.id })">
                        <i class="ri-arrow-right-up-line text-lg md:mr-2"></i>
                        <span class="hidden md:block">Go to event</span>
                    </Link>
                </Button>

                <ThemeSwitcher />
            </header>
            <Separator />
            <section class="content">
                <slot />
            </section>
        </main>
    </section>

    <Toaster />
</template>

<script setup lang="ts">
import ThemeSwitcher from '@/components/Common/ThemeSwitcher.vue';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { Event } from '@/types/models/Event';
import { Link } from '@inertiajs/vue3';
import { PropType } from 'vue';
import LumetraIcon from '../../img/lumetra-icon.svg';
import LumetraDarkLogo from '../../img/lumetra-logo-ondark.svg';
import LumetraLightLogo from '../../img/lumetra-logo-onlight.svg';
import Toaster from '../components/ui/toast/Toaster.vue';

defineProps({
    title: {
        type: String,
        default: '',
    },
    event: {
        type: Object as PropType<Event>,
        required: true,
    },
});
</script>

<style lang="scss" scoped>
.layout-admin {
    @apply grid min-h-[100dvh] grid-cols-[350px_1fr];

    & aside {
        @apply flex flex-col border-r;

        & .logo {
            @apply flex h-[60px] items-center p-4;

            & img {
                @apply h-5;
            }
        }

        & nav {
            @apply flex flex-col gap-1 border-b p-2;
        }
    }
    & main {
        @apply flex flex-col;

        & header {
            @apply flex h-[60px] w-full items-center gap-2 p-4;

            & h4 {
                @apply block grow text-xl font-semibold tracking-tight;
            }
        }

        & .content {
            @apply flex flex-col;
        }
    }
}

@media screen and (max-width: 1200px) {
    .layout-admin {
        @apply grid-cols-[300px_1fr];
    }
}

@media screen and (max-width: 768px) {
    .layout-admin {
        @apply grid-cols-[60px_1fr];

        & aside {
            & .logo {
                @apply flex items-center justify-center;
            }
            & nav {
                & a {
                    @apply flex h-10 w-10 items-center justify-center p-0;

                    & i {
                        @apply m-0;
                    }
                    & span {
                        @apply hidden;
                    }
                }
            }
        }
    }
}
</style>

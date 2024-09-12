<template>
    <section class="layout-admin">
        <aside>
            <div class="logo">
                <img :src="LumetraLightLogo" alt="Lumetra Logo" class="dark:hidden block" />
                <img :src="LumetraDarkLogo" alt="Lumetra Logo" class="dark:block hidden" />
            </div>

            <Separator />

            <nav>
                <Button
                    variant="ghost"
                    class="justify-start"
                >
                    <i class="ri-home-3-line mr-2 text-lg"></i>
                    <span>Dashboard</span>
                </Button>
                <Button
                    variant="ghost"
                    class="justify-start"
                >
                    <i class="ri-sticky-note-line mr-2 text-lg"></i>
                    <span>Notes</span>
                </Button>
                <Button
                    variant="ghost"
                    class="justify-start"
                >
                    <i class="ri-calendar-event-line mr-2 text-lg"></i>
                    <span>Event</span>
                </Button>
                <Button
                    variant="ghost"
                    class="justify-start"
                >
                    <i class="ri-group-2-line mr-2 text-lg"></i>
                    <span>Rooms</span>
                </Button>
                <Button
                    variant="ghost"
                    class="justify-start"
                >
                    <i class="ri-user-line mr-2 text-lg"></i>
                    <span>Attendees</span>
                </Button>
            </nav>
        </aside>
        <main>
            <header>
                <h4>{{ title }}</h4>

                <Button
                    variant="secondary"
                    as-child
                >
                    <Link :href="route('events.detail', { eventId: event.id })">
                        <i class="ri-arrow-right-up-line mr-2 text-lg"></i>
                        <span>Go to event</span>
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
</template>

<script setup lang="ts">
import LumetraLightLogo from "../../img/lumetra-logo-onlight.svg";
import LumetraDarkLogo from "../../img/lumetra-logo-ondark.svg";
import {Separator} from "@/components/ui/separator";
import {Button} from "@/components/ui/button";
import {Link} from "@inertiajs/vue3";
import {PropType} from "@vue/runtime-dom";
import {Event} from "@/types/models/Event";
import ThemeSwitcher from "@/components/Common/ThemeSwitcher.vue";

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
    @apply grid grid-cols-[350px_1fr] min-h-[100dvh];

    & aside {
        @apply border-r flex flex-col;

        & .logo {
            @apply p-4 h-[60px] flex items-center;

            & img {
                @apply h-5;
            }
        }

        & nav {
            @apply border-b p-2 flex flex-col gap-1;
        }
    }
    & main {
        @apply flex flex-col;

        & header {
            @apply p-4 h-[60px] flex items-center w-full gap-2;

            & h4 {
                @apply text-xl font-semibold tracking-tight block grow;
            }
        }

        & .content {
            @apply p-5 flex flex-col gap-2;
        }
    }
}
</style>

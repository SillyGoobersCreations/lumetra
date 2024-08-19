<template>
    <component :is="currentLayout" :event="currentLayout === EventLayout ? event : undefined">
        <section class="attendee-settings">
            <aside>
                <Link
                    :href="route('settings.global')"
                    class="button reverse"
                >
                    <span>General Settings</span>
                </Link>

                <Link
                    v-for="attendee in user.attendees"
                    :key="attendee.id"
                    :href="route('settings.event', {eventId: attendee.event.id})"
                    class="button reverse"
                >
                    <span>{{ attendee.event.title }}</span>
                </Link>
            </aside>
            <div>
                <Box>
                    {{ user }}
                </Box>

                <Box v-if="attendee">
                    {{ attendee }}
                </Box>
            </div>
        </section>
    </component>
</template>

<script setup lang="ts">
import {Link} from "@inertiajs/vue3";
import EventLayout from "@/Layouts/EventLayout.vue";
import Box from "@/Components/Common/Box.vue";
import {PropType} from "@vue/runtime-dom";
import {Event} from "@/types/models/Event";
import {Attendee} from "@/types/models/Attendee";
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import {User} from "@/types/models/User";
import {computed} from "vue";

const props = defineProps({
    user: {
        type: Object as PropType<User>,
        required: true,
    },
    event: {
        type: Object as PropType<Event>,
        default: null,
    },
    attendee: {
        type: Object as PropType<Attendee>,
        default: null,
    },
});

const currentLayout = computed(() => props.event && props.attendee ? EventLayout : DefaultLayout);
</script>

<style lang="scss" scoped>
.attendee-settings {
    display: grid;
    grid-template-columns: 350px 1fr;
    gap: 15px;
}
.attendee-settings > div {
    display: flex;
    flex-direction: column;
    gap: 15px;
}
</style>

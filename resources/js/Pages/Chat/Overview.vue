<template>
    <EventLayout :event="event">
        <section
            class="chat-overview"
            v-if="currentAttendee !== null"
        >
            <aside>
                <Box :no-padding="true" class="connection-list">
                    <ConnectionButton
                        v-for="connection in connections"
                        :key="connection.id"
                        :current-attendee-id="currentAttendee.id"
                        :connection="connection"
                    />
                </Box>

                <Link
                    :href="route('events.attendees.index', {
                        eventId: event.id,
                    })"
                    class="button primary more-button"
                >
                    <i class="ri-shake-hands-line"></i>
                    <span>Connect with attendees</span>
                </Link>
            </aside>
            <main>
                <Box>
                    Info
                </Box>
            </main>
        </section>
    </EventLayout>
</template>

<script setup lang="ts">
import {Link, usePage} from '@inertiajs/vue3';
import EventLayout from "@/Layouts/EventLayout.vue";
import Box from "@/components/Common/Box.vue";
import {PropType} from "@vue/runtime-dom";
import {Event} from "@/types/models/Event";
import {AttendeeConnection} from "@/types/models/AttendeeConnection";
import ConnectionButton from "@/components/Chat/ConnectionButton.vue";
import {computed} from "vue";

const page = usePage();
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

const props = defineProps({
    event: {
        type: Object as PropType<Event>,
        required: true,
    },
    connections: {
        type: Array as PropType<AttendeeConnection[]>,
        default: () => []
    },
});
</script>

<style lang="scss" scoped>
.chat-overview {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 20px;

    & aside {
        display: flex;
        flex-direction: column;
        gap: 20px;

        & .connection-list {
            padding: 5px;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        & .more-button {
            justify-content: center;
        }
    }
}
</style>

<template>
    <EventLayout :event="event">
        <section class="attendee-settings">
            <Sidebar :attendees="user.attendees" />
            <div>
                <Box>
                    {{ attendee.handle }}<hr />
                    {{ attendee.first_name }}<hr />
                    {{ attendee.last_name }}
                </Box>
                <Box>
                    {{ attendee.avatar_url }}<hr />
                </Box>
                <Box>
                    {{ attendee.description }}<hr />
                    {{ attendee.job_company }}<hr />
                    {{ attendee.job_position }}<hr />
                </Box>
                <Box>
                    {{ attendee.confirmed }}<hr />
                    {{ attendee.confirmation_key }}
                </Box>
            </div>
        </section>
    </EventLayout>
</template>

<script setup lang="ts">
import {Link} from "@inertiajs/vue3";
import EventLayout from "@/Layouts/EventLayout.vue";
import Box from "@/Components/Common/Box.vue";
import {PropType} from "@vue/runtime-dom";
import {Event} from "@/types/models/Event";
import {Attendee} from "@/types/models/Attendee";
import {User} from "@/types/models/User";
import Sidebar from "@/Components/Settings/Sidebar.vue";

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

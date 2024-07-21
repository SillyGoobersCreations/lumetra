<template>
    <Box class="properties">
        <div v-if="event.start_date">
            <span>Starting</span>
            <span>{{ moment(event.start_date).format("D.MM.YYYY @ HH:mm") }}</span>
        </div>
        <div v-if="event.end_date">
            <span>Ending</span>
            <span>{{ moment(event.end_date).format("D.MM.YYYY @ HH:mm") }}</span>
        </div>
    </Box>
    <Box>
        <pre>State: {{ event.state ?? "null" }}</pre><br />
        <pre>ConfirmationRequired: {{ event.confirmation_required ?? "null" }}</pre><br />
        <pre>AttendeesMax: {{ event.attendees_max ?? "null" }}</pre><br />
    </Box>
</template>
<script setup lang="ts">
import moment from "moment/moment";
import Box from "@/Components/Common/Box.vue";

defineProps({
    event: {
        type: Object,
        required: true,
    }
});
</script>

<style lang="scss" scoped>
.properties {
    display: flex;
    flex-direction: column;
    gap: 15px;

    & > div {
        display: flex;
        gap: 15px;
        align-items: center;

        & span:nth-child(1) {
            text-align: right;
        }
        & span:nth-child(2) {
            color: rgb(var(--color-base-400));
        }
    }
}
</style>

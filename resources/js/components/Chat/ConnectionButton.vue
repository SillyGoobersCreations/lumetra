<template>
    <Button
        as-child
        :variant="active ? 'secondary' : 'ghost'"
        class="justify-start py-6"
    >
        <Link
            :href="route('events.chats.detail', {
                eventId: attendee.event_id,
                attendeeId: attendee.id,
            })"
        >
            <Avatar class="h-8 w-8 mr-2">
                <AvatarImage :src="`/storage/avatars/${attendee.avatar_url}`" v-if="attendee.avatar_url" />
                <AvatarFallback>{{ attendee.name_initials }}</AvatarFallback>
            </Avatar>
            <div class="flex flex-col space-y-1">
                <p class="text-sm font-medium leading-none">
                    {{ attendee.name_full }}
                </p>
                <p class="text-xs leading-none text-muted-foreground">
                    Connected {{ moment(connection.created_at).fromNow() }}
                </p>
            </div>
        </Link>
    </Button>
</template>

<script setup lang="ts">
import {Link} from '@inertiajs/vue3';
import {PropType} from "@vue/runtime-dom";
import {AttendeeConnection} from "@/types/models/AttendeeConnection";
import {computed} from "vue";
import moment from "moment/moment";
import {Button} from "@/components/ui/button";
import {Avatar, AvatarFallback, AvatarImage} from "@/components/ui/avatar";

const props = defineProps({
    currentAttendeeId: {
        type: String,
        required: true,
    },
    connection: {
        type: Object as PropType<AttendeeConnection>,
        required: true,
    },
    active: {
        type: Boolean,
        default: false,
    }
});

const attendee = computed(() => {
    if(props.currentAttendeeId === props.connection?.inviter_attendee_id) {
        return props.connection?.invitee_attendee;
    } else {
        return props.connection?.inviter_attendee;
    }
});
</script>

<style lang="scss" scoped>
</style>

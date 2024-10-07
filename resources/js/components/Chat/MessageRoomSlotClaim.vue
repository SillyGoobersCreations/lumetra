<template>
    <Message :is-remote="isRemote">
        <template #default>
            <div class="flex flex-col gap-0">
                <span class="text-xs font-bold">Meet invite</span>
                <span class="mb-2">{{ moment(claim.slot.start_date).format("D.M.Y") }} @ {{ moment(claim.slot.start_date).format("HH:mm") }} <span class="text-muted-foreground">- {{ moment(claim.slot.end_date).format("HH:mm") }}</span></span>
                <span class="font-bold">{{ claim.slot.room.name }}</span>
                <span class="text-muted-foreground">{{ claim.slot.room.location }}</span>
            </div>
        </template>
        <template v-if="isRemote" #actions>
            <Button
                as-child
                variant="secondary"
                size="xs"
            >
                <Link
                    href=""
                >
                    <i class="ri-shake-hands-line mr-2 text-lg"></i>
                    <span>Accept</span>
                </Link>
            </Button>
            <Button
                as-child
                size="xs"
                variant="destructive"
            >
                <Link
                    href=""
                >
                    <i class="ri-delete-bin-line mr-2 text-lg"></i>
                    <span>Decline</span>
                </Link>
            </Button>
        </template>
        <template v-else #actions>
            <div class="text-muted-foreground">Awaiting response</div>
        </template>
    </Message>
</template>

<script setup lang="ts">
import moment from "moment/moment";
import Message from "@/components/Chat/Message.vue";
import {Link} from "@inertiajs/vue3";
import {Button} from "@/components/ui/button";
import {PropType} from "@vue/runtime-dom";
import {EventRoomSlotClaim} from "@/types/models/EventRoomSlotClaim";

const props = defineProps({
    isRemote: {
        type: Boolean,
        default: false,
    },
    claim: {
        type: Object as PropType<EventRoomSlotClaim>,
        required: true,
    },
});
</script>

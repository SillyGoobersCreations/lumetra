<template>
    <Dialog v-model:open="dialogOpen">
        <DialogTrigger as-child>
            <Button class="w-full">
                <i class="ri-shake-hands-line mr-2 text-lg"></i>
                <span>Connect</span>
            </Button>
        </DialogTrigger>
        <DialogContent class="connect-dialog">
            <DialogHeader>
                <DialogTitle>Connect with {{ attendee.name_full }}</DialogTitle>
                <DialogDescription>Send {{ attendee.name_full }} a connection request. They will be able to accept or decline your request.</DialogDescription>
            </DialogHeader>
            <div
                class="loading"
                v-if="connectRequestForm.processing"
            >
                <LoadingCircle />
            </div>
            <form
                @submit.prevent="sendConnectRequest"
                v-else
            >
                <Textarea
                    v-model="connectRequestForm.intro_text"
                    placeholder="Hey there, I'm..."
                    rows="5"
                />
                <div
                    class="error"
                    v-if="connectRequestForm.errors.intro_text"
                >
                    {{ connectRequestForm.errors.intro_text }}
                </div>
            </form>
            <DialogFooter>
                <Button
                    :disabled="connectRequestForm.processing"
                    @click="sendConnectRequest"
                >
                    <i class="ri-send-plane-2-line mr-2 text-lg"></i>
                    <span>Send Request</span>
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

<script setup lang="ts">
import LoadingCircle from '@/components/Common/LoadingCircle.vue';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Textarea } from '@/components/ui/textarea';
import { Attendee } from '@/types/models/Attendee';
import { Event } from '@/types/models/Event';
import { useForm } from '@inertiajs/vue3';
import { PropType, ref } from 'vue';

const dialogOpen = ref(false);

const props = defineProps({
    event: {
        type: Object as PropType<Event>,
        required: true,
    },
    attendee: {
        type: Object as PropType<Attendee>,
        default: null,
    },
});

const connectRequestForm = useForm({
    intro_text: '',
});

function sendConnectRequest() {
    connectRequestForm.post(
        route('events.attendees.connect', {
            eventId: props.event.id,
            attendeeId: props.attendee.id,
        }),
        {
            onSuccess: () => {
                connectRequestForm.reset('intro_text');
                dialogOpen.value = false;
            },
        },
    );
}
</script>

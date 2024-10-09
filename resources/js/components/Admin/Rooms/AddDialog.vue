<template>
    <Dialog
        v-model:open="dialogOpen"
    >
        <DialogTrigger as-child>
            <Button>
                <i class="ri-add-line text-lg md:mr-2"></i>
                <span class="hidden md:block">Create new</span>
            </Button>
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Create new room</DialogTitle>
            </DialogHeader>
            <div class="flex flex-col gap-4">
                <FormRow label="Name" :error="form.errors.name">
                    <Input placeholder="eg. Room #1 - Table #2" v-model="form.name" />
                </FormRow>
                <FormRow label="Location" :error="form.errors.location">
                    <Input placeholder="eg. Meetup Room" v-model="form.location" />
                </FormRow>
                <FormRow label="Notes" :error="form.errors.notes">
                    <Input placeholder="eg. Space for 2 people" v-model="form.notes" />
                </FormRow>
                <FormRow label="Available" :error="form.errors.available">
                    <Switch :checked="form.available" @update:checked="(val) => { form.available = val; }" />
                </FormRow>
            </div>
            <DialogFooter>
                <Button @click="sendForm">
                    <span>Create</span>
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

<script setup lang="ts">
import {Dialog, DialogContent, DialogFooter, DialogHeader, DialogTitle, DialogTrigger} from "@/components/ui/dialog";
import {Button} from "@/components/ui/button";
import {ref} from "vue";
import FormRow from "@/components/Common/FormRow.vue";
import {Input} from "@/components/ui/input";
import {Switch} from "@/components/ui/switch";
import {useForm} from "@inertiajs/vue3";
import {PropType} from "@vue/runtime-dom";
import {Event} from "@/types/models/Event";
import {toast} from "@/components/ui/toast";

const dialogOpen = ref(false);

const props = defineProps({
    event: {
        type: Object as PropType<Event>,
        required: true,
    },
});

const form = useForm({
    name: '',
    location: '',
    notes: '',
    available: false,
});

function sendForm() {
    form.post(route('events.admin.rooms.create', {
        eventId: props.event.id,
    }), {
        onSuccess: () => {
            dialogOpen.value = false;

            toast({
                title: "Successfully saved."
            });
            form.reset();
        },
        onError: () => {
            toast({
                title: "Could not save.",
                description: "Please try again later.",
                variant: "destructive"
            });
        }
    });
}
</script>

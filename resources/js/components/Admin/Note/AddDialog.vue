<template>
    <Dialog
        v-model:open="dialogOpen"
    >
        <DialogTrigger as-child>
            <Button>
                <i class="ri-add-line text-lg mr-2"></i>
                <span>Create new</span>
            </Button>
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Create a new note</DialogTitle>
            </DialogHeader>
            <div class="flex flex-col gap-4">
                <FormRow label="Title" :error="form.errors.title">
                    <Input v-model="form.title" />
                </FormRow>
                <FormRow label="Text" :error="form.errors.text">
                    <Textarea v-model="form.text" />
                </FormRow>
                <FormRow label="Sticky" :error="form.errors.sticky">
                    <Switch :checked="form.sticky" @update:checked="(val) => { form.sticky = val; }" />
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
import {Textarea} from "@/components/ui/textarea";

const dialogOpen = ref(false);

const props = defineProps({
    event: {
        type: Object as PropType<Event>,
        required: true,
    },
});

const form = useForm({
    title: '',
    text: '',
    sticky: false,
});

function sendForm() {
    form.post(route('events.admin.notes.create', {
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

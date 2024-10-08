<template>
    <EventLayout :event="event">
        <section class="attendee-settings">
            <Sidebar :attendees="user.attendees" />
            <main>
                <form @submit.prevent="submitName">
                    <Card>
                        <CardHeader>
                            <CardTitle>Identity</CardTitle>
                        </CardHeader>
                        <CardContent class="flex flex-col gap-3">
                            <FormRow
                                label="Handle"
                                :error="nameForm.errors.handle"
                                variant="wide"
                            >
                                <Input type="text" id="handle" placeholder="@johndoe" v-model="nameForm.handle" />
                            </FormRow>
                            <FormRow
                                label="First name"
                                :error="nameForm.errors.first_name"
                                variant="wide"
                            >
                                <Input type="text" id="first_name" placeholder="John" v-model="nameForm.first_name" />
                            </FormRow>
                            <FormRow
                                label="Last name"
                                :error="nameForm.errors.last_name"
                                variant="wide"
                            >
                                <Input type="text" id="last_name" placeholder="Doe" v-model="nameForm.last_name" />
                            </FormRow>
                        </CardContent>
                        <CardFooter class="justify-end flex gap-2">
                            <Button>
                                <span class="ri-save-2-line mr-2 text-lg"></span>
                                <span>Save</span>
                            </Button>
                        </CardFooter>
                    </Card>
                </form>

                <form @submit.prevent="submitAvatar">
                    <Card>
                        <CardHeader>
                            <CardTitle>Avatar</CardTitle>
                        </CardHeader>
                        <CardContent class="flex flex-col gap-3">
                            <FormRow
                                label="Avatar"
                                :error="avatarForm.errors.avatar"
                                variant="wide"
                            >
                                <Input type="file" id="avatar" @input="avatarForm.avatar = $event.target.files[0]" />
                            </FormRow>
                        </CardContent>
                        <CardFooter class="justify-end flex gap-2">
                            <Button variant="destructive" as-child>
                                <Link
                                    :href="route('settings.event.avatar.clear', {eventId: event.id})"
                                >
                                    <span>Clear current</span>
                                </Link>
                            </Button>
                            <Button>
                                <span class="ri-save-2-line mr-2 text-lg"></span>
                                <span>Save</span>
                            </Button>
                        </CardFooter>
                    </Card>
                </form>
                <form @submit.prevent="submitDescription">
                    <Card>
                        <CardHeader>
                            <CardTitle>About you</CardTitle>
                        </CardHeader>
                        <CardContent class="flex flex-col gap-3">
                            <FormRow
                                label="Description"
                                :error="descriptionForm.errors.description"
                                variant="wide"
                            >
                                <Textarea v-model="descriptionForm.description" />
                            </FormRow>
                            <FormRow
                                label="Company"
                                :error="descriptionForm.errors.job_company"
                                variant="wide"
                            >
                                <Input type="text" id="job_company" v-model="descriptionForm.job_company" />
                            </FormRow>
                            <FormRow
                                label="Position"
                                :error="descriptionForm.errors.job_position"
                                variant="wide"
                            >
                                <Input type="text" id="job_position" v-model="descriptionForm.job_position" />
                            </FormRow>
                        </CardContent>
                        <CardFooter class="justify-end flex gap-2">
                            <Button>
                                <span class="ri-save-2-line mr-2 text-lg"></span>
                                <span>Save</span>
                            </Button>
                        </CardFooter>
                    </Card>
                </form>

                <Card v-if="attendee.confirmed">
                    <CardHeader>
                        <CardTitle>Confirmation</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div class="text-green-400">Great news, your profile was confirmed.</div>
                    </CardContent>
                </Card>
            </main>
        </section>
    </EventLayout>
</template>

<script setup lang="ts">
import {Link, useForm} from "@inertiajs/vue3";
import EventLayout from "@/Layouts/EventLayout.vue";
import {PropType} from "@vue/runtime-dom";
import {Event} from "@/types/models/Event";
import {Attendee} from "@/types/models/Attendee";
import {User} from "@/types/models/User";
import Sidebar from "@/components/Settings/Sidebar.vue";
import {inject} from "vue";
import { useToast } from '@/components/ui/toast/use-toast';
import {Card, CardContent, CardFooter, CardHeader, CardTitle} from "@/components/ui/card";
import {Button} from "@/components/ui/button";
import FormRow from "@/components/Common/FormRow.vue";
import {Input} from "@/components/ui/input";
import {Textarea} from "@/components/ui/textarea";

const { toast } = useToast();
const emitter = inject('emitter');

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

const nameForm = useForm({
    handle: props.attendee?.handle,
    first_name: props.attendee?.first_name,
    last_name: props.attendee?.last_name,
});

const avatarForm = useForm({
    avatar: null,
});

const descriptionForm = useForm({
    description: props.attendee?.description,
    job_company: props.attendee?.job_company,
    job_position: props.attendee?.job_position,
});

const confirmationForm = useForm({
    confirmation_key: "",
});

function submitName() {
    nameForm.post(route('settings.event.name', {eventId: props.event.id}), {
        onSuccess: () => {
            toast({
                description: "Successfully saved."
            });
        },
        onError: () => {
            toast({
                description: "Could not save. Please try again later.",
                variant: "destructive"
            });
        },
    });
}

function submitAvatar() {
    avatarForm.post(route('settings.event.avatar', {eventId: props.event.id}), {
        onSuccess: () => {
            toast({
                description: "Successfully saved."
            });
        },
        onError: () => {
            toast({
                description: "Could not save. Please try again later.",
                variant: "destructive"
            });
        },
    });
}

function submitDescription() {
    descriptionForm.post(route('settings.event.description', {eventId: props.event.id}), {
        onSuccess: () => {
            toast({
                description: "Successfully saved."
            });
        },
        onError: () => {
            toast({
                description: "Could not save. Please try again later.",
                variant: "destructive"
            });
        },
    });
}
</script>

<style lang="scss" scoped>
.attendee-settings {
    @apply flex flex-col lg:grid lg:grid-cols-[350px_1fr] gap-4;
}
.attendee-settings > main {
    @apply flex flex-col gap-4;
}
</style>

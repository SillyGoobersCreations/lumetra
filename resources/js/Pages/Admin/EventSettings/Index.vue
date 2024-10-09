<template>
    <AdminLayout title="Event Settings" :event="event">
        <template #header>
            <Button
                @click="submitForm"
            >
                <span class="ri-save-line mr-2 text-lg"></span>
                <span>Save</span>
            </Button>
        </template>

        <section class="page-eventSettings">
            <div>
                <Card>
                    <CardHeader>
                        <CardTitle>Visibility</CardTitle>
                    </CardHeader>
                    <CardContent class="flex gap-4">
                        <Button
                            class="state-button"
                            :variant="form.state === 'draft' ? 'default' : 'secondary'"
                            @click="form.state = 'draft'"
                        >
                            <i class="ri-quill-pen-line"></i>
                            <h1>Draft</h1>
                            <p>Only available for you</p>
                        </Button>
                        <Button
                            class="state-button"
                            :variant="form.state === 'hidden' ? 'default' : 'secondary'"
                            @click="form.state = 'hidden'"
                        >
                            <i class="ri-link"></i>
                            <h1>Hidden</h1>
                            <p>Not visible but available</p>
                        </Button>
                        <Button
                            class="state-button"
                            :variant="form.state === 'public' ? 'default' : 'secondary'"
                            @click="form.state = 'public'"
                        >
                            <i class="ri-eye-line"></i>
                            <h1>Public</h1>
                            <p>Fully visible and available</p>
                        </Button>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle>General</CardTitle>
                    </CardHeader>
                    <CardContent class="flex flex-col gap-4">
                        <FormRow label="ID" variant="wide">
                            <div class="text-muted-foreground">{{ event.id }}</div>
                        </FormRow>
                        <FormRow label="Title" variant="wide" :error="form.errors.title">
                            <Input v-model="form.title" />
                        </FormRow>
                        <FormRow label="Description" variant="wide" :error="form.errors.description">
                            <Textarea v-model="form.description" />
                        </FormRow>
                        <FormRow label="Organizer" variant="wide" :error="form.errors.organizer">
                            <Input v-model="form.organizer" />
                        </FormRow>
                        <FormRow label="Start Date" variant="wide" :error="form.errors.start_date">
                            <Popover>
                                <PopoverTrigger as-child>
                                    <Button
                                        variant="outline"
                                        :class="`justify-start ${ !startDateValue && 'text-muted-foreground' }`"
                                    >
                                        <i class="ri-calendar-2-line mr-2 text-lg"></i>
                                        {{ startDateValue ? df.format(startDateValue.toDate(getLocalTimeZone())) : "Pick a date" }}
                                    </Button>
                                </PopoverTrigger>
                                <PopoverContent class="w-auto p-0">
                                    <Calendar
                                        v-model="startDateValue"
                                    />
                                </PopoverContent>
                            </Popover>
                        </FormRow>
                        <FormRow label="End Date" variant="wide" :error="form.errors.end_date">
                            <Popover>
                                <PopoverTrigger as-child>
                                    <Button
                                        variant="outline"
                                        :class="`justify-start ${ !endDateValue && 'text-muted-foreground' }`"
                                    >
                                        <i class="ri-calendar-2-line mr-2 text-lg"></i>
                                        {{ endDateValue ? df.format(endDateValue.toDate(getLocalTimeZone())) : "Pick a date" }}
                                    </Button>
                                </PopoverTrigger>
                                <PopoverContent class="w-auto p-0">
                                    <Calendar
                                        v-model="endDateValue"
                                    />
                                </PopoverContent>
                            </Popover>
                        </FormRow>
                        <FormRow label="Maximum amount of attendees" variant="wide" :error="form.errors.attendees_max">
                            <Input type="number" v-model="form.attendees_max" />
                        </FormRow>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle>Emails</CardTitle>
                    </CardHeader>
                    <CardContent class="flex flex-col gap-4">
                        <FormRow label="Name" variant="wide" :error="form.errors.email_name">
                            <Input v-model="form.email_name" />
                        </FormRow>
                        <FormRow label="From" variant="wide" :error="form.errors.email_from">
                            <Input v-model="form.email_from" placeholder="noreply@example.org" />
                        </FormRow>
                    </CardContent>
                </Card>
            </div>

            <div>
                <form @submit.prevent="submitLogo">
                    <Card>
                        <CardHeader>
                            <CardTitle>Logo</CardTitle>
                        </CardHeader>
                        <CardContent class="flex flex-col gap-3">
                            <div class="flex items-center justify-center">
                                <img :src="`/storage/logos/${event.logo}`" style="height: 60px;" alt="Logo" v-if="event.logo" />
                            </div>
                            <FormRow
                                label="Logo"
                                :error="logoForm.errors.logo"
                                variant="wide"
                            >
                                <Input type="file" id="logo" @input="logoForm.logo = $event.target.files[0]" />
                            </FormRow>
                        </CardContent>
                        <CardFooter class="justify-end flex gap-2">
                            <Button variant="destructive" as-child>
                                <Link
                                    :href="route('events.admin.eventSettings.doClearLogo', {eventId: event.id})"
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

                <Card>
                    <CardHeader>
                        <CardTitle>Confirmations</CardTitle>
                        <CardDescription>Attendees will be able to confirm themselves as confirmed. If needed, only confirmed attendees will be able to interact with other attendees.</CardDescription>
                    </CardHeader>
                    <CardContent class="flex flex-col gap-4">
                        <FormRow label="Confirmation required" variant="wide">
                            <Switch :checked="form.confirmation_required" @update:checked="(val) => { form.confirmation_required = val; }" />
                        </FormRow>
                        <FormRow label="Generate confirmation key per user" variant="wide" v-if="form.confirmation_required">
                            <Switch :checked="form.confirmation_personalized" @update:checked="(val) => { form.confirmation_personalized = val; }" />
                        </FormRow>
                        <FormRow label="Global confirmation key" variant="wide" v-if="form.confirmation_required && !form.confirmation_personalized">
                            <Input v-model="form.confirmation_key" />
                        </FormRow>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle>Room slots</CardTitle>
                    </CardHeader>
                    <CardContent class="flex flex-col gap-4">
                        <!-- TODO -->
                        <!-- <FormRow label="Max slots an attendee can hold in pending" variant="wide">
                            <Input type="number" v-model="form.room_slot_max_pending" />
                        </FormRow>
                        <FormRow label="Max slots an attendee can claim" variant="wide">
                            <Input type="number" v-model="form.room_slot_max_claimed" />
                        </FormRow> -->
                        <FormRow label="Organizers must approve claims" variant="wide">
                            <Switch :checked="form.room_slot_team_confirmation_required" @update:checked="(val) => { form.room_slot_team_confirmation_required = val; }" />
                        </FormRow>
                    </CardContent>
                </Card>
            </div>
        </section>
    </AdminLayout>
</template>

<script setup lang="ts">
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {PropType} from "@vue/runtime-dom";
import {Event} from "@/types/models/Event";
import {Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle} from "@/components/ui/card";
import FormRow from "@/components/Common/FormRow.vue";
import {Button} from "@/components/ui/button";
import {Link, useForm} from "@inertiajs/vue3";
import {Input} from "@/components/ui/input";
import {Textarea} from "@/components/ui/textarea";
import {DateFormatter, type DateValue, getLocalTimeZone, parseDate} from "@internationalized/date";
import {Popover, PopoverContent, PopoverTrigger} from "@/components/ui/popover";
import {Calendar} from "@/components/ui/calendar";
import {onMounted, ref, watch} from "vue";
import moment from "moment";
import {Switch} from "@/components/ui/switch";
import {toast} from "@/components/ui/toast";

const props = defineProps({
    event: {
        type: Object as PropType<Event>,
        required: true,
    },
});

const form = useForm({
    'state': props.event.state ?? 'draft',
    'title': props.event.title,
    'organizer': props.event.organizer,
    'logo': props.event.logo,
    'description': props.event.description,
    'start_date': props.event.start_date,
    'end_date': props.event.end_date,
    'email_name': props.event.email_name,
    'email_from': props.event.email_from,
    'confirmation_required': props.event.confirmation_required,
    'confirmation_personalized': props.event.confirmation_personalized,
    'confirmation_key': props.event.confirmation_key,
    'room_slot_max_pending': props.event.room_slot_max_pending,
    'room_slot_max_claimed': props.event.room_slot_max_claimed,
    'room_slot_team_confirmation_required': props.event.room_slot_team_confirmation_required,
    'attendees_max': props.event.attendees_max,
});

const logoForm = useForm({
    logo: null,
});

const df = new DateFormatter('en-US', {
    dateStyle: 'long',
});
const startDateValue = ref<DateValue>();
const endDateValue = ref<DateValue>();

onMounted(() => {
    if (props.event.start_date) {
        startDateValue.value = parseDate(moment(props.event.start_date).format('YYYY-MM-DD'));
    }
    if (props.event.end_date) {
        endDateValue.value = parseDate(moment(props.event.end_date).format('YYYY-MM-DD'));
    }
});

watch(startDateValue, (newVal) => {
    if (newVal) {
        form.start_date = `${newVal.year}-${String(newVal.month).padStart(2, '0')}-${String(newVal.day).padStart(2, '0')} 00:00:00`;
    }
});
watch(endDateValue, (newVal) => {
    if (newVal) {
        form.end_date = `${newVal.year}-${String(newVal.month).padStart(2, '0')}-${String(newVal.day).padStart(2, '0')} 23:59:59`;
    }
});

function submitForm() {
    form.post(route('events.admin.eventSettings.doSave', {eventId: props.event.id}), {
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

function submitLogo() {
    logoForm.post(route('events.admin.eventSettings.doSaveLogo', {eventId: props.event.id}), {
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
.page-eventSettings {
    @apply p-4 grid grid-cols-2 gap-4 items-start;

    & > div {
        @apply flex flex-col gap-4;
    }

    & .state-button {
        @apply py-4 flex flex-col grow h-auto;

        & i {
            @apply text-3xl mb-1;
        }
        & h1 {
            @apply font-bold;
        }
        & p {
            @apply opacity-60;
        }
    }
}
</style>

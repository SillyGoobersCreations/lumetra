<template>
    <Head :title="event.title" />
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
                                <Input
                                    type="text"
                                    id="handle"
                                    placeholder="@johndoe"
                                    v-model="nameForm.handle"
                                />
                            </FormRow>
                            <FormRow
                                label="First name"
                                :error="nameForm.errors.first_name"
                                variant="wide"
                            >
                                <Input
                                    type="text"
                                    id="first_name"
                                    placeholder="John"
                                    v-model="nameForm.first_name"
                                />
                            </FormRow>
                            <FormRow
                                label="Last name"
                                :error="nameForm.errors.last_name"
                                variant="wide"
                            >
                                <Input
                                    type="text"
                                    id="last_name"
                                    placeholder="Doe"
                                    v-model="nameForm.last_name"
                                />
                            </FormRow>
                        </CardContent>
                        <CardFooter class="flex justify-end gap-2">
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
                                <Input
                                    type="file"
                                    id="avatar"
                                    @input="avatarForm.avatar = $event.target.files[0]"
                                />
                            </FormRow>
                        </CardContent>
                        <CardFooter class="flex justify-end gap-2">
                            <Button
                                variant="destructive"
                                as-child
                            >
                                <Link :href="route('settings.event.avatar.clear', { eventId: event.id })">
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
                                <Textarea
                                    v-model="descriptionForm.description"
                                    rows="10"
                                />
                            </FormRow>
                            <FormRow
                                label="Company"
                                :error="descriptionForm.errors.job_company"
                                variant="wide"
                            >
                                <Input
                                    type="text"
                                    id="job_company"
                                    v-model="descriptionForm.job_company"
                                />
                            </FormRow>
                            <FormRow
                                label="Position"
                                :error="descriptionForm.errors.job_position"
                                variant="wide"
                            >
                                <Input
                                    type="text"
                                    id="job_position"
                                    v-model="descriptionForm.job_position"
                                />
                            </FormRow>
                        </CardContent>
                        <CardFooter class="flex justify-end gap-2">
                            <Button>
                                <span class="ri-save-2-line mr-2 text-lg"></span>
                                <span>Save</span>
                            </Button>
                        </CardFooter>
                    </Card>
                </form>

                <Card>
                    <CardHeader>
                        <CardTitle>Social links</CardTitle>
                    </CardHeader>
                    <CardContent
                        class="flex flex-col gap-2"
                        v-if="attendee.contact_infos.length > 0"
                    >
                        <div
                            class="grid grid-cols-[auto_1fr_auto_auto] items-center gap-2"
                            v-for="attendeeContactInfo in attendee.contact_infos"
                            :key="attendeeContactInfo.id"
                        >
                            <i :class="`${getContactInfoIcon(attendeeContactInfo.type)} text-lg`"></i>
                            <div class="line-clamp-1 text-xs text-muted-foreground">{{ getContactInfoLink(attendeeContactInfo.type, attendeeContactInfo.value) }}</div>
                            <Badge
                                variant="secondary"
                                v-if="attendeeContactInfo.visibility === 'public'"
                                >Public</Badge
                            >
                            <Badge
                                variant="secondary"
                                v-if="attendeeContactInfo.visibility === 'connections_only'"
                                >Connections</Badge
                            >
                            <Badge
                                variant="secondary"
                                v-if="attendeeContactInfo.visibility === 'hidden'"
                                >Hidden</Badge
                            >
                            <Button
                                variant="destructive"
                                size="sm"
                                as-child
                            >
                                <Link :href="route('settings.event.socialLink.remove', { eventId: event.id, socialLinkId: attendeeContactInfo.id })">
                                    <i class="ri-delete-bin-5-line"></i>
                                </Link>
                            </Button>
                        </div>
                    </CardContent>
                    <form @submit.prevent="submitSocialLink">
                        <CardFooter class="flex flex-col justify-start gap-2 border-t p-6 md:grid md:grid-cols-[auto_1fr_auto_auto]">
                            <Select v-model="socialLinkForm.type">
                                <SelectTrigger>
                                    <SelectValue placeholder="Select a service" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="web">Website</SelectItem>
                                    <SelectItem value="twitter">Twitter / X</SelectItem>
                                    <SelectItem value="bluesky">BlueSky</SelectItem>
                                    <SelectItem value="linkedin">LinkedIn</SelectItem>
                                    <SelectItem value="mastodon">Mastodon</SelectItem>
                                    <SelectItem value="github">GitHub</SelectItem>
                                    <SelectItem value="youtube">YouTube</SelectItem>
                                    <SelectItem value="reddit">Reddit</SelectItem>
                                    <SelectItem value="discord">Discord</SelectItem>
                                    <SelectItem value="facebook">Facebook</SelectItem>
                                </SelectContent>
                            </Select>

                            <div class="grow">
                                <Input
                                    type="text"
                                    v-model="socialLinkForm.value"
                                    :disabled="!socialLinkForm.type"
                                />
                                <div
                                    class="text-xs text-muted-foreground"
                                    v-if="socialLinkForm.value"
                                >
                                    Preview: {{ getContactInfoLink(socialLinkForm.type, socialLinkForm.value) }}
                                </div>
                            </div>

                            <Select v-model="socialLinkForm.visibility">
                                <SelectTrigger>
                                    <SelectValue placeholder="Visibiliaty..." />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="hidden">Hidden</SelectItem>
                                    <SelectItem value="connections_only">Connections</SelectItem>
                                    <SelectItem value="public">Public</SelectItem>
                                </SelectContent>
                            </Select>
                            <Button>
                                <span class="ri-save-2-line text-lg"></span>
                            </Button>
                        </CardFooter>
                    </form>
                </Card>

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
import EventLayout from '@/Layouts/EventLayout.vue';
import FormRow from '@/components/Common/FormRow.vue';
import Sidebar from '@/components/Settings/Sidebar.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import { useToast } from '@/components/ui/toast/use-toast';
import { Attendee } from '@/types/models/Attendee';
import { Event } from '@/types/models/Event';
import { User } from '@/types/models/User';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { PropType, inject } from 'vue';

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
    handle: props.attendee?.handle ?? '',
    first_name: props.attendee?.first_name ?? '',
    last_name: props.attendee?.last_name ?? '',
});

const avatarForm = useForm({
    avatar: null,
});

const descriptionForm = useForm({
    description: props.attendee?.description ?? '',
    job_company: props.attendee?.job_company ?? '',
    job_position: props.attendee?.job_position ?? '',
});

const confirmationForm = useForm({
    confirmation_key: '',
});

const socialLinkForm = useForm({
    type: 'web',
    value: '',
    visibility: 'hidden',
});
function getContactInfoIcon(type: string): string {
    switch (type) {
        default:
            return '';
        case 'web':
            return 'ri-earth-fill';
        case 'twitter':
            return 'ri-twitter-fill';
        case 'bluesky':
            return 'ri-bluesky-fill';
        case 'facebook':
            return 'ri-facebook-fill';
        case 'linkedin':
            return 'ri-linkedin-fill';
        case 'discord':
            return 'ri-discord-fill';
        case 'mastodon':
            return 'ri-mastodon-fill';
        case 'github':
            return 'ri-github-fill';
        case 'youtube':
            return 'ri-youtube-fill';
        case 'reddit':
            return 'ri-reddit-fill';
    }
}
function getContactInfoLink(type: string, value: string): string {
    switch (type) {
        default:
        case 'web':
        case 'mastodon':
        case 'discord':
            return value;
        case 'twitter':
            return `https://x.com/${value}`;
        case 'bluesky':
            return `https://bsky.app/profile/${value}`;
        case 'facebook':
            return `https://www.facebook.com/${value}`;
        case 'linkedin':
            return `https://www.linkedin.com/in/${value}`;
        case 'github':
            return `https://github.com/${value}`;
        case 'youtube':
            return `https://www.youtube.com/@${value}`;
        case 'reddit':
            return `https://reddit.com/u/${value}`;
    }
}

function submitName() {
    nameForm.post(route('settings.event.name', { eventId: props.event.id }), {
        onSuccess: () => {
            toast({
                description: 'Successfully saved.',
            });
        },
        onError: () => {
            toast({
                description: 'Could not save. Please try again later.',
                variant: 'destructive',
            });
        },
    });
}

function submitAvatar() {
    avatarForm.post(route('settings.event.avatar', { eventId: props.event.id }), {
        onSuccess: () => {
            toast({
                description: 'Successfully saved.',
            });
        },
        onError: () => {
            toast({
                description: 'Could not save. Please try again later.',
                variant: 'destructive',
            });
        },
    });
}

function submitDescription() {
    descriptionForm.post(route('settings.event.description', { eventId: props.event.id }), {
        onSuccess: () => {
            toast({
                description: 'Successfully saved.',
            });
        },
        onError: () => {
            toast({
                description: 'Could not save. Please try again later.',
                variant: 'destructive',
            });
        },
    });
}

function submitSocialLink() {
    socialLinkForm.post(route('settings.event.socialLink.create', { eventId: props.event.id }), {
        onSuccess: () => {
            toast({
                description: 'Successfully saved.',
            });
        },
        onError: () => {
            toast({
                description: 'Could not save. Please try again later.',
                variant: 'destructive',
            });
        },
    });
}
</script>

<style lang="scss" scoped>
.attendee-settings {
    @apply flex flex-col gap-4 lg:grid lg:grid-cols-[350px_1fr];
}
.attendee-settings > main {
    @apply flex flex-col gap-4;
}
</style>

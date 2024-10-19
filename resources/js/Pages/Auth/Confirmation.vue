<template>
    <Head title="Confirm Profile" />

    <AuthLayout>
        <AuthHeader title="Confirm your profile" />

        <form @submit.prevent="submit">
            <Card>
                <CardContent class="rounded-md border-0 bg-destructive p-2 px-4 text-xs text-destructive-foreground"> To continue, you must confirm your profile. Your event organizer will provide you with a key. </CardContent>
            </Card>

            <AuthFormItem
                label="Confirmation Key"
                :error="form.errors.confirmation_key"
            >
                <Input
                    placeholder="Enter a valid key..."
                    v-model="form.confirmation_key"
                />
            </AuthFormItem>

            <div class="actions">
                <Button
                    variant="link"
                    as-child
                >
                    <Link :href="route('index')">
                        <i class="ri-home-5-line mr-2 text-lg"></i>
                        <span>Frontpage</span>
                    </Link>
                </Button>
                <Button>
                    <span>Confirm</span>
                </Button>
            </div>
        </form>
    </AuthLayout>
</template>

<script setup lang="ts">
import AuthLayout from '@/Layouts/AuthLayout.vue';
import AuthHeader from '@/components/Auth/AuthHeader.vue';
import AuthFormItem from '@/components/Common/FormRow.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Event } from '@/types/models/Event';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { PropType, computed } from 'vue';

const page = usePage();
const user = computed(() => page.props.auth.user);
const attendees = computed(() => page.props.auth.attendees);

const props = defineProps({
    event: {
        type: Object as PropType<Event>,
        default: null,
    },
});

const form = useForm({
    confirmation_key: '',
});

function submit() {
    form.post(
        route('events.confirmation.confirm', {
            eventId: props.event.id,
        }),
    );
}
</script>

<style lang="scss" scoped>
form {
    @apply flex flex-col gap-5;
}
.actions {
    @apply mt-4 flex justify-end gap-2;
}
</style>

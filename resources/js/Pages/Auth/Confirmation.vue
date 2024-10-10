<template>
    <Head title="Confirm Profile" />

    <AuthLayout>
        <AuthHeader
            title="Confirm your profile"
        />

        <form @submit.prevent="submit">
            <Card>
                <CardContent class="p-2 px-4 bg-destructive text-destructive-foreground rounded-md border-0 text-xs">
                    To continue, you must confirm your profile. Your event organizer will provide you with a key.
                </CardContent>
            </Card>

            <AuthFormItem
                label="Confirmation Key"
                :error="form.errors.confirmation_key"
            >
                <Input placeholder="Enter a valid key..." v-model="form.confirmation_key" />
            </AuthFormItem>

            <div class="actions">
                <Button
                    variant="link"
                    as-child
                >
                    <Link
                        :href="route('index')"
                    >
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
import {Head, Link, useForm, usePage} from '@inertiajs/vue3';
import AuthLayout from "@/Layouts/AuthLayout.vue";
import {computed} from "vue";
import AuthHeader from "@/components/Auth/AuthHeader.vue";
import {Button} from "@/components/ui/button";
import {Input} from "@/components/ui/input";
import AuthFormItem from "@/components/Common/FormRow.vue";
import {Card, CardContent} from "@/components/ui/card";
import {PropType} from "@vue/runtime-dom";
import {Event} from "@/types/models/Event";

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

function submit () {
    form.post(route('events.confirmation.confirm', {
        eventId: props.event.id,
    }));
}
</script>

<style lang="scss" scoped>
form {
    @apply flex flex-col gap-5;
}
.actions {
    @apply flex gap-2 justify-end mt-4;
}
</style>

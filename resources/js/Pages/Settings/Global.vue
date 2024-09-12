<template>
    <DefaultLayout>
        <section class="attendee-settings">
            <Sidebar :attendees="user.attendees" />
            <main>
                <form @submit.prevent="submit">
                    <Card>
                        <CardHeader>
                            <CardTitle>Security</CardTitle>
                        </CardHeader>
                        <CardContent class="flex flex-col gap-3">
                            <FormRow
                                label="Email adress"
                                variant="wide"
                                :error="form.errors.email"
                            >
                                <Input type="email" id="email" placeholder="Email adress" v-model="form.email" />
                            </FormRow>
                            <FormRow
                                label="Current Password"
                                variant="wide"
                                :error="form.errors.current_password"
                            >
                                <Input type="password" id="current_password" placeholder="Current Password" v-model="form.current_password" />
                            </FormRow>
                            <FormRow
                                label="New Password"
                                variant="wide"
                                :error="form.errors.password"
                            >
                                <Input type="password" id="password" placeholder="Password" v-model="form.password" />
                            </FormRow>
                            <FormRow
                                label="New Password Confirmation"
                                variant="wide"
                                :error="form.errors.password_confirmation"
                            >
                                <Input type="password" id="password_confirmation" placeholder="Password" v-model="form.password_confirmation" />
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
            </main>
        </section>
    </DefaultLayout>
</template>

<script setup lang="ts">
import {useForm} from "@inertiajs/vue3";
import {PropType} from "@vue/runtime-dom";
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import {User} from "@/types/models/User";
import Sidebar from "@/components/Settings/Sidebar.vue";
import {inject} from "vue";
import { useToast } from '@/components/ui/toast/use-toast';
import {Card, CardContent, CardFooter, CardHeader, CardTitle} from "@/components/ui/card";
import {Button} from "@/components/ui/button";
import {Input} from "@/components/ui/input";
import FormRow from "@/components/Common/FormRow.vue";

const { toast } = useToast();
const emitter = inject('emitter');

const props = defineProps({
    user: {
        type: Object as PropType<User>,
        required: true,
    },
});

const form = useForm({
    email: props.user.email,
    current_password: '',
    password: '',
    password_confirmation: '',
});

function submit () {
    form.post(route('settings.global'), {
        onSuccess: () => {
            let snackbarItem: SnackbarItem = {
                type: TYPE_SUCCESSFUL,
                message: "Successfully saved.",
                autohide: true,
            };

            emitter.emit('snackbar:addItem', snackbarItem);
        },
        onError: () => {
            toast({
                title: "Could not save.",
                description: "Please try again later.",
                variant: "destructive"
            });
        },
        onFinish: () => {
            form.reset('password');
            form.reset('password_confirmation');
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

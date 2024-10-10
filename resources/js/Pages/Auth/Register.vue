<template>
    <Head title="Create an account" />

    <AuthLayout>
        <AuthHeader
            title="Create an account"
            subtitle="Enter your email below to create your account"
        />

        <form @submit.prevent="submit">
            <AuthFormItem
                label="Email adress"
                :error="form.errors.email"
            >
                <Input id="email" type="email" placeholder="john.doe@example.org" v-model="form.email" />
            </AuthFormItem>

            <AuthFormItem
                label="Password"
                :error="form.errors.password"
            >
                <Input id="password" type="password" placeholder="Password" v-model="form.password" />
            </AuthFormItem>

            <AuthFormItem
                label="Password confirmation"
                :error="form.errors.password_confirmation"
            >
                <Input id="password_confirmation" type="password" placeholder="Password" v-model="form.password_confirmation" />
            </AuthFormItem>

            <div class="actions">
                <Button variant="link" as-child>
                    <Link href="/login">
                        I already have an account
                    </Link>
                </Button>
                <Button>
                    <i class="ri-key-fill mr-2 text-lg"></i>
                    Register
                </Button>
            </div>
        </form>
    </AuthLayout>
</template>

<script setup lang="ts">
import {Head, Link} from '@inertiajs/vue3';
import AuthLayout from "@/Layouts/AuthLayout.vue";
import {useForm} from "@inertiajs/vue3";
import AuthHeader from "@/components/Auth/AuthHeader.vue";
import {Input} from "@/components/ui/input";
import AuthFormItem from "@/components/Common/FormRow.vue";
import {Button} from "@/components/ui/button";

const form = useForm({
    email: '',
    password: '',
    password_confirmation: '',
});

function submit () {
    form.post(route('register'), {
        onFinish: () => {
            form.reset('password');
            form.reset('password_confirmation');
        },
    });
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

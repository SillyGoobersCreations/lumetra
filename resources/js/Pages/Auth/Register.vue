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
                <Input
                    id="email"
                    type="email"
                    placeholder="john.doe@example.org"
                    v-model="form.email"
                />
            </AuthFormItem>

            <AuthFormItem
                label="Password"
                :error="form.errors.password"
            >
                <Input
                    id="password"
                    type="password"
                    placeholder="Password"
                    v-model="form.password"
                />
            </AuthFormItem>

            <AuthFormItem
                label="Password confirmation"
                :error="form.errors.password_confirmation"
            >
                <Input
                    id="password_confirmation"
                    type="password"
                    placeholder="Password"
                    v-model="form.password_confirmation"
                />
            </AuthFormItem>

            <div class="actions">
                <Button
                    variant="link"
                    as-child
                >
                    <Link href="/login"> I already have an account </Link>
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
import AuthLayout from '@/Layouts/AuthLayout.vue';
import AuthHeader from '@/components/Auth/AuthHeader.vue';
import AuthFormItem from '@/components/Common/FormRow.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: '',
    password_confirmation: '',
});

function submit() {
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
    @apply mt-4 flex justify-end gap-2;
}
</style>

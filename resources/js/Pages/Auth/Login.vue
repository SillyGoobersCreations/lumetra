<template>
    <Head title="Login" />

    <AuthLayout>
        <AuthHeader
            title="Log into an existing account"
            subtitle="Enter your credentials to login"
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

            <div class="items-top flex gap-x-2">
                <Checkbox
                    id="remember"
                    :checked="form.remember"
                    @update:checked="
                        (e) => {
                            form.remember = e;
                        }
                    "
                />
                <Label for="remember">Stay logged in</Label>
            </div>

            <div class="actions">
                <Button
                    variant="link"
                    as-child
                >
                    <Link href="/register"> Create a new account </Link>
                </Button>
                <Button>
                    <i class="ri-login-box-line mr-2 text-lg"></i>
                    Login
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
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

function submit() {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
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

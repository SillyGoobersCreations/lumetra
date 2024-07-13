<template>
    <AuthLayout>
        <form @submit.prevent="submit">
            <h1>Register</h1>
            <div class="item">
                <label for="email">Email address</label>
                <input type="email" id="email" placeholder="john.doe@example.org" v-model="form.email" />
                <div class="error" v-if="form.errors.email">{{ form.errors.email }}</div>
            </div>
            <div class="item">
                <label for="password">Password</label>
                <input type="password" id="password" placeholder="Password" v-model="form.password" />
                <div class="error" v-if="form.errors.password">{{ form.errors.password }}</div>
            </div>
            <div class="item">
                <label for="password_confirmation">Password Confirmation</label>
                <input type="password" id="password_confirmation" placeholder="Password" v-model="form.password_confirmation" />
                <div class="error" v-if="form.errors.password_confirmation">{{ form.errors.password_confirmation }}</div>
            </div>
            <div class="item actions">
                <Link href="/login" class="button transparent">
                    <i class="ri-login-box-line"></i>
                    <span>Login</span>
                </Link>
                <button class="primary">
                    <i class="ri-key-fill"></i>
                    <span>Register</span>
                </button>
            </div>
        </form>
    </AuthLayout>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import AuthLayout from "@/Layouts/AuthLayout.vue";
import {useForm} from "@inertiajs/vue3";

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
    display: flex;
    flex-direction: column;
    gap: 15px;
}
h1 {
    font-size: 1.5rem;
    margin-bottom: 15px;
}
.item {
    display: flex;
    gap: 10px;

    &:not(.actions) {
        flex-direction: column;
        gap: 5px;
    }

    &.one-row {
        flex-direction: row;
        align-items: center;

        & label {
            flex-grow: 1;
        }
    }
    & .error {
        color: rgb(var(--color-danger-500));
        font-size: 0.85rem;
    }
    &.actions {
        margin-top: 15px;
        justify-content: flex-end;
    }
}
</style>

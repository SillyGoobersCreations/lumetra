<template>
    <AuthLayout>
        <div class="item">
            <label for="email">Email address</label>
            <input type="email" id="email" placeholder="john.doe@example.org" v-model="form.email" />
        </div>
        <div class="item">
            <label for="password">Password</label>
            <input type="password" id="password" placeholder="Password" v-model="form.password" />
        </div>
        <div class="item one-row">
            <label for="remember">Stay logged in</label>
            <input id="remember" type="checkbox" class="toggle" v-model="form.remember" />
        </div>
        <div class="item actions">
            <Link href="/register" class="button transparent">
                <i class="ri-key-fill"></i>
                <span>Register</span>
            </Link>
            <button class="primary">
                <i class="ri-login-box-line"></i>
                <span>Login</span>
            </button>
        </div>
    </AuthLayout>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import AuthLayout from "@/Layouts/AuthLayout.vue";
import {useForm} from "@inertiajs/vue3";

const form = useForm({
    email: '',
    password: '',
    remember: false,
});
</script>

<style lang="scss" scoped>
* > :has(.item) {
    gap: 15px;
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

    &.actions {
        justify-content: flex-end;
    }
}
</style>

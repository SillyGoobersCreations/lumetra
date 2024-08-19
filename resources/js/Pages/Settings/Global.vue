<template>
    <DefaultLayout>
        <section class="attendee-settings">
            <Sidebar :attendees="user.attendees" />
            <div>
                <Box>
                    <form @submit.prevent="submit">
                        <h1>Security</h1>
                        <div class="item">
                            <label for="email">Email address</label>
                            <input type="email" id="email" placeholder="john.doe@example.org" v-model="form.email" />
                            <div class="error" v-if="form.errors.email">{{ form.errors.email }}</div>
                        </div>
                        <div class="item">
                            <label for="current_password">Current Password</label>
                            <input type="password" id="current_password" placeholder="Current Password" v-model="form.current_password" />
                            <div class="error" v-if="form.errors.current_password">{{ form.errors.current_password }}</div>
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
                            <button class="primary">
                                <span class="ri-save-2-line"></span>
                                <span>Save</span>
                            </button>
                        </div>
                    </form>
                </Box>
            </div>
        </section>
    </DefaultLayout>
</template>

<script setup lang="ts">
import {Link, useForm} from "@inertiajs/vue3";
import Box from "@/Components/Common/Box.vue";
import {PropType} from "@vue/runtime-dom";
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import {User} from "@/types/models/User";
import Sidebar from "@/Components/Settings/Sidebar.vue";
import AuthLayout from "@/Layouts/AuthLayout.vue";

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
        onFinish: () => {
            form.reset('password');
            form.reset('password_confirmation');
        },
    });
}
</script>

<style lang="scss" scoped>
.attendee-settings {
    display: grid;
    grid-template-columns: 350px 1fr;
    gap: 15px;
}
.attendee-settings > div {
    display: flex;
    flex-direction: column;
    gap: 15px;
}
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

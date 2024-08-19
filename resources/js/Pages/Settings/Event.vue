<template>
    <EventLayout :event="event">
        <section class="attendee-settings">
            <Sidebar :attendees="user.attendees" />
            <div>
                <Box>
                    <form @submit.prevent="submitName">
                        <h1>Name</h1>
                        <div class="item">
                            <label for="handle">Handle</label>
                            <input type="text" id="handle" placeholder="@johndoe" v-model="nameForm.handle" />
                            <div class="error" v-if="nameForm.errors.handle">{{ nameForm.errors.handle }}</div>
                        </div>
                        <div class="item">
                            <label for="first_name">First name</label>
                            <input type="text" id="first_name" placeholder="John" v-model="nameForm.first_name" />
                            <div class="error" v-if="nameForm.errors.first_name">{{ nameForm.errors.first_name }}</div>
                        </div>
                        <div class="item">
                            <label for="last_name">Last name</label>
                            <input type="text" id="last_name" placeholder="Doe" v-model="nameForm.last_name" />
                            <div class="error" v-if="nameForm.errors.last_name">{{ nameForm.errors.last_name }}</div>
                        </div>
                        <div class="item actions">
                            <button class="primary">
                                <span class="ri-save-2-line"></span>
                                <span>Save</span>
                            </button>
                        </div>
                    </form>
                </Box>
                <Box>
                    <form @submit.prevent="submitAvatar">
                        <h1>Avatar</h1>
                        <!-- TODO -->
                        <div class="item">
                            <label for="avatar">Avatar</label>
                            <input type="file" id="avatar" placeholder="Doe" />
                            <div class="error" v-if="avatarForm.errors.avatar">{{ avatarForm.errors.avatar }}</div>
                        </div>
                        <div class="item actions">
                            <button class="primary">
                                <span class="ri-save-2-line"></span>
                                <span>Save</span>
                            </button>
                        </div>
                    </form>
                </Box>
                <Box>
                    <form @submit.prevent="submitDescription">
                        <h1>Description</h1>
                        <div class="item">
                            <label for="description">Description</label>
                            <textarea v-model="descriptionForm.description"></textarea>
                            <div class="error" v-if="descriptionForm.errors.description">{{ descriptionForm.errors.description }}</div>
                        </div>
                        <div class="item">
                            <label for="job_company">Company</label>
                            <input type="text" id="job_company" v-model="descriptionForm.job_company" />
                            <div class="error" v-if="descriptionForm.errors.job_company">{{ descriptionForm.errors.job_company }}</div>
                        </div>
                        <div class="item">
                            <label for="job_position">Position</label>
                            <input type="text" id="job_position" v-model="descriptionForm.job_position" />
                            <div class="error" v-if="descriptionForm.errors.job_position">{{ descriptionForm.errors.job_position }}</div>
                        </div>
                        <div class="item actions">
                            <button class="primary">
                                <span class="ri-save-2-line"></span>
                                <span>Save</span>
                            </button>
                        </div>
                    </form>
                </Box>
                <Box v-if="attendee.confirmed">
                    <h1>Confirmation</h1>
                    <p>Your attendance was confirmed.</p>
                </Box>
                <Box v-if="!attendee.confirmed">
                    <form @submit.prevent="submitConfirmation">
                        <h1>Confirmation</h1>
                        <div class="item">
                            <label for="confirmation_key">Confirmation Key</label>
                            <input type="text" id="confirmation_key" v-model="confirmationForm.confirmation_key" />
                            <div class="error" v-if="confirmationForm.errors.confirmation_key">{{ confirmationForm.errors.confirmation_key }}</div>
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
    </EventLayout>
</template>

<script setup lang="ts">
import {Link, useForm} from "@inertiajs/vue3";
import EventLayout from "@/Layouts/EventLayout.vue";
import Box from "@/Components/Common/Box.vue";
import {PropType} from "@vue/runtime-dom";
import {Event} from "@/types/models/Event";
import {Attendee} from "@/types/models/Attendee";
import {User} from "@/types/models/User";
import Sidebar from "@/Components/Settings/Sidebar.vue";

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
    handle: props.attendee?.handle,
    first_name: props.attendee?.first_name,
    last_name: props.attendee?.last_name,
});

const avatarForm = useForm({
    avatar: "",
});

const descriptionForm = useForm({
    description: props.attendee?.description,
    job_company: props.attendee?.job_company,
    job_position: props.attendee?.job_position,
});

const confirmationForm = useForm({
    confirmation_key: "",
});

function submitName() {

}

function submitAvatar() {

}

function submitDescription() {

}

function submitConfirmation() {

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

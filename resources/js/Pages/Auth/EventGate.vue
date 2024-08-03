<template>
    <AuthLayout>
        <div class="event-gate">
            <div class="events">
                <Link
                    :key="attendee.id"
                    v-for="attendee in attendees"
                    :href="'/'"
                    class="button attendee-button"
                >
                    <Avatar :attendee="attendee" />
                    <div class="meta">
                        <span>{{ attendee.name_full }}</span>
                        <span>{{ attendee.event?.title }}</span>
                    </div>
                </Link>
            </div>
            <Link
                :href="route('index')"
                class="button"
            >
                <i class="ri-home-5-line"></i>
                <span>Frontpage</span>
            </Link>
        </div>
    </AuthLayout>
</template>

<script setup lang="ts">
import {Link, usePage} from '@inertiajs/vue3';
import AuthLayout from "@/Layouts/AuthLayout.vue";
import {computed} from "vue";
import Avatar from "@/Components/Common/Avatar.vue";

const page = usePage();
const user = computed(() => page.props.auth.user);
const attendees = computed(() => page.props.auth.attendees);
</script>

<style lang="scss" scoped>
.event-gate {
    display: flex;
    flex-direction: column;
    gap: 15px;

    & .events {
        display: flex;
        flex-direction: column;
        gap: 5px;

        & .attendee-button {
            display: grid;
            grid-template-columns: auto 1fr;
            justify-content: flex-start;
            align-items: center;
            height: 60px;
            gap: 10px;

            & .meta {
                display: flex;
                flex-direction: column;
                gap: 5px;

                & span:nth-child(2) {
                    font-size: 0.75rem;
                    color: rgba(var(--color-base-500));
                }
            }
        }
    }
}
</style>

<template>
    <Head title="Find, chat, meet!" />

    <DefaultLayout>
        <section class="page-frontpage">
            <div class="welcome">
                <h1>Welcome to this Lumetra instance!</h1>
                <p>Lumetra is an open-source conference meetup platform.</p>
            </div>
            <div class="features">
                <Card class="feature-card">
                    <CardContent class="p-6">
                        <i class="ri-group-2-line"></i>
                        <h2>Find, chat, meet!</h2>
                        <p>Find other attendees with ease, chat with them and invite them to dedicated rooms or hangout places in the event.</p>
                    </CardContent>
                </Card>
                <Card class="feature-card">
                    <CardContent class="p-6">
                        <i class="ri-link"></i>
                        <h2>Go public!</h2>
                        <p>Create your own attendee profile and link your social media platforms to make yourself known.</p>
                    </CardContent>
                </Card>
                <Card class="feature-card">
                    <CardContent class="p-6">
                        <i class="ri-battery-low-line"></i>
                        <h2>Batteries included!</h2>
                        <p>We created Lumetra to be an easy to deploy multi-event platform for in-person events.</p>
                    </CardContent>
                </Card>
                <Card class="feature-card">
                    <CardContent class="p-6">
                        <i class="ri-service-fill"></i>
                        <h2>Open-source, 100% free!</h2>
                        <p>Lumetra was created for <strong>GodotCon</strong>, the developer conference by the Godot Foundation. As with the Godot Engine itself, Lumetra was developed to be fully open-source.</p>
                    </CardContent>
                    <CardFooter>
                        <Button
                            as-child
                            variant="secondary"
                        >
                            <a
                                href="https://github.com/SillyGoobersCreations/lumetra"
                                target="_blank"
                            >
                                <span>Lumetra on Github</span>
                            </a>
                        </Button>
                    </CardFooter>
                </Card>
            </div>

            <div
                class="contributors"
                v-if="githubContributors.length > 0"
            >
                <div class="label">Made with contributions by</div>
                <div class="avatars">
                    <a
                        v-for="contributor in githubContributors"
                        :key="contributor.id"
                        :href="contributor.html_url"
                        target="_blank"
                    >
                        <Avatar>
                            <AvatarImage :src="contributor.avatar_url" />
                        </Avatar>
                    </a>
                </div>
            </div>
        </section>
    </DefaultLayout>
</template>

<script setup lang="ts">
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { Avatar, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardFooter } from '@/components/ui/card';
import { Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

const githubContributors = ref([]);

async function loadContributors() {
    let response = await fetch('https://api.github.com/repos/SillyGoobersCreations/lumetra/contributors');
    githubContributors.value = await response.json();
}

onMounted(() => {
    loadContributors();
});
</script>

<style lang="scss" scoped>
.page-frontpage {
    @apply flex flex-col gap-4;

    & .welcome {
        @apply flex flex-col rounded-md bg-accent p-6 py-10 text-accent-foreground;

        & h1 {
            @apply text-center text-lg font-bold;
        }
        & p {
            @apply text-center text-muted-foreground;
        }
    }

    & .features {
        @apply flex flex-col gap-2 md:grid md:grid-cols-2;

        & .feature-card {
            & i {
                @apply mb-4 block text-3xl;
            }
            & h2 {
                @apply mb-2 font-bold;
            }
            & p {
                @apply text-muted-foreground;
            }
        }
    }

    & .contributors {
        @apply mt-8 flex flex-col flex-wrap items-center gap-2;

        & .label {
            @apply text-muted-foreground;
        }
        & .avatars {
            @apply flex gap-2;
        }
    }
}
</style>

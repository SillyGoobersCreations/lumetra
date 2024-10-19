<template>
    <Head title="Notes" />

    <AdminLayout
        title="Notes"
        :event="event"
    >
        <template #header>
            <AddDialog :event="event" />
        </template>

        <section class="page-note-overview">
            <Card
                v-for="note in event.notes"
                :key="note.id"
            >
                <CardHeader>
                    <CardTitle class="flex items-center gap-2">
                        <span>{{ note.title }}</span>
                        <Badge variant="secondary">{{ moment(note.created_at).fromNow() }}</Badge>
                        <Badge v-if="note.sticky">Sticky</Badge>
                    </CardTitle>
                </CardHeader>
                <CardContent>
                    {{ note.text }}
                </CardContent>
                <CardFooter class="flex gap-2">
                    <Button
                        variant="secondary"
                        v-if="!note.sticky"
                    >
                        <Link :href="route('events.admin.notes.setSticky', { eventId: event.id, noteId: note.id, sticky: 'true' })">
                            <span>Make Sticky</span>
                        </Link>
                    </Button>
                    <Button
                        variant="secondary"
                        v-if="note.sticky"
                    >
                        <Link :href="route('events.admin.notes.setSticky', { eventId: event.id, noteId: note.id, sticky: 'false' })">
                            <span>Make Unsticky</span>
                        </Link>
                    </Button>
                    <Button
                        variant="destructive"
                        as-child
                    >
                        <Link :href="route('events.admin.notes.delete', { eventId: event.id, noteId: note.id })">
                            <span>Delete</span>
                        </Link>
                    </Button>
                </CardFooter>
            </Card>
        </section>
    </AdminLayout>
</template>

<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import AddDialog from '@/components/Admin/Note/AddDialog.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Event } from '@/types/models/Event';
import { Head, Link } from '@inertiajs/vue3';
import moment from 'moment/moment';
import { PropType } from 'vue';

defineProps({
    event: {
        type: Object as PropType<Event>,
        required: true,
    },
});
</script>

<style lang="scss" scoped>
.page-note-overview {
    @apply flex flex-col items-center gap-4 p-5;

    & > * {
        @apply w-full max-w-3xl;
    }
}
</style>

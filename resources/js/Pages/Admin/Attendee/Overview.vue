<template>
    <AdminLayout title="Attendees" :event="event">
        <section class="page-attendee">
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead class="w-[320px]">ID</TableHead>
                        <TableHead>Name</TableHead>
                        <TableHead>Handle</TableHead>
                        <TableHead>Email</TableHead>
                        <TableHead class="w-[110px]">Confirmed</TableHead>
                        <TableHead class="w-[110px]">Organizer</TableHead>
                        <TableHead class="w-[110px]">Actions</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow
                        v-for="attendee in event.attendees"
                        :key="attendee.id"
                    >
                        <TableCell><div class="line-clamp-1">{{ attendee.id }}</div></TableCell>
                        <TableCell><div class="line-clamp-1">{{ attendee.name_full }}</div></TableCell>
                        <TableCell><div class="line-clamp-1">{{ attendee.handle }}</div></TableCell>
                        <TableCell><div class="line-clamp-1">{{ attendee.user.email }}</div></TableCell>
                        <TableCell>
                            <Badge v-if="attendee.confirmed" variant="secondary">Yes</Badge>
                            <Badge v-else variant="destructive">No</Badge>
                        </TableCell>
                        <TableCell>
                            <Badge v-if="attendee.role === 'organizer'" variant="default">Yes</Badge>
                            <Badge v-else variant="secondary">No</Badge>
                        </TableCell>
                        <TableCell class="flex gap-2">
                            <DetailDialog
                                :event="event"
                                :attendee="attendee"
                            >
                                <Button
                                    variant="secondary"
                                    size="xs"
                                >
                                    <i class="ri-eye-line mr-2 text-lg"></i>
                                    View
                                </Button>
                            </DetailDialog>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </section>
    </AdminLayout>
</template>

<script setup lang="ts">
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {PropType} from "@vue/runtime-dom";
import {Event} from "@/types/models/Event";
import {Table, TableBody, TableCell, TableHead, TableHeader, TableRow} from "@/components/ui/table";
import {Attendee} from "@/types/models/Attendee";
import {Badge} from "@/components/ui/badge";
import {Button} from "@/components/ui/button";
import {
    Dialog,
    DialogContent,
    DialogDescription, DialogFooter,
    DialogHeader, DialogScrollContent,
    DialogTitle,
    DialogTrigger
} from "@/components/ui/dialog";
import {Card, CardContent, CardFooter, CardHeader, CardTitle} from "@/components/ui/card";
import FormRow from "@/components/Common/FormRow.vue";
import moment from "moment/moment";
import {Link} from "@inertiajs/vue3";
import DetailDialog from "@/components/Admin/Attendee/DetailDialog.vue";

defineProps({
    event: {
        type: Object as PropType<Event>,
        required: true,
    },
});
</script>

<style lang="scss" scoped>
.page-attendee {
    @apply flex flex-col gap-4;
}
</style>

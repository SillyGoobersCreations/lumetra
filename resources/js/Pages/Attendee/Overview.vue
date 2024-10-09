<template>
    <Head title="Attendees" />

    <EventLayout :event="event">
        <section class="attendee-directory">
            <Card>
                <CardContent class="pt-6 flex gap-2">
                    <Input type="search" v-model="searchQuery" @keyup.enter="search" placeholder="Search..." class="grow" />
                    <Button @click="search">
                        <i class="ri-search-line mr-2 text-lg"></i>
                        <span>Search</span>
                    </Button>
                </CardContent>
            </Card>
            <Card v-if="loading">
                <CardContent class="pt-6 flex items-center justify-center py-16">
                    <LoadingCircle />
                </CardContent>
            </Card>
            <template v-else>
                <div class="sorting">
                    <Label>{{ results.length }} results</Label>

                    <div class="actions">
                        <Select v-model="searchSortBy">
                            <SelectTrigger class="w-[180px]">
                                <SelectValue placeholder="Select...">{{ searchSortFields[searchSortBy] }}</SelectValue>
                            </SelectTrigger>
                            <SelectContent>
                                <SelectLabel>Sort by</SelectLabel>
                                <SelectItem
                                    v-for="(value, key) in searchSortFields"
                                    :key="key"
                                    :value="key"
                                >{{ value }}</SelectItem>
                            </SelectContent>
                        </Select>

                        <Button
                            v-if="searchSortType != 'DESC'"
                            @click="searchSortType = 'DESC'"
                            variant="secondary"
                        >
                            <i class="ri-sort-desc mr-2 text-lg"></i>
                            <span>Descending</span>
                        </Button>
                        <Button
                            v-if="searchSortType != 'ASC'"
                            @click="searchSortType = 'ASC'"
                            variant="secondary"
                        >
                            <i class="ri-sort-asc mr-2 text-lg"></i>
                            <span>Ascending</span>
                        </Button>
                    </div>
                </div>
                <div class="results">
                    <AttendeeButton
                        v-for="attendee in results"
                        :attendee="attendee"
                    />
                </div>
            </template>
        </section>
    </EventLayout>
</template>

<script setup lang="ts">
import EventLayout from "@/Layouts/EventLayout.vue";
import AttendeeButton from "@/components/Event/AttendeeButton.vue";
import {ref, onMounted} from "vue";
import LoadingCircle from "@/components/Common/LoadingCircle.vue";
import { watch } from "vue";
import {Card, CardContent} from "@/components/ui/card";
import {Input} from "@/components/ui/input";
import {Button} from "@/components/ui/button";
import {Select, SelectContent, SelectItem, SelectLabel, SelectTrigger, SelectValue} from "@/components/ui/select";
import {Label} from "@/components/ui/label";
import {PropType} from "@vue/runtime-dom";
import {Event} from "@/types/models/Event";
import {Head} from "@inertiajs/vue3";

const props = defineProps({
    event: {
        type: Object as PropType<Event>,
        required: true,
    },
});

const loading = ref(true);
const results = ref([]);
const searchQuery = ref("");
const searchSortBy = ref("updated_at");
const searchSortType = ref("DESC");

const searchSortFields = {
    handle: "Handle",
    first_name: "First name",
    last_name: "Last name",
    updated_at: "Last activity",
    created_at: "Join date",
};

async function search() {
    results.value = [];
    loading.value = true;

    // This Promise extends the API call to take at least 0.5s to not create a sudden flash of UI
    const prematureEnd = new Promise(resolve => setTimeout(resolve, 500));
    const apiCall = fetch(route('events.attendees.search', {
        eventId: props.event.id,
        query: searchQuery.value,
        sortBy: searchSortBy.value,
    })).then(response => response.json());

    const [apiResult] = await Promise.all([apiCall, prematureEnd]);

    console.log(props.event.id);

    results.value = apiResult;
    loading.value = false;
}

watch(() => [searchSortType.value, searchSortBy.value], () => {
    search();
});

onMounted(() => {
    search();
});
</script>

<style lang="scss" scoped>
.attendee-directory {
    @apply flex flex-col gap-4;

    & .sorting {
        @apply flex items-center gap-2 justify-between;

        & .actions {
            @apply flex items-center gap-2;
        }
    }
    & .results {
        @apply flex flex-col sm:grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 gap-4;
    }
}
</style>

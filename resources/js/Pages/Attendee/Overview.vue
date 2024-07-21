<template>
    <EventLayout :event="event">
        <section class="attendee-directory">
            <Box class="search">
                <input type="search" v-model="searchQuery" @keyup.enter="search" placeholder="Search..." />
                <button class="primary" @click="search">
                    <i class="ri-search-line"></i>
                    <span>Search</span>
                </button>
            </Box>
            <Box class="loading" v-if="loading">
                <LoadingCircle />
            </Box>
            <template v-else>
                <div class="sorting">
                    <span>{{ results.length }} results</span>

                    <div class="actions">
                        <div class="select">
                            <select v-model="searchSortBy">
                                <option value="handle">Handle</option>
                                <option value="first_name">First name</option>
                                <option value="last_name">First name</option>
                                <option value="updated_at">Last activity</option>
                                <option value="created_at">Join date</option>
                            </select>
                        </div>
                        <button
                            v-if="searchSortType != 'DESC'"
                            @click="searchSortType = 'DESC'"
                            class="primary"
                        >
                            <i class="ri-sort-desc"></i>
                        </button>
                        <button
                            v-if="searchSortType != 'ASC'"
                            @click="searchSortType = 'ASC'"
                            class="primary"
                        >
                            <i class="ri-sort-asc"></i>
                        </button>
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
import AttendeeButton from "@/Components/Event/AttendeeButton.vue";
import {ref, onMounted} from "vue";
import Box from "@/Components/Common/Box.vue";
import LoadingCircle from "@/Components/Common/LoadingCircle.vue";
import { watch } from "vue";

const props = defineProps({
    event: {
        type: Object,
        required: true,
    },
});

const loading = ref(true);
const results = ref([]);
const searchQuery = ref("");
const searchSortBy = ref("updated_at");
const searchSortType = ref("DESC");

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
    display: flex;
    flex-direction: column;
    gap: 15px;

    & .search {
        display: flex;
        flex-direction: row;
        gap: 10px;

        & input {
            flex-grow: 1;
        }
    }
    & .sorting {
        display: flex;
        align-items: center;
        gap: 10px;

        & > span {
            flex-grow: 1;
        }
        & .actions {
            display: flex;
            gap: 5px;
        }
    }
    & .results {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
    }
    & .loading {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 75px 0;
    }
}
</style>

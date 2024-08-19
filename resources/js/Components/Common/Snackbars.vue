<template>
    <div class="snackbar-container">
        <TransitionGroup
            name="list"
        >
            <div
                v-for="(item, n) in items"
                :key="n"
                :class="`item type-${item.type}`"
            >
                <span>{{ item.message }}</span>
                <div class="actions">
                    <button class="transparent" v-if="!item.autohide" @click="removeItem(item)">
                        <i class="ri-close-line"></i>
                    </button>
                </div>
            </div>
        </TransitionGroup>
    </div>
</template>

<script lang="ts" setup>
import {inject, onMounted, onUnmounted, ref} from "vue";
const emitter = inject('emitter');

const TYPE_BASE = "base";
const TYPE_DANGER = "danger";
const TYPE_SUCCESSFUL = "successful";

type SnackbarItem = {
    type: string,
    message: string,
    autohide: boolean,
}

const items = ref<SnackbarItem[]>([]);

function addItem(item: SnackbarItem) {
    items.value.push(item);

    if(item.autohide) {
        setTimeout(() => {
            removeItem(item);
        }, 1000);
    }
}

function removeItem(item: SnackbarItem) {
    const index = items.value.indexOf(item);
    if(index !== -1) {
        items.value.splice(index, 1);
    }
}

onMounted(() => {
    emitter.on('snackbar:addItem', (item: SnackbarItem) => {
        addItem(item);
    });
});
onUnmounted(() => {
    emitter.off('snackbar:addItem');
});
</script>

<style lang="scss" scoped>
.snackbar-container {
    position: fixed;
    inset: 0;
    z-index: 1000;
    pointer-events: none;
    display: flex;
    flex-direction: column-reverse;
    justify-content: flex-start;
    align-items: center;
    padding: 25px;
    gap: 5px;

    & .item {
        width: 100%;
        border-radius: 5px;
        max-width: 650px;
        pointer-events: all;
        display: flex;
        gap: 10px;
        padding: 5px;
        align-items: center;
        min-height: 50px;

        & > span {
            padding: 10px 15px;
            flex-grow: 1;
        }

        &.type-base {
            background: rgb(var(--color-base-800));
            color: rgb(var(--color-base-200));

            & button {
                color: rgb(var(--color-base-200));

                &:hover {
                    background: rgb(var(--color-base-950));
                }
            }
        }
        &.type-danger {
            background: rgb(var(--color-danger-600));
            color: rgb(var(--color-danger-100));

            & button {
                color: rgb(var(--color-danger-100));

                &:hover {
                    background: rgb(var(--color-danger-700));
                }
            }
        }
        &.type-successful {
            background: rgb(var(--color-successful-600));
            color: rgb(var(--color-successful-100));

            & button {
                color: rgb(var(--color-successful-100));

                &:hover {
                    background: rgb(var(--color-successful-700));
                }
            }
        }
    }
}
</style>

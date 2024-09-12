<template>
    <dialog ref="dialog" :class="`size-${size}`" @click.self="backdropClose">
        <header>
            <div class="title">
                <h1 v-if="title">{{ title }}</h1>
            </div>
            <div class="actions">
                <slot name="actions" />
                <button :disabled="!canClose" @click="close" v-if="withClose">
                    <i class="ri-close-line"></i>
                </button>
            </div>
        </header>
        <main>
            <slot />
        </main>
    </dialog>
</template>

<script setup lang="ts">
import {ref} from "vue";

const dialog = ref<HTMLDialogElement | null>(null);
const emit = defineEmits(['closed']);

const props = defineProps({
    title: {
        type: [String, Boolean],
        default: false,
    },
    withClose: {
        type: Boolean,
        default: true,
    },
    canClose: {
        type: Boolean,
        default: true,
    },
    size: {
        type: String,
        default: 'm',
        validator: (value: string) => ['s', 'm', 'l'].includes(value),
    },
});

function open() {
    dialog.value?.showModal();
}
function backdropClose() {
    if (!(props.withClose && props.canClose)) return;

    close();
}
function close() {
    dialog.value?.close();
    emit('closed');
}

defineExpose({
    open,
    close,
});
</script>

<style lang="scss" scoped>
dialog {
    transition: display 0.2s allow-discrete, overlay 0.2s allow-discrete, opacity 0.15s ease-in-out, transform 0.2s ease-in-out;
    opacity: 0;
    transform: translateY(50px);
    background: rgb(var(--color-base-50));
    border: 0;
    border-radius: 10px;
    flex-direction: column;
    overflow: hidden;
    width: calc(100% - 40px);
    max-height: calc(100% - 40px);
    padding: 0;
    box-shadow: 0 4px 20px rgba(0,0,0,0.4);

    &[open] {
        opacity: 1;
        transform: translateY(0px);
        display: flex;

        @starting-style {
            opacity: 0;
            transform: translateY(50px);
        }
    }

    &::backdrop {
        padding: 0;
        background: rgba(0,0,0,0.4);
        backdrop-filter: blur(4px);
    }

    & header {
        min-height: 61px;
        padding: 10px;
        border-bottom: 1px solid rgb(var(--color-base-200));
        display: grid;
        align-items: center;
        grid-template-columns: 1fr auto;
        gap: 15px;

        & h1 {
            font-size: 1.25rem;
            padding-left: 10px;
        }
        & .actions {
            display: flex;
            gap: 10px;
            align-items: center;
            justify-content: flex-end;
        }
    }
    & main {
        overflow-y: auto;
        padding: 20px;
        flex-grow: 1;
    }
}

@media screen and (max-width: 900px) {
    dialog {
        max-width: 100dvw;
        width: 100%;
        max-height: 100dvh;
        height: calc(100% - 50px);
        margin-top: 50px;
    }
}
@media screen and (min-width: 901px) {
    dialog {
        &.size-s { max-width: 600px; }
        &.size-m { max-width: 900px; }
        &.size-l { max-width: calc(100% - 40px); }
    }
}
</style>

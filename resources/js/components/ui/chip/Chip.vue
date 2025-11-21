<script setup lang="ts">
import { reactiveOmit } from '@vueuse/core';
import type { PrimitiveProps } from 'reka-ui';
import { Primitive } from 'reka-ui';
import { HTMLAttributes } from 'vue';

const props = defineProps<
    PrimitiveProps & {
        variant?:
            | 'default'
            | 'primary'
            | 'secondary'
            | 'destructive'
            | 'outline';
        class?: HTMLAttributes['class'];
    }
>();

const delegatedProps = reactiveOmit(props, 'class');
</script>

<template>
    <Primitive
        data-slot="chip"
        :class="['base', props.variant ?? 'default', props.class]"
        v-bind="delegatedProps"
    >
        <slot />
    </Primitive>
</template>

<style scoped>
.base {
    display: inline-flex;
    align-items: center;
    font-size: 0.875rem;
    line-height: 1rem;
    font-weight: 500;
    user-select: none;
    border-radius: 9999px;
    padding: 0.25rem 0.75rem;
}

.default {
    background-color: var(--default-chip-bg);
    color: var(--default-chip-text);
}

.primary {
    background-color: var(--primary-chip-bg);
    color: var(--primary-chip-text);
}

.secondary {
    background-color: var(--secondary-chip-bg);
    color: var(--secondary-chip-text);
}

.destructive {
    background-color: var(--destructive-chip-bg);
    color: var(--destructive-chip-text);
}

.outline {
    background-color: var(--outline-chip-bg);
    color: var(--outline-chip-text);
}
</style>

<script setup lang="ts">
import type { ICellRendererParams } from 'ag-grid-community';

interface MyCellRendererParams<T> extends ICellRendererParams<T> {
    onClick: (data: T) => void;
}

type Props<T> = {
    params: MyCellRendererParams<T>;
};

const { params } = defineProps<Props<any>>();

const oClick = () => {
    params.onClick(params.data);
};
</script>

<template>
    <button
        @click="oClick"
        class="rounded border border-gray-300 bg-transparent px-3 py-1.5 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50"
    >
        Edit
    </button>
</template>

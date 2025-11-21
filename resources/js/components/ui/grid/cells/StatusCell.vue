<script setup lang="ts">
import { Chip } from '@/components/ui/chip';
import { OrderHistory } from '@/types';
import type { ICellRendererParams } from 'ag-grid-community';
import { computed } from 'vue';

type Props = {
    params: ICellRendererParams<{ status: OrderHistory['status'] }>;
};

const { params } = defineProps<Props>();
const variant = computed(() => {
    switch (params.data?.status) {
        case 'shipped':
            return 'outline';
        case 'pending':
            return 'secondary';
        case 'canceled':
            return 'destructive';
        case 'completed':
            return 'primary';
        default:
            return 'default';
    }
});
</script>

<template>
    <div>
        <Chip :variant="variant">{{ params.data?.status }}</Chip>
    </div>
</template>

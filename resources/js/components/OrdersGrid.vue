<script setup lang="ts">
import { EditButton, StatusCell } from '@/components/ui/grid/cells';
import type { Order } from '@/types';
import { router } from '@inertiajs/vue3';
import { AutoSizeStrategy, ColDef } from 'ag-grid-community';
import { AgGridVue } from 'ag-grid-vue3';
import { ref } from 'vue';

const { orders } = defineProps<{
    orders: Order[];
}>();

const autoSizeStrategy: AutoSizeStrategy = {
    type: 'fitGridWidth',
    defaultMinWidth: 150,
};
// Column Definitions: Defines the columns to be displayed.
const colDefs = ref<ColDef[]>([
    { filter: true, field: 'user.name', headerName: 'Name' },
    { filter: true, field: 'user.email', headerName: 'Email' },
    {
        filter: true,
        field: 'order_date',
        headerName: 'Order Date',
        cellDataType: 'dateTimeString',
    },
    {
        filter: true,
        field: 'status',
        headerName: 'Status',
        cellRenderer: StatusCell,
    },
    {
        filter: false,
        cellRenderer: EditButton,
        cellRendererParams: {
            onClick: (order: Order) => {
                router.visit(`/orders/${order.id}`);
            },
        },
        maxWidth: 95,
        colId: 'actions',
        pinned: 'right',
        resizable: false,
    },
]);
</script>

<template>
    <AgGridVue
        style="height: 100%"
        :autoSizeStrategy="autoSizeStrategy"
        :rowData="orders"
        :columnDefs="colDefs"
    ></AgGridVue>
</template>

<style scoped></style>

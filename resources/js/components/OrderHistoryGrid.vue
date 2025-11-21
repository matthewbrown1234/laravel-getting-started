<script setup lang="ts">
import { EditButton, StatusCell } from '@/components/ui/grid/cells';
import type { OrderHistory } from '@/types';
import { ColDef, type RowClickedEvent } from 'ag-grid-community';
import { AgGridVue } from 'ag-grid-vue3';
import { ref } from 'vue';

const { orderHistoryList } = defineProps<{
    orderHistoryList: OrderHistory[];
    onOrderSelection: (event: RowClickedEvent<OrderHistory>) => void;
}>();

// Column Definitions: Defines the columns to be displayed.
const colDefs = ref<ColDef[]>([
    { filter: true, field: 'id', headerName: 'ID', width: 300 },
    {
        filter: true,
        field: 'order_date',
        headerName: 'Order Date',
        width: 300,
        cellDataType: 'dateTimeString',
    },
    {
        filter: true,
        field: 'status',
        headerName: 'Status',
        width: 300,
        cellRenderer: StatusCell,
    },
    {
        filter: false,
        cellRenderer: EditButton,
        width: 70,
    },
]);
</script>

<template>
    <AgGridVue
        style="height: 100%"
        :onRowClicked="onOrderSelection"
        :rowData="orderHistoryList"
        :columnDefs="colDefs"
    ></AgGridVue>
</template>

<style scoped></style>

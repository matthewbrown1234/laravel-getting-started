<script setup lang="ts">
import type { OrderHistory } from '@/types';
import { type RowClickedEvent, RowSelectionOptions } from 'ag-grid-community';
import { AgGridVue } from 'ag-grid-vue3';
import { ref } from 'vue';

const { orderHistoryList } = defineProps<{
    orderHistoryList: OrderHistory[];
    onOrderSelection: (event: RowClickedEvent<OrderHistory>) => void;
}>();

// Column Definitions: Defines the columns to be displayed.
const colDefs = ref([
    { filter: true, field: 'id', headerName: 'ID', width: 80 },
    { filter: true, field: 'order_date', headerName: 'Order Date', width: 300 },
    { filter: true, field: 'status', headerName: 'Status', width: 100 },
]);

const rowSelection: RowSelectionOptions = {
    mode: 'singleRow',
    enableClickSelection: true,
};
</script>

<template>
    <AgGridVue
        style="height: 100%"
        :onRowClicked="onOrderSelection"
        :rowSelection="rowSelection"
        :rowData="orderHistoryList"
        :columnDefs="colDefs"
    ></AgGridVue>
</template>

<style scoped></style>

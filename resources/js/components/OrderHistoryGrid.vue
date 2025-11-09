<script setup lang="ts">
import { AgGridVue } from 'ag-grid-vue3';
import { ref } from 'vue';
import type { OrderHistory } from '@/types';

defineProps<{
    orderHistoryList: OrderHistory[];
}>();

// Column Definitions: Defines the columns to be displayed.
const colDefs = ref([
    { filter: true, field: 'id', headerName: 'ID', width: 80 },
    { filter: true, field: 'order_date', headerName: 'Order Date', width: 300 },
    { filter: true, field: 'status', headerName: 'Status', width: 100 },
]);
</script>

<template>
    <AgGridVue
        style="height: 100%"
        :rowData="orderHistoryList"
        :columnDefs="colDefs"
    ></AgGridVue>
</template>

<style scoped></style>

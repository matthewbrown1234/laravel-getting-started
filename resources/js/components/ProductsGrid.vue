<script setup lang="ts">
import { AgGridVue } from 'ag-grid-vue3';
import { ref } from 'vue';
import type { Product } from '@/types';

const props = defineProps<{
    products: Product[];
}>();

// Column Definitions: Defines the columns to be displayed.
const colDefs = ref([
    {
        field: 'image',
        headerName: 'Image',
        width: 100,
        cellRenderer: (params: any) => {
            return `<img src="${params.value}" alt="Product Image" style="width: 50px; height: auto;" />`;
        },
    },
    { filter: true, field: 'id', headerName: 'ID', width: 80 },
    { filter: true, field: 'title', headerName: 'Title', width: 300 },
    { filter: true, field: 'price', headerName: 'Price', width: 100 },
    { filter: true, field: 'description', headerName: 'Desc', width: 900 },
]);
</script>

<template>
    <AgGridVue
        style="height: 100%"
        :rowData="props.products"
        :columnDefs="colDefs"
    ></AgGridVue>
</template>

<style scoped></style>

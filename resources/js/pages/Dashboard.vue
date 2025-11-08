<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import { AgGridVue } from 'ag-grid-vue3'; // Vue Data Grid Component
import { ref } from 'vue';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];
const page = usePage();
const products = page.props.products;

// Column Definitions: Defines the columns to be displayed.
const colDefs = ref([
    { field: 'image',headerName: 'Image', width: 100, cellRenderer: (params: any) => {
        return `<img src="${params.value}" alt="Product Image" style="width: 50px; height: auto;" />`;
    } },
    { filter: true, field: 'id', headerName: 'ID', width: 80 },
    { filter: true, field: 'title',headerName: 'Title', width: 300 },
    { filter: true, field: 'price',headerName: 'Price', width: 100 },
    { filter: true, field: 'description',headerName: 'Desc', width: 900 },
]);
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
                >
                    <PlaceholderPattern />
                </div>
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
                >
                    <PlaceholderPattern />
                </div>
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
                >
                    <PlaceholderPattern />
                </div>
            </div>
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
                <AgGridVue
                    style="height: 100%"
                    :rowData="products"
                    :columnDefs="colDefs"
                ></AgGridVue>
            </div>
        </div>
    </AppLayout>
</template>

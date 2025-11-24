<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { EditButton, StatusCell } from '@/components/ui/grid/cells';
import { LaravelPagination, Order } from '@/types';
import { router } from '@inertiajs/vue3';
import type { GridOptions, SortChangedEvent } from 'ag-grid-community';
import { AgGridVue } from 'ag-grid-vue3';
import { computed, ref } from 'vue';

const props = defineProps<{
    paginatedOrders: LaravelPagination<Order>;
}>();

const fetchData = (
    page: number,
    perPage: number,
    sort?: Array<{ col: string; dir: 'asc' | 'desc' | null | undefined }>,
) => {
    router.reload({
        data: {
            page,
            per_page: perPage,
            sort: sort ? JSON.stringify(sort) : undefined,
        },
        only: ['paginatedOrders'],
        replace: true,
    });
};

const currentPage = computed(() => props.paginatedOrders.current_page);
const perPage = computed(() => props.paginatedOrders.per_page);
const lastPage = computed(() => props.paginatedOrders.last_page);
const sortBy = ref<
    Array<{ col: string; dir: 'asc' | 'desc' | null | undefined }>
>([]);

const onNextPage = () => {
    if (currentPage.value < lastPage.value) {
        fetchData(currentPage.value + 1, perPage.value, sortBy.value);
    }
};
const onPrevPage = () => {
    if (currentPage.value > 1) {
        fetchData(currentPage.value - 1, perPage.value, sortBy.value);
    }
};

const gridOptions = ref<GridOptions<Order>>({
    onSortChanged(event: SortChangedEvent<Order>) {
        if (!event.columns?.[0]) {
            return;
        }
        sortBy.value = [
            {
                col: event.columns[0].getColId(),
                dir: event.columns[0].getSort(),
            },
        ];
        fetchData(currentPage.value, perPage.value, [
            {
                col: event.columns[0].getColId(),
                dir: event.columns[0].getSort(),
            },
        ]);
    },
    suppressMenuHide: true,
    autoSizeStrategy: {
        type: 'fitGridWidth',
        defaultMinWidth: 150,
    },
    columnDefs: [
        { filter: false, field: 'user.name', headerName: 'Name' },
        { filter: false, field: 'user.email', headerName: 'Email' },
        {
            filter: false,
            field: 'order_date',
            headerName: 'Order Date',
            cellDataType: 'dateTimeString',
        },
        {
            filter: false,
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
    ],
});
</script>

<template>
    <div class="flex h-full flex-col">
        <AgGridVue
            class="flex-1"
            :rowData="props.paginatedOrders.data"
            :gridOptions="gridOptions"
        ></AgGridVue>
        <div class="flex justify-end">
            <Button
                :variant="'outline'"
                :disabled="currentPage == 1"
                @click="onPrevPage()"
                >{{ `<` }} Prev</Button
            >
            <Button
                :variant="'outline'"
                :disabled="currentPage == lastPage"
                @click="onNextPage()"
                >Next {{ `>` }}
            </Button>
        </div>
    </div>
</template>

<style scoped></style>

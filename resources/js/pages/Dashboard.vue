<script setup lang="ts">
import OrderHistoryGrid from '@/components/OrderHistoryGrid.vue';
import ProductsGrid from '@/components/ProductsGrid.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem, type OrderHistory } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import type { RowClickedEvent } from 'ag-grid-community';
import { computed, ref } from 'vue';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];
const page = usePage();
const products = page.props.products;
const orderHistoryList = page.props.orderHistoryList;
const orderHistoryItems = page.props.orderHistoryItems;

const selectedOrderHistoryId = ref<string | undefined>(undefined);
const selectedOrderHistoryItems = computed(() =>
    orderHistoryItems.filter(
        (item) => item.order_history_id === selectedOrderHistoryId.value,
    ),
);
const selectedProducts = computed(() =>
    products.filter((product) =>
        selectedOrderHistoryItems.value.some((item) => item.product_id === product.id),
    ),
);
const onOrderSelection = (event: RowClickedEvent<OrderHistory>) => {
    selectedOrderHistoryId.value = event.data?.id;
};
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
                    <OrderHistoryGrid
                        :orderHistoryList="orderHistoryList"
                        :onOrderSelection="onOrderSelection"
                    />
                </div>
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
                >
                   Order History ID: {{ selectedOrderHistoryId }}
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
                <ProductsGrid :products="selectedProducts" />
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import OrdersGrid from '@/components/OrdersGrid.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { index } from '@/routes/orders';
import { AppPageProps, BreadcrumbItem, Order } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';

type OrdersPageProps = {
    orders: Order[];
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Orders',
        href: index().url,
    },
];

const { props } = usePage<AppPageProps<OrdersPageProps>>();

const { orders } = props;
</script>

<template>
    <Head title="Orders" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
                <OrdersGrid :orders="orders" />
            </div>
        </div>
    </AppLayout>
</template>

<style scoped></style>

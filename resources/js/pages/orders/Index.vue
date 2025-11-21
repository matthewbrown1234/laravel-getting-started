<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { index } from '@/routes/orders';
import { Head, usePage } from '@inertiajs/vue3';

import OrdersGrid from '@/components/OrdersGrid.vue';
import type { BreadcrumbItem } from '@/types';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Orders',
        href: index().url,
    },
];

const page = usePage();

const orders = page.props.orders;

console.log(orders);
</script>

<template>
    <Head title="Dashboard" />
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

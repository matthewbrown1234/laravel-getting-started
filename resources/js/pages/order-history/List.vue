<script setup lang="ts">
import OrderHistoryGrid from '@/components/OrderHistoryGrid.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { list } from '@/routes/order-history';
import { Head, usePage } from '@inertiajs/vue3';

import type { BreadcrumbItem } from '@/types';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Order History',
        href: list().url,
    },
];

const page = usePage();

const orderHistoryList = page.props.orderHistoryList;
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
                <OrderHistoryGrid :orderHistoryList="orderHistoryList" />
            </div>
        </div>
    </AppLayout>
</template>

<style scoped></style>

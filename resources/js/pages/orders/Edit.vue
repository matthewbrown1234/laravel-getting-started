<script setup lang="ts">
import { Spinner } from '@/components/ui/spinner';
import AppLayout from '@/layouts/AppLayout.vue';
import { index, show, update } from '@/routes/orders';
import { AppPageProps, BreadcrumbItem, Order } from '@/types';
import { Head, InertiaFormErrors, useForm, usePage } from '@inertiajs/vue3';
import {
    SelectContent,
    SelectItem,
    SelectItemText,
    SelectPortal,
    SelectRoot,
    SelectTrigger,
    SelectValue,
    SelectViewport,
} from 'reka-ui';
import { ref } from 'vue';

type OrderPageProps = {
    order: Order;
};
const { props } = usePage<AppPageProps<OrderPageProps>>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Orders',
        href: index().url,
    },
    {
        title: 'Order',
        href: show(props.order).url,
    },
];

const statusOptions = [
    { value: 'pending', label: 'Pending' },
    { value: 'shipped', label: 'Shipped' },
    { value: 'completed', label: 'Completed' },
    { value: 'canceled', label: 'Canceled' },
    { value: 'matt', label: 'Matt' },
];

const selectedStatus = ref(props.order.status);

const form = useForm<InertiaFormErrors>({
    status: props.order.status,
});

const handleSubmit = () => {
    form.put(update(props.order).url, {
        preserveScroll: true,
        onSuccess: () => {},
    });
};
</script>

<template>
    <Head title="Edit Order" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 p-6 md:min-h-min dark:border-sidebar-border"
            >
                <h1 class="mb-6 text-2xl font-bold">Edit Order</h1>
                <div
                    v-if="form.errors.error"
                    class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-600 dark:bg-red-900/20 dark:text-red-400"
                >
                    {{ form.errors.error }}
                </div>
                <form @submit.prevent="handleSubmit" class="space-y-6">
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-medium"> Order ID </label>
                        <input
                            type="text"
                            :value="props.order.id"
                            readonly
                            class="rounded-md border border-gray-300 bg-gray-50 px-3 py-2 text-gray-700 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300"
                        />
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-medium"> User </label>
                        <input
                            type="text"
                            :value="props.order.user.name"
                            readonly
                            class="rounded-md border border-gray-300 bg-gray-50 px-3 py-2 text-gray-700 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300"
                        />
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-medium"> User Email </label>
                        <input
                            type="email"
                            :value="props.order.user.email"
                            readonly
                            class="rounded-md border border-gray-300 bg-gray-50 px-3 py-2 text-gray-700 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300"
                        />
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-medium"> Order Date </label>
                        <input
                            type="text"
                            :value="
                                new Date(
                                    props.order.order_date,
                                ).toLocaleString()
                            "
                            readonly
                            class="rounded-md border border-gray-300 bg-gray-50 px-3 py-2 text-gray-700 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300"
                        />
                    </div>

                    <div class="flex flex-col gap-2">
                        <label
                            :class="[
                                'text-sm font-medium',
                                form.errors.status &&
                                    'text-red-600 dark:text-red-400',
                            ]"
                        >
                            Status
                        </label>
                        <SelectRoot
                            v-model="form.status"
                            @update:model-value="
                                (value) => {
                                    form.status = value as Order['status'];
                                    selectedStatus = value as Order['status'];
                                }
                            "
                        >
                            <SelectTrigger
                                :class="[
                                    'flex w-full items-center justify-between rounded-md border px-3 py-2 text-left',
                                    form.errors.status
                                        ? 'border-red-500 dark:border-red-500'
                                        : 'border-gray-300 dark:border-gray-600',
                                    'bg-white dark:bg-gray-900',
                                ]"
                            >
                                <SelectValue
                                    :placeholder="'Select status'"
                                    class="capitalize"
                                >
                                    {{ selectedStatus }}
                                </SelectValue>
                            </SelectTrigger>
                            <SelectPortal>
                                <SelectContent
                                    class="overflow-hidden rounded-md border border-gray-300 bg-white shadow-lg dark:border-gray-600 dark:bg-gray-900"
                                    :side-offset="5"
                                >
                                    <SelectViewport>
                                        <SelectItem
                                            v-for="option in statusOptions"
                                            :key="option.value"
                                            :value="option.value"
                                            class="cursor-pointer px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-800"
                                        >
                                            <SelectItemText>
                                                {{ option.label }}
                                            </SelectItemText>
                                        </SelectItem>
                                    </SelectViewport>
                                </SelectContent>
                            </SelectPortal>
                        </SelectRoot>
                        <p
                            v-if="form.errors.status"
                            class="text-sm text-red-600 dark:text-red-400"
                        >
                            {{ form.errors.status }}
                        </p>
                    </div>
                    <div class="flex gap-4">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="flex items-center rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 disabled:opacity-50"
                        >
                            <Spinner
                                v-if="form.processing"
                                class="mr-3"
                            ></Spinner>
                            {{ form.processing ? 'Saving...' : 'Save Changes' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped></style>

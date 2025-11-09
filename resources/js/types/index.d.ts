import { InertiaLinkProps } from '@inertiajs/vue3';
import type { LucideIcon } from 'lucide-vue-next';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: NonNullable<InertiaLinkProps['href']>;
    icon?: LucideIcon;
    isActive?: boolean;
}

export type AppPageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    products: Product[];
    orderHistoryItems: OrderHistoryItem[];
    orderHistoryList: OrderHistory[];
    sidebarOpen: boolean;
};

export type Product = {
    readonly id: number;
    readonly title: string;
    readonly price: number;
    readonly description?: string;
    readonly image?: string;
};

export type OrderHistory = {
    readonly id: string;
    readonly user_id: number;
    readonly order_date: string;
    readonly status: string;
};

export type OrderHistoryItem = {
    readonly id: string;
    readonly order_history_id: string;
    readonly product_id: string;
    readonly quantity: number;
    readonly price: number;
};

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export type BreadcrumbItemType = BreadcrumbItem;

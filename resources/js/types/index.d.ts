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
    sidebarOpen: boolean;
};

export type Product = {
    readonly id: number;
    readonly title: string;
    readonly price: number;
    readonly description?: string;
    readonly image?: string;
};

export type Order = {
    readonly id: string;
    readonly user_id: number;
    readonly user: User;
    readonly order_date: string;
    readonly status: 'pending' | 'completed' | 'canceled' | 'shipped';
};

export type OrderItem = {
    readonly id: string;
    readonly product_id: number;
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

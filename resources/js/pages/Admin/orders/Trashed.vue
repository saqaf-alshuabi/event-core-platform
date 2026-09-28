<script setup lang="ts">
import DataTable from '@/components/DataTable.vue';
import TrashedAction from '@/components/TrashedAction.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import ordersRoutes from '@/routes/orders';

import { type BreadcrumbItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import type { ColumnDef } from '@tanstack/vue-table';

import { ArrowLeft } from 'lucide-vue-next';
import { computed, h } from 'vue';

const props = defineProps({
    orders: {
        type: Array,
        required: true,
    },
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Orders',
        href: ordersRoutes.index().url,
    },
    {
        title: 'Trashed Orders',
        href: ordersRoutes.trashed().url,
    },
];

export interface Order {
    id: number;
    total_price: number;
    statusLabel: string;
    statusColor: string;
    eventTitle: string;
    attendeeName: string;
}

const data = computed<Order[]>(() => {
    return props.orders?.map((order: any) => ({
        id: order.id,
        total_price: order.total_price,
        statusLabel: order.statusLabel,
        statusColor: order.statusColor,
        eventTitle: order.event.title,
        attendeeName: order.attendee.user.name,
    }));
});

const userColumns: ColumnDef<Order>[] = [
    {
        id: 'select',
        header: ({ table }) =>
            h(Checkbox, {
                modelValue: table.getIsAllPageRowsSelected() || (table.getIsSomePageRowsSelected() && 'indeterminate'),
                'onUpdate:modelValue': (value: any) => table.toggleAllPageRowsSelected(!!value),
                ariaLabel: 'Select all',
            }),
        cell: ({ row }) =>
            h(Checkbox, {
                modelValue: row.getIsSelected(),
                'onUpdate:modelValue': (value: any) => row.toggleSelected(!!value),
                ariaLabel: 'Select row',
            }),
        enableSorting: false,
        enableHiding: false,
    },
    {
        accessorKey: 'id',
        header: 'ID',
        cell: ({ row }) => h('div', { class: 'capitalize' }, row.getValue('id')),
    },

    {
        accessorKey: 'total_price',
        header: 'Total Price',
        cell: ({ row }) => h('div', { class: 'capitalize' }, row.getValue('total_price')),
    },
    {
        accessorKey: 'statusLabel',
        header: 'Status',
        cell: ({ row }) => h('div', { class: `capitalize ${row.original.statusColor}` }, row.getValue('statusLabel')),
    },
    {
        accessorKey: 'eventTitle',
        header: 'Event Title',
        cell: ({ row }) => h('div', { class: 'capitalize' }, row.getValue('eventTitle')),
    },
    {
        accessorKey: 'attendeeName',
        header: 'Attendee Name',
        cell: ({ row }) => h('div', { class: 'capitalize' }, row.getValue('attendeeName')),
    },

    {
        id: 'actions',
        enableHiding: false,
        cell: ({ row }) => {
            const order = row.original;

            return h(
                'div',
                { class: 'relative' },
                h(TrashedAction, {
                    id: row.original.id,
                    restoreRoute: ordersRoutes.restore(row.original.id).url,
                    deleteRoute: ordersRoutes.delete(row.original.id).url,
                }),
            );
        },
    },
];


</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="w-full">
            <div class="flex items-center py-4">
                <div class="ml-auto flex items-center space-x-2">
                    <Link title="Back to orders" :href="ordersRoutes.index().url">
                        <Button variant="outline" class="h-8 w-8 p-0">
                            <ArrowLeft class="h-4 w-4 text-primary" />
                        </Button>
                    </Link>
                </div>
            </div>
            <DataTable :data="data" :columns="userColumns" columnFilter="ticketType" />
        </div>
    </AppLayout>
</template>

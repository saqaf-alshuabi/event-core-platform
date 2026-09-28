<script setup lang="ts">
import ActionUser from '@/components/ActionUser.vue';
import DataTable from '@/components/DataTable.vue';
import SmartAvatar from '@/components/SmartAvatar.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import ticketsRoutes from '@/routes/tickets';
import { type BreadcrumbItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import type { ColumnDef } from '@tanstack/vue-table';

import { BadgePlus, FolderX } from 'lucide-vue-next';
import { computed, h } from 'vue';

const props = defineProps({
    tickets: {
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
        title: 'Tickets',
        href: ticketsRoutes.index().url,
    },
];

export interface Tickets {
    id: number;
    ticketType: string;
    price: number;
    quantity: number;
    eventImg: string;
}

const data = computed<Tickets[]>(() => {
    return props.tickets?.map((ticket: any) => ({
        id: ticket.id,
        ticketType: ticket.type,
        price: ticket.price,
        quantity: ticket.quantity,
        eventImg: ticket.event.event_images[0]?.image_url,
    }));
});

const userColumns: ColumnDef<Tickets>[] = [
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
        accessorKey: 'ticketType',
        header: 'Type',
        cell: ({ row }) => h('div', { class: 'capitalize' }, row.getValue('ticketType')),
    },
    {
        accessorKey: 'price',
        header: 'Price',
        cell: ({ row }) => h('div', { class: 'capitalize' }, row.getValue('price')),
    },
    {
        accessorKey: 'quantity',
        header: 'Quantity',
        cell: ({ row }) => h('div', { class: 'capitalize' }, row.getValue('quantity')),
    },
    {
        accessorKey: 'eventImg',
        header: 'Event Img',
        cell: ({ row }) =>
            h(
                'div',
                { class: 'flex items-center gap-2' },
                h(SmartAvatar, {
                    name: row.getValue('title'),
                    src: row.original.eventImg,
                }),
            ),
    },

    {
        id: 'actions',
        enableHiding: false,
        cell: ({ row }) => {
            const ticket = row.original;

            return h(
                'div',
                { class: 'relative' },
                h(ActionUser, {
                    id: row.original.id,
                    editRoute: ticketsRoutes.edit(row.original.id).url,
                    deleteRoute: ticketsRoutes.destroy(row.original.id).url,
                }),
            );
        },
    },
];

</script>

<template>
    <!-- <img :src="props.tickets[0].event.event_images[0].image_url" alt=""> -->
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="w-full">
            <div class="flex items-center py-4">
                <div class="ml-auto flex items-center space-x-2">
                    <Link as="button" :href="ticketsRoutes.trashed().url" type="Trash tickets">
                        <Button variant="outline" class="h-8 w-8 p-0">
                            <FolderX class="h-4 w-4 text-primary" />
                        </Button>
                    </Link>

                    <Link type="Add New ticket" :href="ticketsRoutes.create().url">
                        <Button variant="outline" class="h-8 w-8 p-0">
                            <BadgePlus class="h-4 w-4 text-primary" />
                        </Button>
                    </Link>
                </div>
            </div>
            <DataTable :data="data" :columns="userColumns" columnFilter="ticketType" />
        </div>
    </AppLayout>
</template>

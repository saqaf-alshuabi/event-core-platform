<script setup lang="ts">
import DataTable from '@/components/DataTable.vue';
import ButtonBack from '@/components/Navigation/ButtonBack.vue';
import SmartAvatar from '@/components/SmartAvatar.vue';
import TrashedAction from '@/components/TrashedAction.vue';
import { Checkbox } from '@/components/ui/checkbox';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import eventsRoutes from '@/routes/events';
import { type BreadcrumbItem } from '@/types';
import type { ColumnDef } from '@tanstack/vue-table';
import { computed, h } from 'vue';
const props = defineProps({
    events: {
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
        title: 'events',
        href: eventsRoutes.index().url,
    },
    {
        title: 'Trashed',
        href: eventsRoutes.trashed().url,
    },
];

export interface events {
    id: number;
    title: string;
    created_at: string;
    // usertitle: string;
    url: string;
}

const data = computed<events[]>(() => {
    return props.events.map((event: any) => ({
        id: event.id,
        title: event.title,
        created_at: event.created_at,
        // usertitle: event.user?.title || 'N/A',
        url: event.event_images[0].image_url,
    }));
});

const userColumns: ColumnDef<events>[] = [
    {
        id: 'select',
        header: ({ table }) =>
            h(Checkbox, {
                modelValue: table.getIsAllPageRowsSelected() || (table.getIsSomePageRowsSelected() && 'indeterminate'),
                'onUpdate:modelValue': (value) => table.toggleAllPageRowsSelected(!!value),
                ariaLabel: 'Select all',
            }),
        cell: ({ row }) =>
            h(Checkbox, {
                modelValue: row.getIsSelected(),
                'onUpdate:modelValue': (value) => row.toggleSelected(!!value),
                ariaLabel: 'Select row',
            }),
        enableSorting: false,
        enableHiding: false,
    },
    {
        accessorKey: 'id',
        header: 'ID',
        cell: ({ row }) => h('div', row.getValue('id')),
    },
    {
        accessorKey: 'title',
        header: 'Title',
        cell: ({ row }) => h('div', row.getValue('title')),
    },
    // {
    //     accessorKey: 'usertitle',
    //     header: 'User title',
    //     cell: ({ row }) => h('div', row.getValue('usertitle')),
    // },
    {
        accessorKey: 'url',
        header: 'Img',
        cell: ({ row }) =>
            h(
                'div',
                { class: 'flex items-center gap-2' },
                h(SmartAvatar, {
                    name: row.getValue('title'),
                    src: row.original.url,
                }),
            ),
    },
    {
        accessorKey: 'created_at',
        header: 'Created at',
        cell: ({ row }) => h('div', new Date(row.getValue('created_at')).toLocaleDateString()),
    },

    {
        id: 'actions',
        enableHiding: false,
        cell: ({ row }) =>
            h(TrashedAction, {
                id: row.original.id,
                restoreRoute: eventsRoutes.restore(row.original.id).url,
                deleteRoute: eventsRoutes.delete(row.original.id).url,
                showRestore: true,
                showForceDelete: true,
            }),
    },
];

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="w-full">
            <div class="flex items-center py-4">
                <div class="ml-auto flex items-center space-x-2">
                    <ButtonBack :href="eventsRoutes.index().url" />
                </div>
            </div>
            <DataTable :data="data" :columns="userColumns" columnFilter="title" />
        </div>
    </AppLayout>
</template>

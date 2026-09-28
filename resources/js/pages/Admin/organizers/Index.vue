<script setup lang="ts">
import ActionUser from '@/components/ActionUser.vue';
import DataTable from '@/components/DataTable.vue';
import SmartAvatar from '@/components/SmartAvatar.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import organizersRoutes from '@/routes/organizers';
import usersRoutes from '@/routes/users';
import { type BreadcrumbItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import type { ColumnDef } from '@tanstack/vue-table';
import { FolderX } from 'lucide-vue-next';
import { computed, h } from 'vue';

const props = defineProps({
    organizers: {
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
        title: 'Users',
        href: usersRoutes.index().url,
    },
    {
        title: 'Organizers',
        href: organizersRoutes.index().url,
    },
];

export interface Organizers {
    id: number;
    name: string;
    created_at: string;
    userName: string;
    image: string;
}

const data = computed<Organizers[]>(() => {
    return props.organizers.map((organizer: any) => ({
        id: organizer.id,
        name: organizer.name,
        created_at: organizer.created_at,
        userName: organizer.user?.name || 'N/A',
        image: organizer.user?.image || '',
    }));
});

const userColumns: ColumnDef<Organizers>[] = [
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
        accessorKey: 'name',
        header: 'Organizer Name',
        cell: ({ row }) => h('div', row.getValue('name')),
    },
    {
        accessorKey: 'userName',
        header: 'User Name',
        cell: ({ row }) => h('div', row.getValue('userName')),
    },
    {
        accessorKey: 'image',
        header: 'User Img',
        cell: ({ row }) =>
            h('div', { class: 'flex justify-center' }, [
                h(SmartAvatar, { src: row.getValue('image') as string, alt: row.getValue('name') as string, name: row.getValue('name') as string }),
            ]),
    },
    {
        accessorKey: 'created_at',
        header: 'Created At',
        cell: ({ row }) => h('div', new Date(row.getValue('created_at')).toLocaleDateString()),
    },

    {
        id: 'actions',
        enableHiding: false,
        cell: ({ row }) =>
            h(ActionUser, {
                id: row.original.id,
                deleteRoute: organizersRoutes.destroy(row.original.id).url,
            }),
    },
];

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="w-full">
            <div class="flex items-center py-4">
                <div class="ml-auto flex items-center space-x-2">
                    <Link title="Trash organizers" :href="organizersRoutes.trashed().url">
                        <Button variant="outline" class="h-8 w-8 p-0">
                            <FolderX class="h-4 w-4 text-primary" />
                        </Button>
                    </Link>
                </div>
            </div>
            <DataTable :data="data" :columns="userColumns" />
        </div>
    </AppLayout>
</template>

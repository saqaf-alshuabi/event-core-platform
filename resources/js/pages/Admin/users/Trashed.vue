<script setup lang="ts">
import DataTable from '@/components/DataTable.vue';
import SmartAvatar from '@/components/SmartAvatar.vue';
import TrashedAction from '@/components/TrashedAction.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import usersRoutes from '@/routes/users';
import { type BreadcrumbItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import type { ColumnDef } from '@tanstack/vue-table';
import { ArrowLeft } from 'lucide-vue-next';
import { computed, h, PropType } from 'vue';

const props = defineProps({
    users: {
        type: Array as PropType<User[]>,
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
        title: 'Trashed',
        href: usersRoutes.trashed().url,
    },
];

export interface User {
    id: number;
    name: string;
    email: string;
    image: string;
}

const data = computed<User[]>(() => {
    return props.users.map((user: any) => ({
        id: user.id,
        name: user.name,
        email: user.email,
        image: user.image,
    }));
});

const userColumns: ColumnDef<User>[] = [
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
        header: 'Name',
        cell: ({ row }) => h('div', row.getValue('name')),
    },
    {
        accessorKey: 'email',
        header: 'Email',
        cell: ({ row }) => h('div', { class: 'lowercase' }, row.getValue('email')),
    },
    {
        accessorKey: 'image',
        header: 'Image',
        cell: ({ row }) =>
            h('div', { class: 'flex justify-center' }, [
                h(SmartAvatar, { src: row.getValue('image') as string, alt: row.getValue('name') as string, name: row.getValue('name') as string }),
            ]),
    },
    {
        id: 'actions',
        enableHiding: false,
        cell: ({ row }) =>
            h(TrashedAction, {
                id: row.original.id,
                restoreRoute: usersRoutes.restore(row.original.id).url,
                deleteRoute: usersRoutes.delete(row.original.id).url,
            }),
    },
];

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="w-full">
            <div class="flex items-center py-4">
                <div class="ml-auto flex items-center space-x-2">
                    <Link title="Back to users" :href="usersRoutes.index().url">
                        <Button variant="outline" class="h-8 w-8 p-0">
                            <ArrowLeft class="h-4 w-4 text-primary" />
                        </Button>
                    </Link>
                </div>
            </div>
            <DataTable :data="data" :columns="userColumns" />
        </div>
    </AppLayout>
</template>

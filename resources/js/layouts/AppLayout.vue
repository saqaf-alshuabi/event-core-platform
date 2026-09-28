<script setup lang="ts">
import SmartAlert from '@/components/SmartAlert.vue';
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';

withDefaults(
    defineProps<{
        breadcrumbs?: BreadcrumbItemType[];
    }>(),
    {
        breadcrumbs: () => [],
    },
);
</script>

<template>
    <AppSidebarLayout :breadcrumbs="breadcrumbs">
        <SmartAlert />
        <slot />
    </AppSidebarLayout>
</template>

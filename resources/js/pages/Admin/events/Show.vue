<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { computed, h } from 'vue';

import AppContent from '@/components/AppContent.vue';
import DataTable from '@/components/DataTable.vue';
import Heading from '@/components/Heading.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import CarouselImages from '@/components/Navigation/CarouselImages.vue';
import SmartAvatar from '@/components/SmartAvatar.vue';
import { Button } from '@/components/ui/button';
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';

import ActionUser from '@/components/ActionUser.vue';

import event from '@/routes/event';
import event_images from '@/routes/event_images';
import events from '@/routes/events';
import { type BreadcrumbItem } from '@/types';
import { ColumnDef } from '@tanstack/vue-table';
import { ImagePlus } from 'lucide-vue-next';

interface EventImage {
    url: string;
    id: number;
    updated_at: string;
    image_url: string;
}

interface Organizer {
    name: string;
    user: {
        email: string;
        name: string;
    };
}

interface Event {
    id: number;
    title: string;
    location: string;
    start_date: string;
    end_date: string;
    created_at: string;
    event_images: EventImage[];
    organizer: Organizer;
}

const props = defineProps({
    event: {
        type: Object as () => Event,
        required: true,
    },
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Events',
        href: events.index().url,
    },
    {
        title: 'Show',
        href: events.show(props.event.id).url,
    },
];

interface EventImages {
    url: string;
    id: number;
}
const eventImages = computed<EventImages[]>(() => {
    return props.event.event_images.map((image: EventImage) => ({
        id: image.id,
        updatedAt: image.updated_at,
        url: image.image_url,
        eventId: props.event.id,
    }));
});
const eventColumns = computed<ColumnDef<EventImages>[]>(() => [
    {
        accessorKey: 'id',
        header: 'ID',
        cell: ({ row }) => h('div', { class: 'capitalize' }, row.getValue('id')),
    },

    {
        accessorKey: 'url',
        header: 'Img',
        cell: ({ row }) =>
            h(
                'div',
                { class: 'flex items-center gap-2' },
                h(SmartAvatar, {
                    name: 'image',
                    src: row.original.url,
                }),
            ),
    },
    {
        accessorKey: 'updatedAt',
        header: 'Updated At',
        cell: ({ row }) => h('div', { class: 'capitalize' }, new Date(row.getValue('updatedAt')).toLocaleDateString()),
    },
    {
        accessorKey: 'eventId',
        header: 'Event ID',
        cell: ({ row }) => h('div', { class: 'capitalize' }, row.getValue('eventId')),
    },

    {
        id: 'actions',
        enableHiding: false,
        cell: ({ row }) => {
            const eventItem = row.original;

            return h(
                'div',
                { class: 'relative' },
                h(ActionUser, {
                    id: row.original.id,
                    editRoute: event_images.edit(eventItem.id).url,
                    deleteRoute: event_images.destroy(eventItem.id).url,
                }),
            );
        },
    },
]);

const formatDate = (dateString: string) => new Date(dateString).toLocaleDateString();

const formattedStartDate = computed(() => formatDate(props.event.start_date));
const formattedEndDate = computed(() => formatDate(props.event.end_date));
const formattedCreatedAt = computed(() => formatDate(props.event.created_at));

const hasImages = computed(() => props.event.event_images && props.event.event_images.length > 0);

</script>
<template>
    <Head :title="`Event: ${props.event.title}`" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <Heading title="Event Details" description="Explore the details of this event." />

            <Card class="mb-8 border-none bg-card">
                <CardContent class="grid grid-cols-1 gap-8 p-6 md:grid-cols-2">
                    <!-- Event Details -->
                    <div class="flex flex-col space-y-4">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <AppContent class="col-span-full">
                                <HeadingSmall title="Location" :description="props.event.location" />
                            </AppContent>
                            <AppContent>
                                <HeadingSmall title="Start Date" :description="formattedStartDate" />
                            </AppContent>
                            <AppContent>
                                <HeadingSmall title="End Date" :description="formattedEndDate" />
                            </AppContent>
                            <AppContent>
                                <HeadingSmall title="Created At" :description="formattedCreatedAt" />
                            </AppContent>
                        </div>

                        <!-- Organizer Details -->
                        <div v-if="props.event.organizer" class="grid grid-cols-1 gap-4 pt-4 sm:grid-cols-2">
                            <AppContent class="col-span-full">
                                <HeadingSmall title="Organizer Name" :description="props.event.organizer.name" />
                            </AppContent>
                            <AppContent>
                                <HeadingSmall title="Organizer Email" :description="props.event.organizer.user.email" />
                            </AppContent>
                            <AppContent>
                                <HeadingSmall title="Organizer User" :description="props.event.organizer.user.name" />
                            </AppContent>
                        </div>
                    </div>

                    <!-- Event Images -->
                    <div v-if="hasImages">
                        <CarouselImages :images="props.event.event_images" />
                    </div>
                </CardContent>
            </Card>

            <!-- Related Events Section (Placeholder) -->
            <hr />
            <div class="p-4">
                <Heading title="Related Events" description="Explore other events you might be interested in." />
                <div class="flex items-center py-4">
                    <Link title="Add New image" :href="event.eventImages.create(props.event.id).url">
                        <Button variant="outline" class="h-8 w-8 p-0">
                            <ImagePlus class="h-4 w-4 text-primary" />
                        </Button>
                    </Link>
                </div>
                <DataTable :data="eventImages" :columns="eventColumns" column-filter="id" />
            </div>
        </div>
    </AppLayout>
</template>

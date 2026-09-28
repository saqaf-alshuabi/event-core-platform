<script setup lang="ts">
import AppContent from '@/components/AppContent.vue';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import tickets from '@/routes/tickets';

import { BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
const props = defineProps<{
    events: {
        id: number;
        title: string;
    };
}>();

const form = useForm({
    type: '',
    price: 0,
    quantity: 0,
    event_id: '',
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Tickets',
        href: tickets.index().url,
    },
    {
        title: 'Create',
        href: tickets.create().url,
    },
];

const submit = () => {
    form.post(tickets.store().url);
};
</script>

<template>
    <Head title="Create Ticket" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <AppContent>
            <div class="mx-auto p-4">
                <Heading
                    title="Create New Ticket"
                    description="Fill in the details to create a new ticket.
                "
                />
                <form @submit.prevent="submit" class="flex flex-col gap-6">
                    <div class="grid gap-2">
                        <Label for="price">Price</Label>
                        <Input type="number" id="price" placeholder="Price" :tabindex="1" v-model="form.price" />
                        <InputError :message="form.errors.price" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="type">Type</Label>
                        <Select v-model="form.type">
                            <SelectTrigger class="w-full">
                                <SelectValue placeholder="Select a ticket type" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectLabel>Ticket Type</SelectLabel>
                                    <SelectItem value="VIP"> VIP </SelectItem>
                                    <SelectItem value="Early Bird"> Early Bird </SelectItem>
                                    <SelectItem value="Standard">Standard </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                        <InputError :message="form.errors.type" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="quantity">Quantity</Label>
                        <Input type="number" id="quantity" placeholder="Quantity" :tabindex="4" v-model="form.quantity" />
                        <InputError :message="form.errors.quantity" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="event">Event</Label>
                        <Select v-model="form.event_id">
                            <SelectTrigger class="w-full">
                                <SelectValue placeholder="Select an event" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectLabel>Event</SelectLabel>
                                    <SelectItem v-for="event in props.events" :key="event.id" :value="event.id">
                                        {{ event.title }}
                                    </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                        <InputError :message="form.errors.event_id" />
                    </div>

                    <div class="flex gap-2">
                        <Button @click="submit" class="mt-2" :tabindex="5" :disabled="form.processing" data-test="create-ticket-button">
                            <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                            Create Ticket
                        </Button>
                        <Link as="button" class="mt-2" :href="tickets.index().url">
                            <Button type="button" variant="outline"> Back </Button>
                        </Link>
                    </div>
                </form>
            </div>
        </AppContent>
    </AppLayout>
</template>

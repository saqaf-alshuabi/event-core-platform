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
    ticket: {
        id: number;
        type: string;
        price: number;
        quantity: number;
    };
}>();
const form = useForm({
    type: props.ticket.type,
    price: props.ticket.price,
    quantity: props.ticket.quantity,
});


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },

    {
        title: 'Edit',
        href: tickets.edit(props.ticket.id).url,
    },
];

const submit = () => {
    form.put(tickets.update(props.ticket.id).url);
};

</script>

<template>
    <Head :title="`Edit Ticket: ${props.ticket.id}`" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <AppContent>
            <div class="mx-auto p-4">
                <Heading
                    title="Edit Ticket"
                    description="Edit the ticket details.
                "
                />
                <form @submit.prevent="submit" class="flex flex-col gap-6">
                    <div class="grid gap-2">
                        <Label for="price">Price</Label>
                        <Input type="number" id="price" placeholder="Price" :tabindex="4" v-model="form.price" />
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

                    <div class="flex gap-2">
                        <Button @click="submit" class="mt-2" :tabindex="5" :disabled="form.processing" data-test="update-image-button">
                            <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                            Update Ticket
                        </Button>
                        <Link as="button" class="mt-2">
                            <Button type="button" variant="outline"> Back </Button>
                        </Link>
                    </div>
                </form>
            </div>
        </AppContent>
    </AppLayout>
</template>

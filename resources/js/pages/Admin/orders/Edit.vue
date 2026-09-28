<script setup lang="ts">
import AppContent from '@/components/AppContent.vue';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import orders from '@/routes/orders';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

const props = defineProps<{
    order: {
        id: number;
        total_price: number;
        status: string;
        statusLabel: string;
    };
}>();

const form = useForm({
    total_price: props.order.total_price,
    status: props.order.statusLabel,
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Orders',
        href: orders.index().url,
    },
    {
        title: 'Edit',
        href: orders.edit(props.order.id).url,
    },
];

const submit = () => {
    form.patch(orders.update(props.order.id).url);
};

</script>

<template>
    <Head :title="`Edit Order ${props.order.id}`" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <AppContent>
            <div class="mx-auto max-w-2xl p-4">
                <Heading :title="`Edit Order ${props.order.id}`" description="Update the details of this order." />
                <form @submit.prevent="submit" class="flex flex-col gap-6">
                    <div class="grid gap-2">
                        <Label for="total_price">Total Price</Label>
                        <Input
                            class="hover:border-primary focus:border-primary"
                            id="total_price"
                            type="number"
                            v-model="form.total_price"
                            :tabindex="1"
                            name="total_price"
                            placeholder="Total Price"
                        />
                        <InputError :message="form.errors.total_price" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="status">Status</Label>
                        <Select v-model="form.status">
                            <SelectTrigger class="w-[180px]">
                                <SelectValue placeholder="Select a status" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="pending">Pending</SelectItem>
                                <SelectItem value="completed">Completed</SelectItem>
                                <SelectItem value="cancelled">Cancelled</SelectItem>
                            </SelectContent>
                        </Select>

                        <InputError :message="form.errors.status" />
                    </div>

                    <Button
                        @click="submit"
                        type="submit"
                        class="mt-2 w-full"
                        :tabindex="5"
                        :disabled="form.processing"
                        data-test="update-order-button"
                    >
                        <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                        Update Order
                    </Button>
                </form>
            </div>
        </AppContent>
    </AppLayout>
</template>

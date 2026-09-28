<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import HeadingSmaller from '@/components/HeadingSmaller.vue';
import Paragraph from '@/components/Paragraph.vue';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { useCart } from '@/composables/useCart';
import AppLayout from '@/layouts/web/AppLayout.vue';
import web from '@/routes/web';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

const { items, totalPrice, totalItems, clearCart } = useCart();

const hasItems = computed(() => items.value.length > 0);
const form = useForm({
    items: items.value,
    total_price: totalPrice.value,
    total_items: totalItems.value,
});

const submit = () => {
    form.transform(() => ({
        items: items.value,
        total_price: totalPrice.value,
        total_items: totalItems.value,
    })).post(web.orders.store().url, {
        onSuccess: () => clearCart(),
    });
};
</script>

<template>
    <Head title="Checkout" />
    <AppLayout>
        <section class="py-16">
            <div class="container mx-auto p-4">
                <div class="mb-8 text-center">
                    <Heading title="Checkout" description="Complete your purchase" />
                </div>

                <div v-if="hasItems" class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    <form @submit.prevent="submit" class="md:col-span-2">
                        <Button type="submit" @click="submit"> Send Payment</Button>
                    </form>
                    <!-- Order Summary -->
                    <div class="md:col-span-1">
                        <div class="rounded-lg border bg-card p-6 shadow-sm">
                            <HeadingSmaller title="Order Summary" class="mb-4" />

                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <Paragraph :text="`Subtotal (${totalItems}) items`" />
                                    <Paragraph :text="'$' + totalPrice" />
                                </div>
                                <div class="flex justify-between">
                                    <Paragraph text="Shipping" />
                                    <Paragraph text="Free" />
                                </div>
                                <div class="flex justify-between">
                                    <Paragraph text="Tax" />
                                    <Paragraph text="$0.00" />
                                </div>
                                <Separator class="my-4" />
                                <div class="flex justify-between text-lg font-bold">
                                    <HeadingSmaller title="Total" />
                                    <Paragraph :text="'$' + totalPrice" />
                                </div>
                            </div>
                            <Button class="mt-6 w-full"> Place Order </Button>
                        </div>
                    </div>
                </div>

                <div v-else class="flex flex-col items-center justify-center space-y-6 text-center">
                    <Paragraph text="Your cart is currently empty. Please add tickets to proceed with checkout." />
                    <Link href="/web/events"> <Button> Browse Events </Button></Link>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

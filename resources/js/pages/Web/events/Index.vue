<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import HeroNormalPage from '@/components/Web/HeroNormalPage.vue';
import SliderCard from '@/components/Web/SliderCard.vue';
import AppLayout from '@/layouts/web/AppLayout.vue';
import type { Event } from '@/types';

const props = defineProps({
    events: Array<Event>(),
});
</script>

<template>
    <AppLayout>
        <HeroNormalPage title="Our Events" description="Explore a wide variety of events tailored to your interests." />

        <section class="bg-accent/10 py-16">
            <div class="container m-auto">
                <Heading title="Upcoming Events" description="Stay tuned for our latest events" class="mb-10 text-center" />
                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                    <SliderCard v-for="event in events" :key="event.id" :event="event" class="h-120" />
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<script setup lang="ts">
import { toTypedSchema } from '@vee-validate/zod';
import { useForm } from 'vee-validate';

import { Button } from '@/components/ui/button';
import { FormControl, FormDescription, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import events from '@/routes/events';

import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardDescription from '@/components/ui/card/CardDescription.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import { EventSchema } from '@/Schemas/EventSchema';
import { BreadcrumbItem } from '@/types';
import { useForm as useInertiaForm } from '@inertiajs/vue3';

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
        title: 'Create',
        href: events.create().url,
    },
];

const inertiaForm = useInertiaForm({
    title: '',
    description: '',
    location: '',
    end_date: '',
    start_date: '',
    image: undefined,
});

const eventSchemas = toTypedSchema(EventSchema);

const { isFieldDirty, handleSubmit, setErrors } = useForm({
    initialValues: inertiaForm.data(),
    // validationSchema: eventSchemas,
});

const onSubmit = handleSubmit((values) => {
    inertiaForm.title = values.title;
    inertiaForm.description = values.description ?? '';
    inertiaForm.location = values.location;
    inertiaForm.end_date = values.end_date;
    inertiaForm.start_date = values.start_date;
    inertiaForm.image = values.image;

    inertiaForm.post(events.store().url, {
        onError: (errors) => {
            setErrors(errors);
        },
        onSuccess: () => {
            inertiaForm.reset();
        },
    });
});
</script>

<template>
    <AppLayout :breadcrumbs>
        <div class="mx-auto max-w-2xl p-4">
            <Card class="bg-primary-subtle border-none">
                <CardHeader class="">
                    <CardTitle class="text-primary">Event Form</CardTitle>
                    <CardDescription>Create a new event here.</CardDescription>
                </CardHeader>
                <CardContent>
                    <form class="space-y-8" @submit="onSubmit">
                        <!-- start -->
                        <FormField v-slot="{ componentField }" name="title">
                            <FormItem>
                                <FormLabel>Title</FormLabel>
                                <FormControl>
                                    <Input type="text" placeholder="title" v-bind="componentField" />
                                </FormControl>
                                <FormDescription>Must be min 3 characters. </FormDescription>
                                <FormMessage />
                            </FormItem>
                        </FormField>

                        <!--    end -->
                        <FormField v-slot="{ componentField }" name="description">
                            <FormItem>
                                <FormLabel for="description">Description</FormLabel>
                                <FormControl>
                                    <Input type="text" id="description" placeholder="description" v-bind="componentField" />
                                </FormControl>
                                <FormDescription>This is optional.</FormDescription>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                        <!-- start -->

                        <FormField v-slot="{ componentField }" name="location">
                            <FormItem>
                                <FormLabel for="location">Location</FormLabel>
                                <FormControl>
                                    <Input type="text" id="location" placeholder="location" v-bind="componentField" />
                                </FormControl>
                                <FormDescription>This is optional.</FormDescription>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                        <!-- end -->

                        <!-- start -->
                        <FormField v-slot="{ componentField }" name="start_date">
                            <FormItem>
                                <FormLabel for="start_date">Start Date </FormLabel>
                                <FormControl>
                                    <Input type="date" id="start_date" v-bind="componentField" />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>

                        <!-- start -->
                        <FormField v-slot="{ componentField }" name="end_date">
                            <FormItem>
                                <FormLabel for="end_date">end_date </FormLabel>
                                <FormControl>
                                    <Input type="date" id="end_date" v-bind="componentField" />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>

                        <FormField v-slot="{ componentField }" name="image">
                            <FormItem>
                                <FormLabel for="image">Image</FormLabel>
                                <FormControl>
                                    <Input
                                        id="image"
                                        type="file"
                                        @change="
                                            (e) => {
                                                componentField.onChange(e);
                                                inertiaForm.image = e.target.files[0];
                                            }
                                        "
                                    />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>

                        <!-- end -->
                        <Button type="submit">Submit</Button>
                    </form>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from '@/components/ui/alert-dialog';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import Actions from './Actions.vue';
import DropdownMenuItem from './ui/dropdown-menu/DropdownMenuItem.vue';

const props = defineProps<{
    id: number | string;
    restoreRoute: string;
    deleteRoute: string;
}>();

const isAlertOpen = ref(false);
const form = useForm({});

const openAlert = () => {
    isAlertOpen.value = true;
};

const closeAlert = () => {
    isAlertOpen.value = false;
};

const deleteItem = () => {
    form.delete(props.deleteRoute, {
        onFinish: closeAlert,
    });
};

const restoreItem = () => {
    form.put(props.restoreRoute);
};
</script>

<template>
    <Actions>
        <DropdownMenuItem class="text-primary" @select="restoreItem"> Restore </DropdownMenuItem>
        <DropdownMenuItem class="text-destructive" variant="destructive" @select="openAlert"> Delete </DropdownMenuItem>
    </Actions>

    <AlertDialog :open="isAlertOpen" @update:open="isAlertOpen = $event">
        <AlertDialogContent>
            <AlertDialogHeader>
                <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
                <AlertDialogDescription> This action cannot be undone. </AlertDialogDescription>
            </AlertDialogHeader>
            <AlertDialogFooter>
                <AlertDialogCancel @click="closeAlert">Cancel</AlertDialogCancel>
                <AlertDialogAction @click="deleteItem">Delete</AlertDialogAction>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>

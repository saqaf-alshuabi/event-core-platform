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
import { Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import Actions from './Actions.vue';
import Icon from './Icon.vue';
import DropdownMenuItem from './ui/dropdown-menu/DropdownMenuItem.vue';

const props = defineProps<{
    id: number | string;
    editRoute?: string;
    deleteRoute: string;
    viewRoute?: string;
}>();

const emit = defineEmits(['deleteSusses']);
const isAlertOpen = ref(false);

const openAlert = () => {
    isAlertOpen.value = true;
};

const closeAlert = () => {
    isAlertOpen.value = false;
};

const form = useForm({});
const deleteItem = () => {
    form.delete(props.deleteRoute, {
        onSuccess: () => {
            closeAlert();
            emit('deleteSusses', props.id);
        },
    });
};
</script>

<template>
    <Actions>
        <DropdownMenuItem v-if="viewRoute" as-child>
            <Link :href="viewRoute" class="flex items-center gap-2">
                <Icon name="eye" />
                <span>View</span>
            </Link>
        </DropdownMenuItem>
        <DropdownMenuItem v-if="editRoute" as-child>
            <Link :href="editRoute" class="flex items-center gap-2">
                <Icon name="pencil" />
                <span>Edit</span>
            </Link>
        </DropdownMenuItem>
        <DropdownMenuItem class="text-destructive focus:bg-destructive/10 focus:text-destructive" @select="openAlert"> Delete </DropdownMenuItem>
    </Actions>

    <AlertDialog :open="isAlertOpen" @update:open="isAlertOpen = $event">
        <AlertDialogContent>
            <AlertDialogHeader>
                <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
                <AlertDialogDescription> This action cannot be undone. </AlertDialogDescription>
            </AlertDialogHeader>
            <AlertDialogFooter>
                <AlertDialogCancel>Cancel</AlertDialogCancel>
                <AlertDialogAction @click="deleteItem">Delete</AlertDialogAction>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>

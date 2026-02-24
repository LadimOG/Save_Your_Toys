<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { Shapes, Trash2 } from 'lucide-vue-next';

import { SidebarMenuItem, SidebarMenuButton } from '../ui/sidebar';

const props = defineProps<{
    child: {
        name: string;
        id: number;
    };
}>();

const handleDelete = (id: number) => {
    if (confirm(`Es-tu sur de vouloir supprimer ${props.child.name} ?`)) {
        router.delete(`/children/${id}`);
    }
};
</script>

<template>
    <SidebarMenuItem>
        <SidebarMenuButton>
            <Shapes class="size-4" />
            <span>{{ child.name }}</span>
            <Trash2
                @click.stop.prevent="handleDelete(child.id)"
                class="ml-auto size-4 cursor-pointer text-muted-foreground opacity-0 transition-opacity group-hover:opacity-100 hover:text-red-500"
            />
        </SidebarMenuButton>
    </SidebarMenuItem>
</template>

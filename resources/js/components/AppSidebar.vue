<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { CirclePlus, LogOut, Home } from 'lucide-vue-next';
import { ref } from 'vue';
import { route } from 'ziggy-js';
import NavUser from '@/components/NavUser.vue';
import ToyFormDialog from '@/components/Toys/ToyFormDialog.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    SidebarGroup,
    SidebarGroupLabel,
} from '@/components/ui/sidebar';

import AppLogo from './AppLogo.vue';

const isDialogOpen = ref(false);
const isEditMode = ref(false);
const editingToyId = ref<number | null>(null);
const selectedToyData = ref({ name: '', description: '' });

const openAddToyModal = () => {
    isEditMode.value = false;
    editingToyId.value = null;
    selectedToyData.value = { name: '', description: '' };
    isDialogOpen.value = true;
};
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link href="/toys">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <SidebarGroup>
                <SidebarGroupLabel>Platform</SidebarGroupLabel>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton @click="openAddToyModal">
                            <CirclePlus />
                            <span>Ajouter un jouet</span>
                        </SidebarMenuButton>
                    </SidebarMenuItem>

                    <SidebarMenuItem>
                        <SidebarMenuButton as-child>
                            <Link href="/">
                                <Home />
                                Home
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarGroup>
        </SidebarContent>

        <SidebarFooter>
            <NavUser />
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton
                        as-child
                        class="text-red-600 hover:bg-red-50 hover:text-red-700"
                    >
                        <Link :href="route('logout')" method="post" as="button">
                            <LogOut class="h-4 w-4" />
                            <span>Déconnexion</span>
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarFooter>
    </Sidebar>
    <ToyFormDialog
        v-model:open="isDialogOpen"
        :is-edit-mode="isEditMode"
        :toy-id="editingToyId"
        :initial-data="selectedToyData"
    />
</template>

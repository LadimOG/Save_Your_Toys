<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { Baby, ChevronDown, LogOut, UserPlus } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';
import { route } from 'ziggy-js';
import NavUser from '@/components/NavUser.vue';
import AppLogo from './AppLogo.vue';
import ChildAddFormDialog from './Child/ChildAddFormDialog.vue';
import ItemSidebarMenu from './Child/ItemSidebarMenu.vue';
import {
    Collapsible,
    CollapsibleContent,
    CollapsibleTrigger,
} from './ui/collapsible';
import {
    Sidebar,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuItem,
    SidebarMenuButton,
    SidebarGroupLabel,
    SidebarGroup,
    SidebarFooter,
    SidebarContent,
    SidebarMenuSub,
} from './ui/sidebar';

const childDialogOpen = ref(false);
const isExpanded = ref(false);
const page = usePage();

const childList = computed(() => page.props.children as any[]);

console.log(page.url);

watch(
    () => page.url,
    (newPath) => {
        if (newPath.startsWith('/children')) {
            isExpanded.value = true;
        }
    },
    { immediate: true },
);

watch(
    () => page.props.children as any,
    (newList, oldList) => {
        if (newList && oldList && newList.length > oldList.length) {
            isExpanded.value = true;
        }
    },
    { immediate: true },
);

const handleAddChild = () => {
    childDialogOpen.value = true;
};
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link href="/">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <SidebarGroup>
                <SidebarGroupLabel>Gestion</SidebarGroupLabel>
                <SidebarMenu>
                    <Collapsible
                        v-model:open="isExpanded"
                        class="group/collapsible"
                    >
                        <SidebarMenuItem>
                            <CollapsibleTrigger as-child>
                                <SidebarMenuButton tooltip="Mes Enfants">
                                    <Baby />
                                    <span>Mes Enfants</span>
                                    <ChevronDown
                                        class="ml-auto transition-transform duration-200 group-data-[state=open]/collapsible:rotate-180"
                                    />
                                </SidebarMenuButton>
                            </CollapsibleTrigger>

                            <CollapsibleContent>
                                <SidebarMenuSub>
                                    <ItemSidebarMenu
                                        v-for="child in childList"
                                        :key="child.id"
                                        :child="child"
                                    />

                                    <SidebarMenuItem class="mt-2">
                                        <SidebarMenuButton
                                            @click="handleAddChild"
                                        >
                                            <UserPlus class="size-4" />
                                            <span
                                                class="truncate text-xs text-muted-foreground italic"
                                                >Ajouter un enfant</span
                                            >
                                        </SidebarMenuButton>
                                    </SidebarMenuItem>
                                </SidebarMenuSub>
                            </CollapsibleContent>
                        </SidebarMenuItem>
                    </Collapsible>
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
                        tooltip="Déconnexion"
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
    <ChildAddFormDialog v-model:open="childDialogOpen" />
</template>

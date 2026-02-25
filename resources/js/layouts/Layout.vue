<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { watch } from 'vue';
import { Toaster, toast } from 'vue-sonner';
import AppSidebar from '@/components/AppSidebar.vue';
import {
    SidebarProvider,
    SidebarInset,
    SidebarTrigger,
} from '@/components/ui/sidebar';
import 'vue-sonner/style.css';

const page = usePage();

watch(
    () => page.props.flash,
    (flash: any) => {
        if (flash?.success) {
            setTimeout(() => {
                toast.success(flash.success);
            }, 100);
        }
    },
    { immediate: true, deep: true },
);
</script>

<template>
    <SidebarProvider>
        <AppSidebar />
        <SidebarInset class="flex h-screen flex-col overflow-hidden">
            <header
                class="flex h-16 shrink-0 items-center gap-2 border-b px-4 transition-[width,height] ease-linear"
            >
                <SidebarTrigger />
                <h1 class="text-2xl font-bold">Le Coffre à Jouet</h1>
            </header>

            <main class="flex-1 overflow-y-auto p-6">
                <div class="mx-auto max-w-6xl">
                    <slot />
                </div>
            </main>
        </SidebarInset>
    </SidebarProvider>
    <Toaster position="top-center" richColors />
</template>

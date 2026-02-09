<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { watch } from 'vue';
import { Toaster, toast } from 'vue-sonner';

const page = usePage();

watch(
    () => (page.props as any).flash?.success,
    (message) => {
        if (message) {
            setTimeout(() => {
                toast.success(message);
            }, 100);
            (page.props as any).flash.success = null;
        }
    },
    { immediate: true },
);
</script>

<template>
    <div class="min-h-screen p-6">
        <div class="mx-auto max-w-6xl">
            <slot />
        </div>
    </div>
    <Toaster position="top-center" richColors />
</template>

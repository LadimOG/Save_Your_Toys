<script setup lang="ts">
import Layout from '@/layouts/Layout.vue';

defineProps<{
    child?: any;
}>();
</script>

<template>
    <Layout>
        <div class="p-6">
            <h2 class="text-2xl font-bold">
                Bienvenue dans ton tableau de bord
            </h2>
            <p class="text-slate-500">
                Sélectionne un enfant dans la barre latérale pour voir ses
                jouets.
            </p>
        </div>
    </Layout>
</template>

<script setup lang="ts">
import { Shapes } from 'lucide-vue-next';
import Layout from '@/layouts/Layout.vue';
</script>

<template>
    <Layout>
        <div
            class="flex min-h-[calc(100vh-64px)] w-full flex-col items-center justify-center text-center"
        >
            <div class="max-w-md space-y-4">
                <div
                    class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-indigo-50"
                >
                    <Shapes class="h-10 w-10 text-indigo-600" />
                </div>

                <div class="space-y-2">
                    <h2
                        class="text-3xl font-bold tracking-tight text-slate-900"
                    >
                        Bienvenue dans ton tableau de bord
                    </h2>
                    <p class="text-lg text-slate-500">
                        Sélectionne un enfant dans la barre latérale pour voir
                        ses jouets.
                    </p>
                </div>
            </div>
        </div>
    </Layout>
</template>

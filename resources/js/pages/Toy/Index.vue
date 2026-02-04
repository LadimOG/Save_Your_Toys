<script setup lang="ts">
import type { Toy } from '@/types/toy';
import { Head } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Card, CardHeader, CardTitle, CardContent } from '@/components/ui/card';

const props = defineProps<{
    toys: Toy[];
}>();
</script>

<template>
    <Head title="Mes jouets" />

    <div class="min-h-screen bg-slate-50/50 p-6">
        <div class="mx-auto max-w-6xl">
            <header
                class="mb-8 flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center"
            >
                <div>
                    <h1
                        class="text-3xl font-bold tracking-tight text-slate-900"
                    >
                        Le Coffre à Jouets
                    </h1>
                    <p class="text-slate-500">
                        Gère et répertorie tous les trésors de ton enfant.
                    </p>
                </div>

                <Button
                    class="cursor-pointer bg-indigo-600 hover:bg-indigo-700"
                >
                    + Ajouter un jouet
                </Button>
            </header>

            <div
                v-if="toys.length > 0"
                class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3"
            >
                <Card
                    v-for="toy in toys"
                    :key="toy.id"
                    class="overflow-hidden transition-shadow hover:shadow-md"
                >
                    <div
                        class="flex aspect-video items-center justify-center bg-slate-200 text-slate-400"
                    >
                        <img
                            v-if="toy.image_path"
                            :src="toy.image_path"
                            class="h-full w-full object-cover"
                        />
                        <span v-else>📷 Pas de photo</span>
                    </div>

                    <CardHeader class="p-4">
                        <CardTitle class="text-xl font-semibold">{{
                            toy.name
                        }}</CardTitle>
                    </CardHeader>

                    <CardContent class="px-4 pb-4">
                        <p class="line-clamp-2 text-sm text-slate-600">
                            {{
                                toy.description ||
                                'Aucune description disponible.'
                            }}
                        </p>
                    </CardContent>
                </Card>
            </div>

            <div
                v-else
                class="rounded-xl border-2 border-dashed bg-white py-20 text-center"
            >
                <p class="text-slate-500">
                    Le coffre est vide ! Ajoute le premier jouet de ton enfant.
                </p>
            </div>
        </div>
    </div>
</template>

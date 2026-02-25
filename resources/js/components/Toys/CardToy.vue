<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { Pencil } from 'lucide-vue-next';
import { Trash2 } from 'lucide-vue-next';
import type { Toy } from '@/types/toy';
import { Button } from '../ui/button';
import {
    Card,
    CardTitle,
    CardHeader,
    CardContent,
    CardDescription,
} from '../ui/card';

defineProps<{
    toy: Toy;
}>();

const emit = defineEmits(['editToy']);

const handleEdit = (toy: Toy) => {
    emit('editToy', toy);
};

const handleDelete = (id: number) => {
    if (confirm('Es-tu sur de vouloir supprimer ce jouet?')) {
        router.delete(`/toys/${id}`);
    }
};
</script>
<template>
    <Card class="group relative overflow-hidden">
        <div
            class="flex aspect-video items-center justify-center bg-slate-200 text-slate-400"
        >
            <img
                v-if="toy.image_path"
                :src="toy.image_path"
                class="aspect-video w-full bg-white object-contain"
            />
            <span v-else>📷 Pas de photo</span>

            <div class="absolute top-2 right-2 flex gap-1">
                <div class="group/item flex flex-col items-center gap-1">
                    <Button
                        variant="secondary"
                        size="icon"
                        class="h-9 w-9 opacity-0 shadow-md transition-opacity group-hover:opacity-100"
                        @click.stop="handleEdit(toy)"
                    >
                        <Pencil class="h-4 w-4" />
                    </Button>
                    <span
                        class="pointer-events-none translate-y-1 text-[10px] font-bold tracking-wider text-slate-700 uppercase opacity-0 transition-all group-hover/item:translate-y-0 group-hover/item:opacity-100"
                    >
                        Modifier
                    </span>
                </div>

                <div class="group/trash flex flex-col items-center gap-1">
                    <Button
                        variant="destructive"
                        size="icon"
                        class="h-9 w-9 opacity-0 shadow-md transition-opacity group-hover:opacity-100"
                        @click.stop="handleDelete(toy.id)"
                    >
                        <Trash2 class="h-4 w-4" />
                    </Button>
                    <span
                        class="pointer-events-none translate-y-1 text-[10px] font-bold tracking-wider text-slate-700 uppercase opacity-0 transition-all group-hover/trash:translate-y-0 group-hover/trash:opacity-100"
                    >
                        Supprimer
                    </span>
                </div>
            </div>
        </div>

        <CardHeader class="p-4">
            <CardTitle class="text-xl font-semibold first-letter:uppercase">{{
                toy.name
            }}</CardTitle>
        </CardHeader>

        <CardContent class="px-4 pb-4">
            <CardDescription>
                <p class="line-clamp-2 text-sm text-slate-600">
                    {{ toy.description || 'Aucune description disponible.' }}
                </p>
            </CardDescription>
        </CardContent>
    </Card>
</template>

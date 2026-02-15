<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { Pencil, Trash2 } from 'lucide-vue-next';
import { ref } from 'vue';
import 'vue-sonner/style.css';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import Layout from '@/layouts/Layout.vue';
import type { Toy } from '@/types/toy';

defineProps<{
    toys: Toy[];
}>();

const isDialogOpen = ref(false);
const isEditMode = ref(false);
const editingToyId = ref<number | null>(null);

const form = useForm({
    name: '',
    description: '',
    image: null as File | null,
});

const submit = () => {
    if (isEditMode.value && editingToyId.value) {
        form.transform((data) => ({
            ...data,
            _method: 'put',
        })).post(`/toys/${editingToyId.value}`, {
            onSuccess: () => closeModal(),
        });
    } else {
        form.post('/toys', {
            onSuccess: () => closeModal(),
        });
    }
};

const handleImageChange = (e: Event) => {
    const target = e.target as HTMLInputElement;
    if (target.files) {
        form.image = target.files[0];
    }
};

const closeModal = () => {
    isDialogOpen.value = false;
    isEditMode.value = false;
    editingToyId.value = null;
    form.reset();
};

const editToy = (toy: Toy) => {
    isEditMode.value = true;
    editingToyId.value = toy.id;
    form.name = toy.name;
    form.description = toy.description || '';
    isDialogOpen.value = true;
};

const deleteToy = (id: number) => {
    if (confirm('Es-tu sur de vouloir supprimer ce jouet?')) {
        form.delete(`/toys/${id}`);
    }
};
</script>

<template>
    <Head title="Mes jouets" />

    <Layout>
        <header
            class="mb-8 flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center"
        >
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-slate-900">
                    Le Coffre à Jouets
                </h1>
                <p class="text-slate-500">
                    Gère et répertorie tous les trésors de ton enfant.
                </p>
            </div>

            <Dialog v-model:open="isDialogOpen">
                <DialogTrigger as-child>
                    <Button class="bg-indigo-600 hover:bg-indigo-700">
                        + Ajouter un jouet
                    </Button>
                </DialogTrigger>
                <DialogContent class="sm:max-w-[425px]">
                    <DialogHeader>
                        <DialogTitle>Nouveau Trésor</DialogTitle>
                        <DialogDescription>
                            Remplis les détails du jouet ici. Clique sur
                            sauvegarder une fois fini.
                        </DialogDescription>
                    </DialogHeader>

                    <form @submit.prevent="submit" class="grid gap-4 py-4">
                        <div class="grid gap-2">
                            <Label for="name">Nom du jouet</Label>
                            <Input
                                id="name"
                                v-model="form.name"
                                placeholder="ex: Ours en peluche"
                            />
                            <div
                                v-if="form.errors.name"
                                class="text-xs text-red-500"
                            >
                                {{ form.errors.name }}
                            </div>
                        </div>

                        <div class="grid gap-2">
                            <Label for="description">Description</Label>
                            <Textarea
                                id="description"
                                v-model="form.description"
                                placeholder="Il est tout doux..."
                            />
                        </div>

                        <div class="grid gap-2">
                            <Label for="image">Photo</Label>
                            <Input
                                id="image"
                                type="file"
                                @change="handleImageChange"
                                accept="image/*"
                            />
                            <div
                                v-if="form.errors.image"
                                class="text-xs text-red-500"
                            >
                                {{ form.errors.image }}
                            </div>
                        </div>

                        <DialogFooter class="mt-4">
                            <Button type="submit" :disabled="form.processing">
                                {{
                                    form.processing
                                        ? 'Enregistrement...'
                                        : 'Sauvegarder le jouet'
                                }}
                            </Button>
                        </DialogFooter>
                    </form>
                </DialogContent>
            </Dialog>
        </header>

        <div
            v-if="toys.length > 0"
            class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3"
        >
            <Card
                v-for="toy in toys"
                :key="toy.id"
                class="group relative overflow-hidden"
            >
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
                        <div
                            class="group/item flex flex-col items-center gap-1"
                        >
                            <Button
                                variant="secondary"
                                size="icon"
                                class="h-9 w-9 opacity-0 shadow-md transition-opacity group-hover:opacity-100"
                                @click="editToy(toy)"
                            >
                                <Pencil class="h-4 w-4" />
                            </Button>
                            <span
                                class="pointer-events-none translate-y-1 text-[10px] font-bold tracking-wider text-slate-700 uppercase opacity-0 transition-all group-hover/item:translate-y-0 group-hover/item:opacity-100"
                            >
                                Modifier
                            </span>
                        </div>

                        <div
                            class="group/trash flex flex-col items-center gap-1"
                        >
                            <Button
                                variant="destructive"
                                size="icon"
                                class="h-9 w-9 opacity-0 shadow-md transition-opacity group-hover:opacity-100"
                                @click="deleteToy(toy.id)"
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
                    <CardTitle class="text-xl font-semibold">{{
                        toy.name
                    }}</CardTitle>
                </CardHeader>

                <CardContent class="px-4 pb-4">
                    <p class="line-clamp-2 text-sm text-slate-600">
                        {{
                            toy.description || 'Aucune description disponible.'
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
    </Layout>
    <Toaster position="top-center" richColors class="-z-50" />
</template>

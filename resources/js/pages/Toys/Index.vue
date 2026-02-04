<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Button } from '@/components/ui/button';
import { Card, CardHeader, CardTitle, CardContent } from '@/components/ui/card';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
    DialogFooter,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import type { Toy } from '@/types/toy';

defineProps<{
    toys: Toy[];
}>();

const isDialogOpen = ref(false);

const form = useForm({
    name: '',
    description: '',
    image: null as File | null,
});

const submit = () => {
    form.post('/toys', {
        onSuccess: () => {
            form.reset();
            isDialogOpen.value = false;
        },
        onError: (errors) => {
            console.log('Erreurs Laravel :', errors); // <--- AJOUTE ÇA
        },
    });
};

const handleImageChange = (e: Event) => {
    const target = e.target as HTMLInputElement;
    if (target.files) {
        form.image = target.files[0];
    }
};
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
                                <Button
                                    type="submit"
                                    :disabled="form.processing"
                                >
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

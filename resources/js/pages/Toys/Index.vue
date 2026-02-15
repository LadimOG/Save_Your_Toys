<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import 'vue-sonner/style.css';
import CardToy from '@/components/CardToy.vue';
import { Button } from '@/components/ui/button';
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
    form.clearErrors();
};

const handleEditClick = (toy: Toy) => {
    isEditMode.value = true;
    editingToyId.value = toy.id;
    form.name = toy.name;
    form.description = toy.description || '';
    isDialogOpen.value = true;
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
                    <Button
                        class="bg-indigo-600 hover:bg-indigo-700"
                        @click="
                            isEditMode = false;
                            form.reset();
                        "
                    >
                        + Ajouter un jouet
                    </Button>
                </DialogTrigger>
                <DialogContent class="sm:max-w-[425px]">
                    <DialogHeader>
                        <DialogTitle>{{
                            isEditMode ? 'Modifier le jouet' : 'Nouveau Trésor'
                        }}</DialogTitle>
                        <DialogDescription>
                            {{
                                isEditMode
                                    ? 'Mettez à jour les informations de ce jouet.'
                                    : 'Remplis les détails du jouet ici.'
                            }}
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
            <CardToy :toys="toys" @edit-toy="handleEditClick" />
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

<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import 'vue-sonner/style.css';
import CardToy from '@/components/Toys/CardToy.vue';
import ToyFormDialog from '@/components/Toys/ToyFormDialog.vue';
import { Button } from '@/components/ui/button';
import Layout from '@/layouts/Layout.vue';
import type { Toy } from '@/types/toy';

defineProps<{
    toys: Toy[];
}>();

const isDialogOpen = ref(false);
const isEditMode = ref(false);
const editingToyId = ref<number | null>(null);

const selectedToyData = ref({ name: '', description: '' });

const openCreateModal = () => {
    isEditMode.value = false;
    editingToyId.value = null;
    selectedToyData.value = { name: '', description: '' }; // Reset data
    isDialogOpen.value = true;
};
const handleEditClick = (toy: Toy) => {
    isEditMode.value = true;
    editingToyId.value = toy.id;
    selectedToyData.value = {
        name: toy.name,
        description: toy.description || '',
    };
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
            <Button
                class="bg-indigo-600 hover:bg-indigo-700"
                @click="openCreateModal"
            >
                + Ajouter un jouet
            </Button>
            <ToyFormDialog
                v-model:open="isDialogOpen"
                :is-edit-mode="isEditMode"
                :toy-id="editingToyId"
                :initial-data="selectedToyData"
            />
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
</template>

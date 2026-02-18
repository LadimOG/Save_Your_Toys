<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import 'vue-sonner/style.css';
import CardToy from '@/components/Toys/CardToy.vue';
import ToyFormDialog from '@/components/Toys/ToyFormDialog.vue';
import Layout from '@/layouts/Layout.vue';
import type { Toy } from '@/types/toy';

defineProps<{
    toys: Toy[];
}>();

const isDialogOpen = ref(false);
const isEditMode = ref(false);
const editingToyId = ref<number | null>(null);
const selectedToyData = ref({ name: '', description: '' });

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
        <div
            v-if="toys.length > 0"
            class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3"
        >
            <CardToy
                v-for="toy in toys"
                :key="toy.id"
                :toy="toy"
                @edit-toy="handleEditClick"
            />
        </div>

        <div
            v-else
            class="rounded-xl border-2 border-dashed bg-white py-20 text-center"
        >
            <p class="text-slate-500">
                Le coffre est vide ! Ajoute le premier jouet de ton enfant.
            </p>
        </div>
        <ToyFormDialog
            v-model:open="isDialogOpen"
            :is-edit-mode="isEditMode"
            :toy-id="editingToyId"
            :initial-data="selectedToyData"
        />
    </Layout>
</template>

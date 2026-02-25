<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import CardToy from '@/components/Toys/CardToy.vue';
import ToyFormDialog from '@/components/Toys/ToyFormDialog.vue';
import { Button } from '@/components/ui/button';
import Layout from '@/layouts/Layout.vue';
import type { Child } from '@/types/child';
import type { Toy } from '@/types/toy';

const isDialogOpen = ref(false);
const editMode = ref(false);
const toyId = ref<number | null>(null);
const initialData = ref({
    name: '',
    description: '',
});

defineProps<{
    child: Child;
    toys: Toy[];
}>();

const handleEditClick = (toy: Toy) => {
    editMode.value = true;
    toyId.value = toy.id;
    initialData.value = {
        name: toy.name,
        description: toy.description || '',
    };
    isDialogOpen.value = true;
};

const handleDialogOpen = () => {
    editMode.value = false;
    toyId.value = null;
    initialData.value = {
        name: '',
        description: '',
    };
    isDialogOpen.value = true;
};
</script>

<template>
    <Head :title="`Coffre à jouet de ${child.name}`" />
    <Layout>
        <div class="">
            <div
                class="flex w-full justify-between rounded-xl bg-slate-100 p-4"
            >
                <h2>Le coffre a jouet de {{ child.name }}</h2>

                <Button
                    @click="handleDialogOpen"
                    type="button"
                    class="rounded-sm bg-indigo-600 p-2 text-sm font-medium text-white hover:bg-indigo-700"
                >
                    Ajouter un jouet
                </Button>
            </div>
            <div
                class="mt-2 grid grid-cols-1 gap-6 rounded-xl bg-slate-100 p-3 sm:grid-cols-2 lg:grid-cols-3"
            >
                <p v-if="toys.length === 0">Aucun jouet n'a été ajouté !</p>

                <CardToy
                    v-for="toy in toys"
                    :key="toy.id"
                    :toy="toy"
                    @edit-toy="handleEditClick(toy)"
                />
            </div>
        </div>
        <ToyFormDialog
            v-model:open="isDialogOpen"
            :isEditMode="editMode"
            :toyId="toyId"
            :initialData="initialData"
            :childId="child.id"
        />
    </Layout>
</template>

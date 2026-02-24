<script setup lang="ts">
//import { ref } from 'vue';
//import CardToy from '@/components/Toys/CardToy.vue';
//import ToyFormDialog from '@/components/Toys/ToyFormDialog.vue';
import Layout from '@/layouts/Layout.vue';
import type { Toy } from '@/types/toy';

// const isDialogOpen = ref(false);
// const isEditMode = ref(false);
// const editingToyId = ref<number | null>(null);
// const selectedToyData = ref({ name: '', description: '' });

defineProps<{
    child: {
        name: string;
        id: number;
    };
    toys: Toy[];
}>();
// const handleEditClick = (toy: Toy) => {
//     isEditMode.value = true;
//     editingToyId.value = toy.id;
//     selectedToyData.value = {
//         name: toy.name,
//         description: toy.description || '',
//     };
//     isDialogOpen.value = true;
// };
</script>

<template></template>

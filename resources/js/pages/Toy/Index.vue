<script setup lang="ts">
import type { Toy } from '@/types/toy';
import { Head } from '@inertiajs/vue3';

const props = defineProps<{
    toys: Toy[];
}>();
</script>

<template>
    <Head title="Home" />
</template>

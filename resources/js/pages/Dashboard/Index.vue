<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { Button } from '@/components/ui/button';

const logout = () => {
    router.post(route('logout'));
};
</script>
<template>
    <Button @click="logout">Déconnexion</Button>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogDescription,
    DialogFooter,
} from '@/components/ui/dialog';
import Input from './ui/input/Input.vue';
import Label from './ui/label/Label.vue';

defineProps<{ open: boolean }>();
const emit = defineEmits(['update:open', 'switchToRegister']);

const form = useForm({
    email: '',
    password: '',
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('email', 'password'),
        onSuccess: () => emit('update:open', false),
    });
};
</script>
<template>
    <Dialog :open="open" @update:open="emit('update:open', $event)">
        <DialogContent>
            <form @submit.prevent="submit">
                <DialogHeader>
                    <DialogTitle>Connexion</DialogTitle>
                    <DialogDescription
                        >Ajoutez vos identifiants pour vous
                        connecter</DialogDescription
                    >
                </DialogHeader>
                <div class="grid gap-4 py-4">
                    <div class="grid gap-2">
                        <Label for="email">Email</Label>
                        <Input
                            id="email"
                            type="email"
                            class="focus-visible:ring-2 focus-visible:ring-black"
                            v-model="form.email"
                        />
                        <p class="text-sm text-red-600">
                            {{ form.errors.email }}
                        </p>
                    </div>
                    <div class="grid gap-2">
                        <Label for="password">Mot de passe</Label>
                        <Input
                            id="password"
                            type="password"
                            class="focus-visible:ring-2 focus-visible:ring-black"
                            v-model="form.password"
                        />
                        <p class="text-sm text-red-600">
                            {{ form.errors.password }}
                        </p>
                    </div>
                </div>
                <DialogFooter class="flex flex-col gap-2">
                    <Button
                        type="submit"
                        size="lg"
                        :disabled="form.processing"
                        >{{
                            form.processing ? 'chargement' : 'Se connecter'
                        }}</Button
                    >
                    <Button variant="link" @click="emit('switchToRegister')">
                        Pas de compte ? Créez-en un
                    </Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>

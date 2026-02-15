<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { Label } from '@/components/ui/label';
import Button from './ui/button/Button.vue';
import {
    Dialog,
    DialogContent,
    DialogTitle,
    DialogHeader,
    DialogFooter,
    DialogDescription,
} from './ui/dialog';
import Input from './ui/input/Input.vue';

defineProps<{
    open: boolean;
}>();
const emit = defineEmits(['update:open']);

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
        onSuccess: () => emit('update:open', false),
        onError: (errors) => {
            console.log('Erreurs détectées :', errors);
            // La modale restera ouverte car onSuccess n'est pas appelé
        },
    });
};
</script>
<template>
    <Dialog :open="open" @update:open="emit('update:open', $event)">
        <DialogContent>
            <form @submit.prevent="submit">
                <DialogHeader>
                    <DialogTitle>Créer un compte</DialogTitle>
                    <DialogDescription
                        >Remplissez les informations pour rejoindre le coffre à
                        jouets.
                    </DialogDescription>
                </DialogHeader>
                <div class="grid gap-4">
                    <div class="grid gap-2">
                        <Label for="name">Nom </Label>
                        <Input
                            id="name"
                            placeholder="Gianni"
                            class="focus-visible:ring-2 focus-visible:ring-black"
                            v-model="form.name"
                        />
                        <p v-if="form.errors.name" class="text-xs text-red-500">
                            {{ form.errors.name }}
                        </p>
                    </div>
                    <div class="grid gap-2">
                        <Label for="email">Email</Label>
                        <Input
                            id="email"
                            type="email"
                            class="focus-visible:ring-2 focus-visible:ring-black"
                            v-model="form.email"
                        />
                        <p
                            v-if="form.errors.email"
                            class="text-xs text-red-500"
                        >
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
                        <p
                            v-if="form.errors.password"
                            class="text-xs text-red-500"
                        >
                            {{ form.errors.password }}
                        </p>
                    </div>
                    <div class="grid gap-2">
                        <Label for="password_confirmation"
                            >Confirmer mot de passe</Label
                        >
                        <Input
                            id="password_confirmation"
                            type="password"
                            class="focus-visible:ring-2 focus-visible:ring-black"
                            v-model="form.password_confirmation"
                        />
                        <div v-if="form.errors.password"></div>
                    </div>
                </div>
                <DialogFooter>
                    <Button
                        type="submit"
                        class="mt-6 w-full"
                        :disabled="form.processing"
                    >
                        {{
                            form.processing ? 'chargement' : 'Créer mon compte '
                        }}
                    </Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>

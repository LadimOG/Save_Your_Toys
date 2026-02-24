<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

import { Button } from '../ui/button';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogFooter,
    DialogTitle,
} from '../ui/dialog';
import { Input } from '../ui/input';
import { Label } from '../ui/label';

defineProps<{
    open: boolean;
}>();

const form = useForm({
    name: '',
});

const emit = defineEmits(['update:open']);

const submit = () => {
    form.post('children', {
        onSuccess: () => {
            form.reset();
            emit('update:open', false);
        },
    });
};
</script>
<template>
    <Dialog :open="open" @update:open="emit('update:open', $event)">
        <DialogContent>
            <form @submit.prevent="submit">
                <DialogHeader>
                    <DialogTitle>Nom de votre enfant </DialogTitle>
                    <DialogDescription>
                        Veuillez inscrire le nom de votre enfant
                    </DialogDescription>
                </DialogHeader>

                <div class="mt-4 grid gap-2">
                    <Label for="name">Nom de l'enfant'</Label>
                    <Input
                        id="name"
                        v-model="form.name"
                        placeholder="ex: Benoit"
                        autofocus
                    />
                    <div v-if="form.errors.name" class="text-xs text-red-500">
                        {{ form.errors.name }}
                    </div>
                </div>
                <DialogFooter class="mt-4">
                    <Button type="submit" :disabled="form.processing">
                        {{
                            form.processing
                                ? 'Enregistrement...'
                                : 'Ajouter votre enfant'
                        }}
                    </Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>

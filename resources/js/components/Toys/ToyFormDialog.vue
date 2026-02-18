<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { watch } from 'vue';
import { Button } from '../ui/button';
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogDescription,
    DialogFooter,
} from '../ui/dialog';
import { Input } from '../ui/input';
import { Label } from '../ui/label';
import { Spinner } from '../ui/spinner';
import { Textarea } from '../ui/textarea';

const props = defineProps<{
    open: boolean;
    isEditMode: boolean;
    toyId: number | null;
    initialData: { name: string; description: string };
}>();

const form = useForm({
    name: props.initialData.name,
    description: props.initialData.description,
    image: null as File | null,
});

const emit = defineEmits(['update:open']);

watch(
    () => props.initialData,
    (newData) => {
        form.name = newData.name;
        form.description = newData.description;
    },
    { deep: true },
);

const submit = () => {
    if (props.isEditMode && props.toyId) {
        form.transform((data) => ({
            ...data,
            _method: 'put',
        })).post(`/toys/${props.toyId}`, {
            onSuccess: () => emit('update:open', false),
        });
    } else {
        form.post('/toys', {
            onSuccess: () => {
                form.reset();
                emit('update:open', false);
            },
        });
    }
};

const handleImageChange = (e: Event) => {
    const target = e.target as HTMLInputElement;
    if (target.files) {
        form.image = target.files[0];
    }
};
</script>

<template>
    <Dialog :open="open" @update:open="emit('update:open', $event)">
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
                    <div v-if="form.errors.name" class="text-xs text-red-500">
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
                    <div v-if="form.errors.image" class="text-xs text-red-500">
                        {{ form.errors.image }}
                    </div>
                </div>

                <DialogFooter class="mt-4">
                    <Button type="submit" :disabled="form.processing">
                        <Spinner v-if="form.processing" />
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
</template>

<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

const page = usePage();
</script>

<template>
    <div class="flex min-h-screen items-center justify-center bg-gray-50 p-6">
        <div class="w-full max-w-4xl rounded-2xl border bg-white p-8 shadow-sm">
            <div class="flex flex-col items-center gap-10 md:flex-row">
                <div class="flex-1 space-y-6 text-center md:text-left">
                    <div>
                        <h1
                            class="text-4xl font-extrabold tracking-tight text-gray-900"
                        >
                            Le coffre à jouets
                        </h1>
                        <p class="mt-2 text-lg text-gray-600">
                            Gardez un souvenir de tous les jouets de votre
                            enfant.
                        </p>
                    </div>

                    <div
                        class="flex items-center justify-center md:justify-start"
                    >
                        <Link
                            v-if="!page.props.auth.user"
                            :href="route('login')"
                            class="rounded-sm bg-black p-2 text-sm font-medium text-amber-50 hover:bg-gray-800"
                            >Commencer
                        </Link>
                        <Link
                            v-else
                            :href="route('dashboard.index')"
                            class="rounded-sm bg-indigo-600 p-2 text-sm font-medium text-white hover:bg-indigo-700"
                        >
                            Voir mes jouets
                        </Link>
                    </div>
                </div>

                <div class="w-full flex-1">
                    <div
                        class="relative aspect-square overflow-hidden rounded-2xl bg-slate-100 shadow-inner"
                    >
                        <img
                            src="/images/toys_cover.png"
                            alt="Coffre à jouets"
                            class="absolute inset-0 h-full w-full object-cover"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

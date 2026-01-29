<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-2xl font-semibold leading-tight text-slate-900"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-6xl px-6 lg:px-8">
                <div
                    class="rounded-[28px] border border-slate-200/80 bg-white/70 p-8 shadow-2xl backdrop-blur"
                >
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-xl font-semibold text-slate-900">
                                Voce esta logado!
                            </h3>
                            <p class="mt-2 text-sm text-slate-500">
                                Bem-vindo de volta ao seu painel.
                            </p>
                        </div>
                        <div class="rounded-2xl bg-teal-600/10 p-3">
                            <svg
                                class="size-6 text-[rgb(var(--accent))]"
                                viewBox="0 0 24 24"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M6 8.5C6 7.12 7.12 6 8.5 6h7C16.88 6 18 7.12 18 8.5v7c0 1.38-1.12 2.5-2.5 2.5h-7C7.12 18 6 16.88 6 15.5v-7Z"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                />
                                <path
                                    d="M9 9h6M9 12h6M9 15h4"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

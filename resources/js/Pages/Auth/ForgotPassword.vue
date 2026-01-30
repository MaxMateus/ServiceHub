<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import kpmgLogo from '../../../images/logokpgm.svg';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <Head title="Recuperar senha" />

    <div
        class="relative min-h-screen bg-slate-100 text-slate-900"
        style="font-family: 'Sora', 'Figtree', ui-sans-serif; --accent: 30 64 175"
    >
        <div class="pointer-events-none absolute inset-0">
            <div
                class="absolute inset-0 bg-[linear-gradient(rgba(30,64,175,0.06)_1px,transparent_1px),linear-gradient(90deg,rgba(30,64,175,0.06)_1px,transparent_1px)] bg-[size:32px_32px]"
            ></div>
            <div
                class="absolute inset-0 bg-[radial-gradient(circle_at_15%_20%,rgba(59,130,246,0.16),transparent_50%),radial-gradient(circle_at_85%_80%,rgba(37,99,235,0.12),transparent_45%)]"
            ></div>
        </div>

        <div
            class="relative mx-auto flex min-h-screen w-full max-w-6xl flex-col items-center justify-center px-6 py-12"
        >
            <section class="w-full max-w-md">
                <div class="mb-6 flex items-center justify-center gap-3">
                    <img
                        :src="kpmgLogo"
                        alt="KPMG"
                        class="h-6 w-auto"
                    />
                    <div class="text-left">
                        <p class="text-lg font-semibold text-slate-800">ServiceHub</p>
                        <p class="text-xs uppercase tracking-[0.3em] text-slate-500">
                            Acesso
                        </p>
                    </div>
                </div>

                <div
                    class="rounded-[28px] border border-slate-300 bg-white p-8 shadow-2xl shadow-slate-200/80"
                >
                    <div class="flex items-start justify-between">
                        <div>
                            <h2 class="mt-3 text-2xl font-semibold text-slate-900">
                                Recuperar senha
                            </h2>
                            <p class="mt-2 text-sm text-slate-500">
                                Informe seu email para receber o link de redefinicao.
                            </p>
                        </div>
                        <div class="rounded-2xl bg-sky-700/10 p-3">
                            <svg
                                class="size-6 text-[rgb(var(--accent))]"
                                viewBox="0 0 24 24"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M7 10.5V9a5 5 0 0 1 10 0v1.5"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                />
                                <path
                                    d="M6 10.5h12a2 2 0 0 1 2 2v5.5a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-5.5a2 2 0 0 1 2-2Z"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                />
                                <path
                                    d="M12 14.75v1.5"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                />
                            </svg>
                        </div>
                    </div>

                    <div
                        v-if="status"
                        class="mt-6 rounded-2xl border border-sky-200 bg-sky-50 px-4 py-3 text-sm text-sky-800"
                    >
                        {{ status }}
                    </div>

                    <form @submit.prevent="submit" class="mt-6 space-y-5">
                        <div>
                            <label class="text-xs uppercase tracking-[0.2em] text-slate-500" for="email">
                                Email
                            </label>
                            <div class="relative mt-2">
                                <span
                                    class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"
                                >
                                    <svg
                                        class="size-4"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M4 6.75h16a1 1 0 0 1 1 1v8.5a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-8.5a1 1 0 0 1 1-1Z"
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                        />
                                        <path
                                            d="m5 8 7 5 7-5"
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        />
                                    </svg>
                                </span>
                                <input
                                    id="email"
                                    type="email"
                                    v-model="form.email"
                                    required
                                    autofocus
                                    autocomplete="username"
                                    placeholder="seu@email.com"
                                    class="w-full rounded-2xl border border-slate-300 bg-white py-3 pl-11 pr-4 text-sm text-slate-900 placeholder:text-slate-400 focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200"
                                />
                            </div>
                            <p v-if="form.errors.email" class="mt-2 text-xs text-rose-600">
                                {{ form.errors.email }}
                            </p>
                        </div>

                        <button
                            type="submit"
                            class="mt-2 w-full rounded-2xl border border-sky-800/80 bg-sky-700 px-6 py-3 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:bg-sky-800 hover:shadow-xl hover:shadow-sky-900/20 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sky-400/60"
                            :class="{ 'opacity-70': form.processing }"
                            :disabled="form.processing"
                        >
                            Enviar link de redefinicao
                        </button>
                    </form>

                    <div class="mt-6 text-center">
                        <p class="text-xs text-slate-500">
                            Lembrou da senha?
                        </p>
                        <Link
                            :href="route('login')"
                            class="mt-3 inline-flex w-full items-center justify-center rounded-2xl border border-slate-200/90 bg-white/90 px-6 py-3 text-sm font-semibold text-slate-700 transition hover:-translate-y-0.5 hover:border-sky-300 hover:text-sky-700 hover:shadow-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sky-300/60"
                        >
                            Voltar ao login
                        </Link>
                    </div>
                </div>

                <p class="mt-6 text-xs text-slate-500">
                    Ao continuar, voce concorda com as politicas de acesso internas.
                </p>
            </section>
        </div>
    </div>
</template>

<style>
@import url('https://fonts.bunny.net/css?family=sora:400,500,600,700&display=swap');
</style>

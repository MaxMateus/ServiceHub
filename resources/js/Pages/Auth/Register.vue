<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Criar conta" />

    <div
        class="relative min-h-screen overflow-hidden bg-slate-100 text-slate-900"
        style="font-family: 'Sora', 'Figtree', ui-sans-serif; --accent: 12 131 164"
    >
        <div class="pointer-events-none absolute inset-0">
            <div
                class="absolute -left-24 top-[-10rem] h-[26rem] w-[26rem] rounded-full bg-gradient-to-br from-sky-300/60 via-white/60 to-transparent blur-3xl"
            ></div>
            <div
                class="absolute right-[-6rem] top-[14rem] h-[22rem] w-[22rem] rounded-full bg-gradient-to-br from-amber-200/60 via-white/50 to-transparent blur-3xl"
            ></div>
            <div
                class="absolute bottom-[-12rem] left-1/2 h-[26rem] w-[26rem] -translate-x-1/2 rounded-full bg-gradient-to-br from-sky-200/60 via-white/50 to-transparent blur-3xl"
            ></div>
            <div class="absolute inset-0 bg-[linear-gradient(135deg,rgba(56,189,248,0.14),transparent_45%,rgba(251,191,36,0.1))]"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(2,132,199,0.12),transparent_60%)]"></div>
            <div class="absolute inset-0 bg-[linear-gradient(rgba(15,23,42,0.08)_1px,transparent_1px),linear-gradient(90deg,rgba(15,23,42,0.08)_1px,transparent_1px)] bg-[size:30px_30px] opacity-20"></div>
        </div>

        <div
            class="relative mx-auto flex min-h-screen w-full max-w-6xl flex-col items-center justify-center px-6 py-12"
        >
            <section class="w-full max-w-md">
                <div class="mb-6 flex items-center justify-center gap-3">
                    <div class="rounded-2xl border border-slate-200/80 bg-white/70 p-2 shadow-sm">
                        <svg
                            class="size-6 text-slate-700"
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
                    <div class="text-left">
                        <p class="text-lg font-semibold text-slate-900">ServiceHub</p>
                        <p class="text-xs uppercase tracking-[0.3em] text-slate-400">
                            Acesso
                        </p>
                    </div>
                </div>

                <div
                    class="rounded-[28px] border border-slate-200/80 bg-white/70 p-8 shadow-2xl backdrop-blur"
                >
                    <div class="flex items-start justify-between">
                        <div>
                            <h2 class="mt-3 text-2xl font-semibold text-slate-900">
                                Criar conta
                            </h2>
                            <p class="mt-2 text-sm text-slate-500">
                                Preencha os dados para acessar o ServiceHub.
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
                                    d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Z"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                />
                                <path
                                    d="M4 19a6 6 0 0 1 12 0"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                />
                                <path
                                    d="M18 8v4M16 10h4"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                />
                            </svg>
                        </div>
                    </div>

                    <form @submit.prevent="submit" class="mt-6 space-y-5">
                        <div>
                            <label class="text-xs uppercase tracking-[0.2em] text-slate-500" for="name">
                                Nome
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
                                            d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Z"
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                        />
                                        <path
                                            d="M4 19a8 8 0 0 1 16 0"
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                            stroke-linecap="round"
                                        />
                                    </svg>
                                </span>
                                <input
                                    id="name"
                                    type="text"
                                    v-model="form.name"
                                    required
                                    autofocus
                                    autocomplete="name"
                                    placeholder="Seu nome"
                                    class="w-full rounded-2xl border border-slate-300/80 bg-white/80 py-3 pl-11 pr-4 text-sm text-slate-900 placeholder:text-slate-400 focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200/70"
                                />
                            </div>
                            <p v-if="form.errors.name" class="mt-2 text-xs text-rose-600">
                                {{ form.errors.name }}
                            </p>
                        </div>

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
                                    autocomplete="username"
                                    placeholder="seu@email.com"
                                    class="w-full rounded-2xl border border-slate-300/80 bg-white/80 py-3 pl-11 pr-4 text-sm text-slate-900 placeholder:text-slate-400 focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200/70"
                                />
                            </div>
                            <p v-if="form.errors.email" class="mt-2 text-xs text-rose-600">
                                {{ form.errors.email }}
                            </p>
                        </div>

                        <div>
                            <label class="text-xs uppercase tracking-[0.2em] text-slate-500" for="password">
                                Senha
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
                                </span>
                                <input
                                    id="password"
                                    type="password"
                                    v-model="form.password"
                                    required
                                    autocomplete="new-password"
                                    placeholder="Sua senha"
                                    class="w-full rounded-2xl border border-slate-300/80 bg-white/80 py-3 pl-11 pr-4 text-sm text-slate-900 placeholder:text-slate-400 focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200/70"
                                />
                            </div>
                            <p v-if="form.errors.password" class="mt-2 text-xs text-rose-600">
                                {{ form.errors.password }}
                            </p>
                        </div>

                        <div>
                            <label class="text-xs uppercase tracking-[0.2em] text-slate-500" for="password_confirmation">
                                Confirmar senha
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
                                            d="M10.5 14.5 12 16l2.5-2.5"
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        />
                                    </svg>
                                </span>
                                <input
                                    id="password_confirmation"
                                    type="password"
                                    v-model="form.password_confirmation"
                                    required
                                    autocomplete="new-password"
                                    placeholder="Confirme sua senha"
                                    class="w-full rounded-2xl border border-slate-300/80 bg-white/80 py-3 pl-11 pr-4 text-sm text-slate-900 placeholder:text-slate-400 focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200/70"
                                />
                            </div>
                            <p v-if="form.errors.password_confirmation" class="mt-2 text-xs text-rose-600">
                                {{ form.errors.password_confirmation }}
                            </p>
                        </div>

                        <button
                            type="submit"
                            class="mt-2 w-full rounded-2xl border border-teal-600/40 bg-teal-700 px-6 py-3 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:bg-teal-600 hover:shadow-2xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-teal-400/60"
                            :class="{ 'opacity-70': form.processing }"
                            :disabled="form.processing"
                        >
                            Criar conta
                        </button>
                    </form>

                    <div class="mt-6 text-center">
                        <p class="text-xs text-slate-500">
                            Ja tem uma conta?
                        </p>
                        <Link
                            :href="route('login')"
                            class="mt-3 inline-flex w-full items-center justify-center rounded-2xl border border-slate-200/80 bg-white/70 px-6 py-3 text-sm font-semibold text-slate-700 transition hover:-translate-y-0.5 hover:border-teal-300/60 hover:text-teal-700 hover:shadow-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-teal-300/60"
                        >
                            Entrar
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

<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    mustVerifyEmail: Boolean,
    status: String,
    user: Object,
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    phone: props.user.profile?.phone ?? '',
    job_title: props.user.profile?.job_title ?? '',
    employee_id: props.user.profile?.employee_id ?? '',
    department: props.user.profile?.department ?? '',
});
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                Informações do Perfil
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Atualize os dados do seu perfil e o endereço de e-mail.
            </p>
        </header>

        <form
            @submit.prevent="form.patch(route('profile.update'))"
            class="mt-6 space-y-6"
        >
            <div>
                <InputLabel for="name" value="Nome" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="email" value="E-mail" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="grid grid-cols-6 gap-6">
                <!-- Telefone -->
                <div class="col-span-6 sm:col-span-3">
                    <InputLabel for="phone" value="Telefone" />
                    <TextInput id="phone" v-model="form.phone" class="mt-1 block w-full" />
                    <InputError class="mt-2" :message="form.errors.phone" />
                </div>

                <!-- Cargo -->
                <div class="col-span-6 sm:col-span-3">
                    <InputLabel for="job_title" value="Cargo" />
                    <TextInput id="job_title" v-model="form.job_title" class="mt-1 block w-full" />
                    <InputError class="mt-2" :message="form.errors.job_title" />
                </div>

                <!-- Matrícula -->
                <div class="col-span-6 sm:col-span-3">
                    <InputLabel for="employee_id" value="Matrícula" />
                    <TextInput id="employee_id" v-model="form.employee_id" class="mt-1 block w-full" />
                    <InputError class="mt-2" :message="form.errors.employee_id" />
                </div>

                <!-- Departamento -->
                <div class="col-span-6 sm:col-span-3">
                    <InputLabel for="department" value="Departamento" />
                    <TextInput id="department" v-model="form.department" class="mt-1 block w-full" />
                    <InputError class="mt-2" :message="form.errors.department" />
                </div>
            </div>

            <div v-if="mustVerifyEmail && props.user.email_verified_at === null">
                <p class="mt-2 text-sm text-gray-800">
                    Seu e-mail ainda não foi verificado.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Clique aqui para reenviar o e-mail de verificação.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 text-sm font-medium text-green-600"
                >
                    Um novo link de verificação foi enviado para seu e-mail.
                </div>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Salvar</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm text-gray-600"
                    >
                        Salvo.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>

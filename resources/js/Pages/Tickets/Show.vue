<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, router, useForm } from '@inertiajs/vue3'

const props = defineProps({
  ticket: Object,
})

const form = useForm({
  title: props.ticket.title,
  description: props.ticket.description,
  assigned_to: props.ticket.assigned_to?.id ?? '',
})

function submitUpdate() {
  form.patch(route('tickets.update', props.ticket.id), {
    preserveScroll: true,
  })
}

function deleteTicket() {
  if (!confirm('Tem certeza que deseja excluir este ticket?')) return
  router.delete(route('tickets.destroy', props.ticket.id))
}
</script>

<template>
  <AuthenticatedLayout>
    <Head :title="`Ticket #${props.ticket.id}`" />

    <div class="py-8">
      <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
          <div>
            <h1 class="text-2xl font-semibold text-slate-900">
              Ticket #{{ props.ticket.id }} - {{ props.ticket.title }}
            </h1>
            <p class="text-sm text-slate-600">
              {{ props.ticket.company?.name || 'Empresa não informada' }} • {{ props.ticket.project?.name || 'Projeto não informado' }}
            </p>
          </div>
          <div class="flex gap-2">
            <button
              type="button"
              class="inline-flex items-center rounded-md border border-rose-200 bg-rose-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-rose-700"
              @click="deleteTicket"
            >
              Excluir
            </button>
            <button
              type="button"
              class="inline-flex items-center rounded-md border border-sky-700 bg-sky-700 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-800"
              @click="submitUpdate"
              :disabled="form.processing"
            >
              {{ form.processing ? 'Salvando...' : 'Salvar alterações' }}
            </button>
          </div>
        </div>

        <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
          <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm lg:col-span-2">
            <h2 class="text-sm font-semibold text-slate-700 uppercase tracking-wide">Informações</h2>
            <div class="mt-4 grid grid-cols-1 gap-3 md:grid-cols-2 text-sm text-slate-700">
              <div>
                <p class="text-slate-500">Company</p>
                <p class="font-semibold">{{ props.ticket.company?.name || '-' }}</p>
              </div>
              <div>
                <p class="text-slate-500">Project</p>
                <p class="font-semibold">{{ props.ticket.project?.name || '-' }}</p>
              </div>
              <div>
                <p class="text-slate-500">Criado por</p>
                <p class="font-semibold">{{ props.ticket.created_by?.name || '-' }}</p>
              </div>
              <div>
                <p class="text-slate-500">Responsável</p>
                <p class="font-semibold">{{ props.ticket.assigned_to?.name || 'Não atribuído' }}</p>
              </div>
              <div>
                <p class="text-slate-500">Criado em</p>
                <p class="font-semibold">{{ props.ticket.created_at }}</p>
              </div>
            </div>

            <div class="mt-6 space-y-3">
              <label class="text-sm font-semibold text-slate-700" for="title">Título</label>
              <input
                id="title"
                v-model="form.title"
                type="text"
                class="w-full rounded-md border-slate-300 shadow-sm focus:border-sky-600 focus:ring-sky-600 text-sm"
              >
              <p v-if="form.errors.title" class="text-xs text-rose-600">{{ form.errors.title }}</p>
            </div>

            <div class="mt-4 space-y-3">
              <label class="text-sm font-semibold text-slate-700" for="description">Descrição</label>
              <textarea
                id="description"
                v-model="form.description"
                rows="5"
                class="w-full rounded-md border-slate-300 shadow-sm focus:border-sky-600 focus:ring-sky-600 text-sm"
              />
              <p v-if="form.errors.description" class="text-xs text-rose-600">{{ form.errors.description }}</p>
            </div>

            <div class="mt-4 space-y-3">
              <label class="text-sm font-semibold text-slate-700" for="assigned_to">Responsável</label>
              <select
                id="assigned_to"
                v-model="form.assigned_to"
                class="w-full rounded-md border-slate-300 shadow-sm focus:border-sky-600 focus:ring-sky-600 text-sm"
              >
                <option value="">Não atribuído</option>
                <option
                  v-for="user in props.ticket.available_users || []"
                  :key="user.id"
                  :value="user.id"
                >
                  {{ user.name }}
                </option>
              </select>
              <p v-if="form.errors.assigned_to" class="text-xs text-rose-600">{{ form.errors.assigned_to }}</p>
            </div>
          </div>

          <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm space-y-3">
            <h2 class="text-sm font-semibold text-slate-700 uppercase tracking-wide">Detalhes técnicos processados</h2>
            <div v-if="props.ticket.detail" class="space-y-2">
              <p class="text-xs text-slate-500">Processado em: <span class="font-semibold text-slate-800">{{ props.ticket.detail.processed_at }}</span></p>
              <pre class="rounded-md bg-slate-50 p-3 text-xs text-slate-800 overflow-auto">{{ props.ticket.detail.details }}</pre>
            </div>
            <div v-else class="text-sm text-slate-600">
              Detalhes ainda não processados.
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

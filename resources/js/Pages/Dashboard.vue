<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link } from '@inertiajs/vue3'

const props = defineProps({
  stats: {
    type: Object,
    default: () => ({
      companiesCount: 0,
      projectsCount: 0,
      ticketsCount: 0,
    }),
  },
  recentTickets: {
    type: Array,
    default: () => [
      {
        id: 10,
        title: 'Servidor fora do ar',
        company: { name: 'Empresa X' },
        project: { name: 'Projeto API' },
        status: 'Aberto',
        assigned_to: { name: 'Maria Souza' },
        created_at: '29/01/2026 10:30',
      },
      {
        id: 9,
        title: 'Erro de autenticação',
        company: { name: 'Empresa Y' },
        project: { name: 'Projeto Z' },
        status: 'Em andamento',
        assigned_to: { name: 'Roberto Costa' },
        created_at: '28/01/2026 15:20',
      },
      {
        id: 8,
        title: 'Backup falhou',
        company: { name: 'Empresa Z' },
        project: { name: 'Sistema de Backup' },
        status: 'Aberto',
        assigned_to: { name: 'Amanda Lima' },
        created_at: '28/01/2026 09:45',
      },
      {
        id: 7,
        title: 'API não responde',
        company: { name: 'Empresa X' },
        project: { name: 'Projeto API' },
        status: 'Fechado',
        assigned_to: { name: 'Carlos Santos' },
        created_at: '27/01/2026 18:10',
      },
    ],
  },
})

const statusClasses = {
  Aberto: 'bg-amber-100 text-amber-800 ring-1 ring-amber-200',
  'Em andamento': 'bg-emerald-100 text-emerald-800 ring-1 ring-emerald-200',
  Fechado: 'bg-slate-200 text-slate-800 ring-1 ring-slate-300',
}
</script>

<template>
  <AuthenticatedLayout>
    <Head title="Dashboard" />

    <div class="py-8">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white/95 border border-slate-200 rounded-2xl shadow-xl shadow-slate-200/70 backdrop-blur-sm">
          <div class="p-6 lg:p-8 space-y-6">
            <!-- HEADER + AÇÕES RÁPIDAS -->
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
              <div class="space-y-1">
                <h1 class="text-3xl font-semibold text-slate-900">
                  Dashboard
                </h1>
                <p class="text-sm text-slate-600">
                  Visão geral do ServiceHub e atalhos rápidos.
                </p>
              </div>

              <div class="flex flex-wrap gap-2">
                <Link
                  href="#"
                  class="inline-flex items-center gap-2 rounded-md border border-slate-200 bg-white px-3.5 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50"
                >
                  <span class="text-base leading-none">+</span>
                  Nova Company
                </Link>

                <Link
                  href="#"
                  class="inline-flex items-center gap-2 rounded-md border border-slate-200 bg-white px-3.5 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50"
                >
                  <span class="text-base leading-none">+</span>
                  Novo Project
                </Link>

                <Link
                  href="#"
                  class="inline-flex items-center gap-2 rounded-md bg-sky-700 px-3.5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-700"
                >
                  <span class="text-base leading-none">+</span>
                  Novo Ticket
                </Link>
              </div>
            </div>

            <!-- CARDS DE STATS -->
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
              <div class="overflow-hidden rounded-xl border border-slate-200 shadow-md">
                <div class="flex items-center justify-between gap-3 bg-sky-700 px-5 py-4 text-white">
                  <div class="flex items-center gap-3">
                    <span class="text-3xl font-semibold">
                      {{ props.stats.companiesCount }}
                    </span>
                    <span class="text-lg font-semibold">
                      Companies
                    </span>
                  </div>
                </div>
                <div class="bg-slate-50 px-5 py-3 text-sm text-slate-600">
                  Total de empresas cadastradas
                </div>
              </div>

              <div class="overflow-hidden rounded-xl border border-slate-200 shadow-md">
                <div class="flex items-center justify-between gap-3 bg-emerald-600 px-5 py-4 text-white">
                  <div class="flex items-center gap-3">
                    <span class="text-3xl font-semibold">
                      {{ props.stats.projectsCount }}
                    </span>
                    <span class="text-lg font-semibold">
                      Projects
                    </span>
                  </div>
                </div>
                <div class="bg-slate-50 px-5 py-3 text-sm text-slate-600">
                  Projetos vinculados às empresas
                </div>
              </div>

              <div class="overflow-hidden rounded-xl border border-slate-200 shadow-md">
                <div class="flex items-center justify-between gap-3 bg-orange-600 px-5 py-4 text-white">
                  <div class="flex items-center gap-3">
                    <span class="text-3xl font-semibold">
                      {{ props.stats.ticketsCount }}
                    </span>
                    <span class="text-lg font-semibold">
                      Tickets
                    </span>
                  </div>
                </div>
                <div class="bg-slate-50 px-5 py-3 text-sm text-slate-600">
                  Ordens de serviço registradas
                </div>
              </div>
            </div>

            <!-- TABELA DE ÚLTIMOS TICKETS -->
            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-md">
              <div class="flex items-center justify-between gap-4 border-b border-slate-200 bg-slate-50 px-5 py-4">
                <h2 class="text-xl font-semibold text-slate-900">
                  Últimos Tickets
                </h2>

                <Link
                  href="#"
                  class="text-sm font-semibold text-sky-700 hover:text-sky-800"
                >
                  Ver todos os tickets
                </Link>
              </div>

              <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-slate-800">
                  <thead class="bg-slate-100 text-xs font-semibold uppercase tracking-wide text-slate-600">
                    <tr>
                      <th class="px-4 py-3 text-left">ID</th>
                      <th class="px-4 py-3 text-left">Título</th>
                      <th class="px-4 py-3 text-left">Company</th>
                      <th class="px-4 py-3 text-left">Project</th>
                      <th class="px-4 py-3 text-left">Status</th>
                      <th class="px-4 py-3 text-left">Responsável</th>
                      <th class="px-4 py-3 text-left">Criado em</th>
                      <th class="px-4 py-3 text-right">Ações</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-slate-100">
                    <tr
                      v-for="ticket in props.recentTickets"
                      :key="ticket.id"
                      class="odd:bg-white even:bg-slate-50/60 hover:bg-slate-50 transition-colors"
                    >
                      <td class="px-4 py-3 font-semibold text-slate-800">
                        #{{ ticket.id }}
                      </td>
                      <td class="px-4 py-3 text-sky-800 font-semibold">
                        {{ ticket.title }}
                      </td>
                      <td class="px-4 py-3 text-sky-700 font-semibold">
                        {{ ticket.company?.name || '-' }}
                      </td>
                      <td class="px-4 py-3 text-slate-700">
                        {{ ticket.project?.name || '-' }}
                      </td>
                      <td class="px-4 py-3">
                        <span
                          class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1"
                          :class="statusClasses[ticket.status] ?? 'bg-slate-100 text-slate-700 ring-slate-200'"
                        >
                          {{ ticket.status }}
                        </span>
                      </td>
                      <td class="px-4 py-3 text-slate-700">
                        {{ ticket.assigned_to?.name || '-' }}
                      </td>
                      <td class="px-4 py-3 text-slate-600">
                        {{ ticket.created_at }}
                      </td>
                      <td class="px-4 py-3">
                        <div class="flex justify-end gap-2">
                          <Link
                            href="#"
                            class="inline-flex items-center rounded-md bg-sky-700 px-3 py-1 text-xs font-semibold text-white shadow-sm hover:bg-sky-800"
                          >
                            Ver
                          </Link>
                          <button
                            type="button"
                            class="inline-flex items-center justify-center rounded-md border border-slate-200 bg-white px-2.5 py-1 text-slate-600 shadow-sm hover:bg-slate-50"
                            aria-label="Mais ações"
                          >
                            ⋮
                          </button>
                        </div>
                      </td>
                    </tr>

                    <tr v-if="!props.recentTickets.length">
                      <td
                        colspan="8"
                        class="px-4 py-8 text-center text-sm text-slate-500"
                      >
                        Nenhum ticket recente.
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, useForm, usePage } from '@inertiajs/vue3'
import { computed, reactive, ref, watch } from 'vue'

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
  companies: {
    type: Array,
    default: () => [],
  },
  projects: {
    type: Array,
    default: () => [],
  },
  users: {
    type: Array,
    default: () => [],
  },
})

const page = usePage()
const flash = computed(() => page.props.flash || {})
const companies = computed(() => props.companies || [])
const projects = computed(() => props.projects || [])
const users = computed(() => props.users || [])
const filteredProjects = computed(() =>
  ticketForm.company_id
    ? projects.value.filter((project) => project.company_id === ticketForm.company_id)
    : []
)
const toast = reactive({
  show: false,
  message: '',
  detail: '',
})
let toastTimer = null

watch(
  () => flash.value?.success,
  (success) => {
    if (success) {
      const detail =
        flash.value?.success_detail ||
        (success.toLowerCase().includes('ticket')
          ? 'Assim que concluído, você receberá um e-mail com a atualização do ticket.'
          : '')

      showToast(success, detail)
    }
  },
  { immediate: true }
)

const isCompanyModalOpen = ref(false)
const isProjectModalOpen = ref(false)
const isTicketModalOpen = ref(false)

const companyForm = useForm({
  name: '',
  cnpj: '',
})
const projectForm = useForm({
  company_id: '',
  name: '',
  description: '',
})
const ticketForm = useForm({
  company_id: '',
  project_id: '',
  title: '',
  description: '',
  assigned_to: '',
  attachment: null,
})

function openCompanyModal() {
  isCompanyModalOpen.value = true
}

function closeCompanyModal() {
  isCompanyModalOpen.value = false
  companyForm.reset()
  companyForm.clearErrors()
}

function submitCompany() {
  companyForm.post(route('companies.store'), {
    onSuccess: () => {
      closeCompanyModal()
      showToast('Empresa criada com sucesso.', 'Você já pode vincular projetos a esta empresa.')
    },
  })
}

function openProjectModal() {
  isProjectModalOpen.value = true
}

function closeProjectModal() {
  isProjectModalOpen.value = false
  projectForm.reset()
  projectForm.clearErrors()
}

function submitProject() {
  projectForm.post(route('projects.store'), {
    onSuccess: () => {
      closeProjectModal()
      showToast('Projeto criado com sucesso.', 'Agora você pode adicionar tickets vinculados a este projeto.')
    },
  })
}

function openTicketModal() {
  isTicketModalOpen.value = true
}

function closeTicketModal() {
  isTicketModalOpen.value = false
  ticketForm.reset()
  ticketForm.clearErrors()
}

function onAttachmentChange(event) {
  const file = event.target.files?.[0]
  ticketForm.attachment = file || null
}

watch(
  () => ticketForm.company_id,
  () => {
    if (!filteredProjects.value.find((p) => p.id === ticketForm.project_id)) {
      ticketForm.project_id = ''
    }
  }
)

function submitTicket() {
  ticketForm.post(route('tickets.store'), {
    onSuccess: () => {
      closeTicketModal()
      showToast(
        'Ticket criado com sucesso.',
        'Assim que o processamento do anexo for concluídos, você receberá um e-mail com a atualização.'
      )
    },
    forceFormData: true,
  })
}

function showToast(message, detail = '') {
  toast.message = message
  toast.detail = detail
  toast.show = true
  if (toastTimer) clearTimeout(toastTimer)
  toastTimer = setTimeout(() => {
    toast.show = false
  }, 10000)
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
                <button
                  type="button"
                  class="inline-flex items-center gap-2 rounded-md border border-slate-200 bg-white px-3.5 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 hover:-translate-y-0.5 hover:shadow-md transition"
                  @click="openCompanyModal"
                >
                  <span class="text-base leading-none">+</span>
                  Nova Company
                </button>

                <button
                  type="button"
                  class="inline-flex items-center gap-2 rounded-md border border-slate-200 bg-white px-3.5 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 hover:-translate-y-0.5 hover:shadow-md transition"
                  @click="openProjectModal"
                >
                  <span class="text-base leading-none">+</span>
                  Novo Project
                </button>

                <button
                  type="button"
                  class="inline-flex items-center gap-2 rounded-md bg-sky-700 px-3.5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-800 hover:-translate-y-0.5 hover:shadow-lg transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-700"
                  @click="openTicketModal"
                >
                  <span class="text-base leading-none">+</span>
                  Novo Ticket
                </button>
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
                      <td class="px-4 py-3 text-slate-700">
                        {{ ticket.assigned_to?.name || '-' }}
                      </td>
                      <td class="px-4 py-3 text-slate-600">
                        {{ ticket.created_at }}
                      </td>
                      <td class="px-4 py-3">
                        <div class="flex justify-end gap-2">
                          <Link
                            :href="route('tickets.show', ticket.id)"
                            class="inline-flex items-center rounded-md bg-sky-700 px-3 py-1 text-xs font-semibold text-white shadow-sm hover:bg-sky-800"
                          >
                            Ver
                          </Link>
                        </div>
                      </td>
                    </tr>

                    <tr v-if="!props.recentTickets.length">
                      <td
                        colspan="7"
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

    <div
      v-if="isCompanyModalOpen"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
    >
      <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 border border-slate-200">
        <h2 class="text-lg font-semibold text-slate-900 mb-4">
          Nova Company
        </h2>

        <form @submit.prevent="submitCompany" class="space-y-4">
          <!-- Campo Nome -->
          <div>
            <label class="block text-sm font-medium text-slate-700">
              Nome <span class="text-rose-500">*</span>
            </label>
            <input
              v-model="companyForm.name"
              type="text"
              class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-sky-600 focus:ring-sky-600 text-sm"
              :class="{ 'border-rose-500': companyForm.errors.name }"
            >
            <p
              v-if="companyForm.errors.name"
              class="mt-1 text-xs text-rose-600"
            >
              {{ companyForm.errors.name }}
            </p>
          </div>

          <!-- Campo CNPJ -->
          <div>
            <label class="block text-sm font-medium text-slate-700">
              CNPJ
            </label>
            <input
              v-model="companyForm.cnpj"
              type="text"
              class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-sky-600 focus:ring-sky-600 text-sm"
              :class="{ 'border-rose-500': companyForm.errors.cnpj }"
            >
            <p
              v-if="companyForm.errors.cnpj"
              class="mt-1 text-xs text-rose-600"
            >
              {{ companyForm.errors.cnpj }}
            </p>
          </div>

          <!-- Botões -->
          <div class="flex justify-end gap-2 pt-2">
            <button
              type="button"
              class="inline-flex items-center rounded-md border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50"
              @click="closeCompanyModal"
              :disabled="companyForm.processing"
            >
              Cancelar
            </button>

            <button
              type="submit"
              class="inline-flex items-center rounded-md bg-sky-700 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-800 disabled:opacity-60"
              :disabled="companyForm.processing"
            >
              <span v-if="companyForm.processing">Salvando...</span>
              <span v-else>Salvar</span>
            </button>
          </div>
        </form>
      </div>
    </div>

    <div
      v-if="isProjectModalOpen"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
    >
      <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 border border-slate-200">
        <h2 class="text-lg font-semibold text-slate-900 mb-4">
          Novo Project
        </h2>

        <form @submit.prevent="submitProject" class="space-y-4">
          <!-- Company -->
          <div>
            <label class="block text-sm font-medium text-slate-700">
              Company <span class="text-rose-500">*</span>
            </label>
            <select
              v-model="projectForm.company_id"
              class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-sky-600 focus:ring-sky-600 text-sm"
              :class="{ 'border-rose-500': projectForm.errors.company_id }"
            >
              <option value="">Selecione uma empresa</option>
              <option
                v-for="company in companies"
                :key="company.id"
                :value="company.id"
              >
                {{ company.name }}
              </option>
            </select>
            <p
              v-if="projectForm.errors.company_id"
              class="mt-1 text-xs text-rose-600"
            >
              {{ projectForm.errors.company_id }}
            </p>
          </div>

          <!-- Nome -->
          <div>
            <label class="block text-sm font-medium text-slate-700">
              Nome do Project <span class="text-rose-500">*</span>
            </label>
            <input
              v-model="projectForm.name"
              type="text"
              class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-sky-600 focus:ring-sky-600 text-sm"
              :class="{ 'border-rose-500': projectForm.errors.name }"
            >
            <p
              v-if="projectForm.errors.name"
              class="mt-1 text-xs text-rose-600"
            >
              {{ projectForm.errors.name }}
            </p>
          </div>

          <!-- Descrição -->
          <div>
            <label class="block text-sm font-medium text-slate-700">
              Descrição
            </label>
            <textarea
              v-model="projectForm.description"
              rows="3"
              class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-sky-600 focus:ring-sky-600 text-sm"
              :class="{ 'border-rose-500': projectForm.errors.description }"
            />
            <p
              v-if="projectForm.errors.description"
              class="mt-1 text-xs text-rose-600"
            >
              {{ projectForm.errors.description }}
            </p>
          </div>

          <!-- Botões -->
          <div class="flex justify-end gap-2 pt-2">
            <button
              type="button"
              class="inline-flex items-center rounded-md border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50"
              @click="closeProjectModal"
              :disabled="projectForm.processing"
            >
              Cancelar
            </button>

            <button
              type="submit"
              class="inline-flex items-center rounded-md bg-sky-700 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-800 disabled:opacity-60"
              :disabled="projectForm.processing"
            >
              <span v-if="projectForm.processing">Salvando...</span>
              <span v-else>Salvar</span>
            </button>
          </div>
        </form>
      </div>
    </div>

    <div
      v-if="isTicketModalOpen"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
    >
      <div class="bg-white rounded-2xl shadow-2xl max-w-xl w-full p-6 border border-slate-200">
        <h2 class="text-lg font-semibold text-slate-900 mb-4">
          Novo Ticket
        </h2>

        <form @submit.prevent="submitTicket" class="space-y-4">
          <!-- Company (opcional, só UX) -->
          <div>
            <label class="block text-sm font-medium text-slate-700">
              Company
            </label>
            <select
              v-model="ticketForm.company_id"
              class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-sky-600 focus:ring-sky-600 text-sm"
            >
              <option value="">Selecione uma empresa (opcional)</option>
              <option
                v-for="company in companies"
                :key="company.id"
                :value="company.id"
              >
                {{ company.name }}
              </option>
            </select>
          </div>

          <!-- Project -->
          <div>
            <label class="block text-sm font-medium text-slate-700">
              Project <span class="text-rose-500">*</span>
            </label>
          <select
            v-model="ticketForm.project_id"
            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-sky-600 focus:ring-sky-600 text-sm"
            :class="{ 'border-rose-500': ticketForm.errors.project_id }"
            :disabled="!ticketForm.company_id || !filteredProjects.length"
          >
            <option value="">Selecione um projeto</option>
            <option
              v-for="project in filteredProjects"
              :key="project.id"
              :value="project.id"
            >
              {{ project.name }}
            </option>
          </select>
          <p
            v-if="ticketForm.company_id && !filteredProjects.length"
            class="mt-1 text-xs text-slate-500"
          >
            Nenhum projeto cadastrado para esta empresa.
          </p>
          <p
            v-if="ticketForm.errors.project_id"
            class="mt-1 text-xs text-rose-600"
          >
            {{ ticketForm.errors.project_id }}
            </p>
          </div>

          <!-- Título -->
          <div>
            <label class="block text-sm font-medium text-slate-700">
              Título <span class="text-rose-500">*</span>
            </label>
            <input
              v-model="ticketForm.title"
              type="text"
              class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-sky-600 focus:ring-sky-600 text-sm"
              :class="{ 'border-rose-500': ticketForm.errors.title }"
            >
            <p
              v-if="ticketForm.errors.title"
              class="mt-1 text-xs text-rose-600"
            >
              {{ ticketForm.errors.title }}
            </p>
          </div>

          <!-- Descrição -->
          <div>
            <label class="block text-sm font-medium text-slate-700">
              Descrição do problema <span class="text-rose-500">*</span>
            </label>
            <textarea
              v-model="ticketForm.description"
              rows="4"
              class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-sky-600 focus:ring-sky-600 text-sm"
              :class="{ 'border-rose-500': ticketForm.errors.description }"
            />
            <p
              v-if="ticketForm.errors.description"
              class="mt-1 text-xs text-rose-600"
            >
              {{ ticketForm.errors.description }}
            </p>
          </div>

          <!-- Responsável -->
          <div>
            <label class="block text-sm font-medium text-slate-700">
              Responsável
            </label>
            <select
              v-model="ticketForm.assigned_to"
              class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-sky-600 focus:ring-sky-600 text-sm"
              :class="{ 'border-rose-500': ticketForm.errors.assigned_to }"
            >
              <option value="">Não atribuído</option>
              <option
                v-for="user in users"
                :key="user.id"
                :value="user.id"
              >
                {{ user.name }}
              </option>
            </select>
            <p
              v-if="ticketForm.errors.assigned_to"
              class="mt-1 text-xs text-rose-600"
            >
              {{ ticketForm.errors.assigned_to }}
            </p>
          </div>

          <!-- Anexo -->
          <div>
            <label class="block text-sm font-medium text-slate-700">
              Anexo (JSON ou TXT)
            </label>
            <input
              type="file"
              accept=".json,.txt"
              class="mt-1 block w-full text-sm text-slate-700 file:mr-3 file:rounded-md file:border file:border-slate-200 file:bg-slate-50 file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-slate-700 hover:file:bg-slate-100"
              @change="onAttachmentChange"
            >
            <p
              v-if="ticketForm.errors.attachment"
              class="mt-1 text-xs text-rose-600"
            >
              {{ ticketForm.errors.attachment }}
            </p>
          </div>

          <!-- Botões -->
          <div class="flex justify-end gap-2 pt-2">
            <button
              type="button"
              class="inline-flex items-center rounded-md border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50"
              @click="closeTicketModal"
              :disabled="ticketForm.processing"
            >
              Cancelar
            </button>

            <button
              type="submit"
              class="inline-flex items-center rounded-md bg-sky-700 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-800 disabled:opacity-60"
              :disabled="ticketForm.processing"
            >
              <span v-if="ticketForm.processing">Salvando...</span>
              <span v-else>Salvar</span>
            </button>
          </div>
        </form>
      </div>
    </div>

  </AuthenticatedLayout>

  <Transition
    enter-active-class="transform transition duration-200 ease-out"
    enter-from-class="translate-y-3 opacity-0"
    enter-to-class="translate-y-0 opacity-100"
    leave-active-class="transform transition duration-150 ease-in"
    leave-from-class="translate-y-0 opacity-100"
    leave-to-class="translate-y-3 opacity-0"
  >
    <div
      v-if="toast.show"
      class="fixed bottom-8 right-8 z-50 w-full max-w-md rounded-2xl border border-sky-200 bg-white shadow-2xl shadow-sky-200/70"
    >
      <div class="flex items-start gap-3 p-4">
        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-100 text-sky-700">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path
              fill-rule="evenodd"
              d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 10-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
              clip-rule="evenodd"
            />
          </svg>
        </div>
        <div class="flex-1">
          <p class="text-sm font-semibold text-sky-900">
            {{ toast.message }}
          </p>
          <p
            v-if="toast.detail"
            class="mt-1 text-xs text-slate-600"
          >
            {{ toast.detail }}
          </p>
        </div>
        <button
          type="button"
          class="rounded-md p-1 text-slate-400 transition hover:bg-slate-100 hover:text-slate-600"
          @click="toast.show = false"
          aria-label="Fechar"
        >
          ×
        </button>
      </div>
    </div>
  </Transition>
</template>

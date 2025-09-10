<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, usePage } from '@inertiajs/vue3'
import { ref, computed, onMounted } from 'vue'
import { type BreadcrumbItem } from '@/types'

// Importa el modal
import CrearEmpleado from './crearEmpleado.vue'

const page = usePage()

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Empleados', href: '/empleados' },
]

// Datos iniciales
const employees = ref(page.props?.empleados ?? [
  { name: "Emily Harper", position: "Pharmacist", area: "Pharmacy", role: "Staff", username: "emily.harper", status: "Activo" },
  { name: "Owen Foster", position: "Technician", area: "Pharmacy", role: "Technician", username: "owen.foster", status: "Activo" },
  { name: "Chloe Bennett", position: "Manager", area: "Admin", role: "Manager", username: "chloe.bennett", status: "Inactivo" },
])

// Filtros
const filters = ref({
  area: "",
  role: "",
  search: "",
})

// Filtrado
const filteredEmployees = computed(() => {
  return employees.value.filter(emp => {
    return (
      (!filters.value.area || emp.area.toLowerCase().includes(filters.value.area.toLowerCase())) &&
      (!filters.value.role || emp.role.toLowerCase().includes(filters.value.role.toLowerCase())) &&
      (!filters.value.search ||
        emp.name.toLowerCase().includes(filters.value.search.toLowerCase()) ||
        emp.username.toLowerCase().includes(filters.value.search.toLowerCase()))
    )
  })
})

// Control del modal desde Index.vue
const showCrearEmpleadoModal = ref(false)

// Cargar empleados desde API
onMounted(async () => {
  const res = await fetch('/api/empleados')
  if (res.ok) employees.value = await res.json()
})
</script>

<template>
  <Head title="Empleados" />

  <AppLayout :breadcrumbs="breadcrumbs">
  <!-- Modal de Crear Empleado -->
  <CrearEmpleado
    v-if="showCrearEmpleadoModal"
    :showModalProp="showCrearEmpleadoModal"
    @close="showCrearEmpleadoModal = false"
  />

    <div class="min-h-screen bg-[#f8fafc] flex flex-col">
      <!-- Header & Actions -->
      <section class="w-full max-w-6xl mx-auto px-4 pt-8 pb-2 flex flex-col md:flex-row md:items-center md:justify-between">
        <h1 class="text-2xl md:text-3xl font-bold text-[#111714]">Gestión de Empleados</h1>
        <div class="flex gap-2 mt-3 md:mt-0">
          <button
            @click="showCrearEmpleadoModal = true"
            class="rounded-lg h-10 px-4 bg-[#38e07b] text-white text-sm font-bold hover:bg-[#2ecc71] transition"
          >
            Registrar Empleado
          </button>
          <button class="rounded-lg h-10 px-4 bg-[#f0f4f2] text-[#111714] text-sm font-bold hover:bg-[#e2e8f0] transition">
            Actualizar Lista
          </button>
        </div>
      </section>

      <!-- Filters & Search -->
      <section class="w-full max-w-6xl mx-auto px-4 py-4 flex flex-col md:flex-row md:items-end gap-4">
        <div class="flex flex-1 gap-4">
          <label class="flex flex-col flex-1 min-w-32">
            <span class="text-[#111714] text-base font-medium pb-2">Area</span>
            <select v-model="filters.area" class="form-select rounded-lg border border-[#dce5df] h-12 px-3 bg-white">
              <option value="">Seleccionar Area</option>
              <option value="Ventas">Ventas</option>
              <option value="Bodega">Bodega</option>
            </select>
          </label>
          <label class="flex flex-col flex-1 min-w-32">
            <span class="text-[#111714] text-base font-medium pb-2">Rol</span>
            <select v-model="filters.role" class="form-select rounded-lg border border-[#dce5df] h-12 px-3 bg-white">
              <option value="">Seleccionar rol</option>
              <option value="empleado">Empleado</option>
              <option value="administrador">Administrador</option>
            </select>
          </label>
          <label class="flex flex-col flex-1 min-w-32">
            <span class="text-[#111714] text-base font-medium pb-2">Periodo</span>
            <input v-model="filters.periodo" placeholder="Seleccionar Periodo" class="form-input rounded-lg border border-[#dce5df] h-12 px-3 bg-white" />
          </label>
        </div>
        <div class="flex-1">
          <label class="flex flex-col w-full">
            <span class="sr-only">Search</span>
            <div class="flex items-center rounded-lg bg-[#f0f4f2]">
              <!-- Icono de lupa -->
              <svg class="w-5 h-5 text-[#648772] ml-3 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2" fill="none"/>
                <line x1="16.5" y1="16.5" x2="21" y2="21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              </svg>
              <input v-model="filters.search" placeholder="Buscar empleado..." class="form-input w-full bg-[#f0f4f2] h-12 px-4 pl-0" />
            </div>
          </label>
        </div>
      </section>

      <!-- Employee List -->
      <section class="w-full max-w-6xl mx-auto px-4 py-4 flex-1 flex flex-col">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-2">
          <h2 class="text-[#111714] text-lg font-bold">Lista de Empleados</h2>
          <p class="text-[#648772] text-sm mt-1 md:mt-0">
            Empleados activos: {{ employees.length }}
          </p>
        </div>
        <div class="overflow-x-auto bg-white rounded-lg shadow border border-[#dce5df]">
          <table class="min-w-full divide-y divide-[#dce5df]">
            <thead class="bg-[#f0f4f2]">
              <tr>
                <th class="px-4 py-3 text-left text-sm font-semibold text-[#111714]">Nombre completo</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-[#111714]">Posición</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-[#111714]">Area</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-[#111714]">Rol</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-[#111714]">Usuario</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-[#111714]">Estado</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-[#111714]">Fecha de creación</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(emp, index) in filteredEmployees" :key="index" class="hover:bg-[#f8fafc] transition">
                <td class="px-4 py-2 whitespace-nowrap">{{ emp.name }}</td>
                <td class="px-4 py-2 text-[#648772] whitespace-nowrap">{{ emp.position }}</td>
                <td class="px-4 py-2 text-[#648772] whitespace-nowrap">{{ emp.area }}</td>
                <td class="px-4 py-2 text-[#648772] whitespace-nowrap">{{ emp.role }}</td>
                <td class="px-4 py-2 text-[#648772] whitespace-nowrap">{{ emp.username }}</td>
                <td class="px-4 py-2">
                  <span
                    :class="emp.status === 'Active' ? 'bg-[#38e07b] text-white' : 'bg-[#f0f4f2] text-[#648772]'"
                    class="rounded-lg h-8 px-4 text-sm inline-flex items-center justify-center"
                  >
                    {{ emp.status }}
                  </span>
                </td>
                <td class="px-4 py-2 text-[#648772] whitespace-nowrap">
                  {{ emp.created_at ? emp.created_at : '—' }}
                </td>
              </tr>
              <tr v-if="filteredEmployees.length === 0">
                <td colspan="7" class="px-4 py-6 text-center text-[#648772]">
                  No employees found.
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'
import { Head } from '@inertiajs/vue3'
import { ref, onMounted } from 'vue'
import { Users } from 'lucide-vue-next'
import { usePage } from '@inertiajs/vue3'

const page = usePage()

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Empleados',
    href: '/empleados',
  },
]

const empleados = ref(page.props?.empleados ?? [])

onMounted(async () => {
  const res = await fetch('/api/empleados')
  if (res.ok) empleados.value = await res.json()
})
</script>

<template>
  <Head title="Empleados" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-4">
      <h1 class="text-2xl font-bold flex items-center gap-2">
        <Users class="w-6 h-6" /> Empleados
      </h1>

      <ul class="mt-4 space-y-2">
        <li v-for="empleado in empleados" :key="empleado.id" class="p-2 border rounded">
          {{ empleado.nombre }}
        </li>
      </ul>
    </div>
  </AppLayout>
</template>

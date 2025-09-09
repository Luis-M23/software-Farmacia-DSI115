<script setup lang="ts">
import ViewProducts from '@/pages/Products/View.vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'
import { Head } from '@inertiajs/vue3'
import { ref, onMounted } from 'vue'
const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Empleados',
    href: '/empleados',
  },
]
</script>

<template>
  <Head title="Productos" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-4">
      <h1 class="text-2xl font-bold flex items-center gap-2">Productos</h1>

      <ViewProducts />
    </div>
  </AppLayout>
</template>

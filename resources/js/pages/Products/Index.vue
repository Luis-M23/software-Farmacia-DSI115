<template>
  <div class="min-h-screen bg-green-50 p-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center bg-white p-6 rounded shadow mb-6">
      <div class="flex items-center space-x-4 mb-4 md:mb-0">
        <img src="img/logo-farmacia.png" alt="Farmacias La Esperanza" class="h-16 w-auto" />
        <div>
          <h1 class="text-2xl font-bold text-gray-800">Gestión de Productos</h1>
          <p class="text-gray-600">Administra el inventario de la farmacia</p>
        </div>
      </div>
      <Button @click="showModal = true" class="bg-green-600 hover:bg-green-700 text-white">
        + Agregar Producto
      </Button>
    </div>

    <!-- KPIs -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
      <Card>
        <CardContent class="p-4">
          <div class="text-sm text-gray-500 mb-1">Total Productos</div>
          <div class="text-2xl font-bold text-green-700">1</div>
        </CardContent>
      </Card>

      <Card>
        <CardContent class="p-4">
          <div class="text-sm text-gray-500 mb-1">Stock Bajo</div>
          <div class="text-2xl font-bold text-red-600">0</div>
        </CardContent>
      </Card>

      <Card>
        <CardContent class="p-4">
          <div class="text-sm text-gray-500 mb-1">Por Vencer</div>
          <div class="text-2xl font-bold text-orange-500">1</div>
        </CardContent>
      </Card>

      <Card>
        <CardContent class="p-4">
          <div class="text-sm text-gray-500 mb-1">Categorías</div>
          <div class="text-2xl font-bold text-green-700">1</div>
        </CardContent>
      </Card>
    </div>

    <!-- Buscador + Filtro -->
    <div class="flex flex-col md:flex-row items-center mb-6 space-y-4 md:space-y-0 md:space-x-4">
      <Input v-model="searchQuery" placeholder="Buscar productos..." class="w-full md:w-1/2" />
      <select v-model="selectedCategory" class="w-full md:w-1/4 h-12 border border-gray-300 rounded px-3 text-gray-700">
        <option value="">Todas las categorías</option>
        <option value="Cuidado Personal">Cuidado Personal</option>
        <option value="Otros">Otros</option>
      </select>
    </div>

    <!-- Listado de productos -->
    <div class="space-y-4">
      <ProductCard />
    </div>

    <!-- Modal -->
    <ProductModal :show="showModal" @close="showModal = false" />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { Card, CardContent } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import ProductCard from '@/Components/ProductCard.vue'
import ProductModal from '@/Components/ProductModal.vue'

const showModal = ref(false)
const searchQuery = ref('')
const selectedCategory = ref('')
</script>

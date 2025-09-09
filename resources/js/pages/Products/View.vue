<template>
  <div class="min-h-screen bg-green-50 p-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center bg-white p-6 rounded shadow mb-6">
      <div class="flex items-center space-x-4 mb-4 md:mb-0">
        <Button @click="irADashboard" class="bg-gray-300 hover:bg-gray-400 text-gray-800 ml-2">
          ←
        </Button>
        <img src="img/logo-farmacia.png" alt="Farmacias La Esperanza" class="h-16 w-auto" />
        <div>
          <h1 class="text-2xl font-bold text-gray-800">Gestión de Productos</h1>
          <p class="text-gray-600">Administra el inventario de la farmacia</p>
        </div>
      </div>
      <Button @click="abrirModalAgregar" class="bg-green-600 hover:bg-green-700 text-white">
        + Agregar Producto
      </Button>
    </div>

    <!-- KPIs -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
      <Card>
        <CardContent class="p-4">
          <div class="text-sm text-gray-500 mb-1">Total Productos</div>
          <div class="text-2xl font-bold text-green-700">{{ productos.length }}</div>
        </CardContent>
      </Card>
      <Card>
        <CardContent class="p-4">
          <div class="text-sm text-gray-500 mb-1">Stock Bajo</div>
          <div class="text-2xl font-bold text-red-600">{{ totalStockBajo }}</div>
        </CardContent>
      </Card>
      <Card>
        <CardContent class="p-4">
          <div class="text-sm text-gray-500 mb-1">Por Vencer</div>
          <div class="text-2xl font-bold text-orange-500">{{ porVencer }}</div>
        </CardContent>
      </Card>
      <Card>
        <CardContent class="p-4">
          <div class="text-sm text-gray-500 mb-1">Categorías</div>
          <div class="text-2xl font-bold text-green-700">{{ categoriasUnicas.length }}</div>
        </CardContent>
      </Card>
    </div>

    <!-- Buscador + Filtro -->
    <div class="flex flex-col md:flex-row items-center mb-6 space-y-4 md:space-y-0 md:space-x-4">
      <Input v-model="searchQuery" placeholder="Buscar productos..." class="w-full md:w-1/2" />
      <select v-model="selectedCategory" class="border border-gray-300 rounded px-3 py-2">
        <option value="">Todas las categorías</option>
        <option v-for="cat in categorias" :key="cat.id" :value="cat.nombre">
          {{ cat.nombre }}
        </option>
      </select>
    </div>

    <!-- Mostrar error -->
    <div v-if="error" class="text-red-600 mb-4">{{ error }}</div>

    <!-- Mostrar loading -->
    <div v-if="loading" class="mb-4">Cargando productos...</div>

    <!-- Listado de productos -->
    <div class="space-y-4" v-if="productos.length > 0">
      <ProductCard
        v-for="producto in productosFiltrados"
        :key="producto.id"
        :producto="producto"
        @eliminar="eliminarProducto"
        @editar="editarProducto"
      />
    </div>

    <div v-else-if="!loading" class="text-gray-600">No hay productos para mostrar.</div>

    <!-- Modal -->
    <ProductModal
    :show="showModal"
    @close="() => { showModal = false; productoAEditar = null }"
    @producto-agregado="agregarProducto"
    @producto-editado="actualizarProducto"
    :productoEditar="productoAEditar"
    :categorias="categorias"
    />

  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { Card, CardContent } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import ProductCard from '@/Components/ProductCard.vue'
import ProductModal from '@/Components/ProductModal.vue'
import { router } from '@inertiajs/vue3'
import Swal from 'sweetalert2'
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const showModal = ref(false)
const productoAEditar = ref(null)
const searchQuery = ref('')
const selectedCategory = ref('')
const loading = ref(false)
const error = ref(null)
const productos = ref(page.props?.value?.productos ?? [])
const categorias = ref(page.props.categorias || [])
const porVencer = ref(page.props?.por_vencer ?? 0)

onMounted(() => {
  cargarProductos()
})

async function cargarProductos() {
  loading.value = true
  error.value = null
  try {
    const res = await fetch('/api/productos')
    if (!res.ok) throw new Error('Error al cargar productos')
    productos.value = await res.json()
  } catch (e) {
    error.value = e.message
  } finally {
    loading.value = false
  }
}

const productosFiltrados = computed(() => {
  return productos.value.filter(p => {
    const matchNombre = p.nombre.toLowerCase().includes(searchQuery.value.toLowerCase())
    const matchCategoria = selectedCategory.value === '' || p.categoria?.nombre === selectedCategory.value
    return matchNombre && matchCategoria
  })
})

const totalStockBajo = computed(() => {
  return productos.value.filter(p => p.existencia_inicial !== null && p.existencia_inicial < 5).length
})

const categoriasUnicas = computed(() => {
  const set = new Set(productos.value.map(p => p.categoria).filter(Boolean))
  return [...set]
})

const eliminarProducto = (id) => {
  Swal.fire({
    title: '¿Estás seguro?',
    text: 'Esta acción no se puede deshacer',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar',
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
  }).then((result) => {
    if (result.isConfirmed) {
      router.delete(`/productos/${id}`, {
        onSuccess: () => {
          productos.value = productos.value.filter(p => p.id !== id)
          Swal.fire('Eliminado', 'El producto fue eliminado.', 'success')
          actualizarContadores()
        },
        onError: () => {
          Swal.fire('Error', 'No se pudo eliminar.', 'error')
        }
      })
    }
  })
}

const agregarProducto = (nuevoProducto) => {
  productos.value.unshift(nuevoProducto)
  actualizarContadores()
}

const actualizarProducto = (productoActualizado) => {
  const index = productos.value.findIndex(p => p.id === productoActualizado.id)
  if (index !== -1) {
    productos.value[index] = productoActualizado
  }
}

const irADashboard = () => {
  router.visit('/dashboard')
}

const actualizarContadores = async () => {
  const res = await fetch('/api/productos')
  if (res.ok) {
    const data = await res.json()
    productos.value = data
  }
}

const editarProducto = (producto) => {
  productoAEditar.value = { ...producto }
  showModal.value = true
}

const abrirModalAgregar = () => {
  productoAEditar.value = null
  showModal.value = true
}
</script>

<template>
  <Card v-if="producto && Object.keys(producto).length" class="flex flex-col md:flex-row items-center md:items-start p-4 space-y-4 md:space-y-0 md:space-x-6 bg-white shadow">
    <!-- Imagen producto -->
    <div class="flex-shrink-0">
      <div class="h-16 w-16 bg-gray-100 rounded flex items-center justify-center text-gray-400 text-3xl">
        <template v-if="producto.imagen">
          <img :src="`/storage/${producto.imagen}`" alt="Producto" class="h-16 w-16 object-cover rounded" />
        </template>
        <template v-else>
          📦
        </template>
      </div>
    </div>

    <!-- Info producto -->
    <div class="flex-grow w-full space-y-1">
      <h3 class="text-lg font-bold text-gray-800">{{ producto.nombre || 'Sin nombre' }}</h3>
      <p class="text-gray-500 text-sm">{{ producto.proveedor || 'Sin proveedor' }}</p>

      <div class="grid grid-cols-2 md:grid-cols-4 gap-2 mt-2 text-sm">
        <div>
          <div class="text-gray-500">Precio Compra:</div>
          <div class="font-bold text-green-700">${{ precioCompraFormateado }}</div>
        </div>
        <div>
          <div class="text-gray-500">Precio Venta:</div>
          <div class="font-bold text-green-700">${{ precioVentaFormateado }}</div>
        </div>
        <div>
          <div class="text-gray-500">Existencia:</div>
          <div class="font-bold">{{ producto.existencia_inicial ?? 0 }} unidades</div>
        </div>
        <div>
          <div class="text-gray-500">Vencimiento:</div>
          <div class="font-bold" :class="vencimientoClase">{{ vencimientoTexto }}</div>
        </div>
      </div>

      <!-- Chips de categorías -->
      <div class="flex flex-wrap gap-2 mt-3">
        <span class="bg-gray-100 text-gray-700 text-xs font-medium px-2 py-1 rounded">{{ producto.categoria?.nombre || 'Sin categoría' }}</span>
        <span class="bg-gray-100 text-gray-700 text-xs font-medium px-2 py-1 rounded">{{ producto.presentacion || 'Sin presentación' }}</span>
      </div>
    </div>

    <!-- Botones acciones -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-end gap-2 mt-4 md:mt-0">
      <Button variant="outline" class="flex items-center space-x-1">
        ✏️ <span>Editar</span>
      </Button>
      <Button
        variant="destructive"
        class="flex items-center space-x-1"
        @click="$emit('eliminar', producto.id)">
        🗑️ <span>Eliminar</span>
      </Button>
    </div>
  </Card>

  <!-- Opcional: mostrar algo si no hay producto -->
  <div v-else class="p-4 text-center text-gray-500">No hay datos del producto para mostrar.</div>
</template>

<script setup>
import { computed } from 'vue'
import { Card } from '@/components/ui/card'
import { Button } from '@/components/ui/button'

const emit = defineEmits(['eliminar'])

const props = defineProps({
  producto: {
    type: Object,
    default: () => ({})
  }
})

// Aquí pones el console.log para ver qué trae producto
console.log('Producto recibido:', props.producto)

// Formatear precio compra, asegurando número válido
const precioCompraFormateado = computed(() => {
  const val = Number(props.producto.precio_compra)
  return isNaN(val) ? '0.00' : val.toFixed(2)
})

// Formatear precio venta, asegurando número válido
const precioVentaFormateado = computed(() => {
  const val = Number(props.producto.precio_venta)
  return isNaN(val) ? '0.00' : val.toFixed(2)
})

// Formatear fecha de vencimiento
const vencimientoTexto = computed(() => {
  if (!props.producto.fecha_vencimiento) return 'Sin fecha'
  const fecha = new Date(props.producto.fecha_vencimiento)
  return `⚠️ ${fecha.toLocaleDateString('es-SV')}`
})

// Color según vencimiento
const vencimientoClase = computed(() => {
  if (!props.producto.fecha_vencimiento) return 'text-gray-500'
  const hoy = new Date()
  const vencimiento = new Date(props.producto.fecha_vencimiento)
  return vencimiento < hoy ? 'text-red-600' : 'text-green-700'
})
</script>

<template>
  <!-- BACKDROP -->
  <Transition name="fade">
    <div v-if="show" class="fixed inset-0 bg-white/70 backdrop-blur-sm z-40"></div>
  </Transition>

  <!-- MODAL -->
  <Transition name="scale">
    <div
      v-if="show"
      class="fixed inset-0 flex items-center justify-center z-50"
      role="dialog"
      aria-modal="true"
    >
      <div class="bg-white rounded shadow-lg w-full max-w-4xl p-6 relative">
        <!-- Botón cerrar -->
        <button @click="closeModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-xl">
          ✕
        </button>

        <!-- Título -->
        <h2 class="text-2xl font-bold text-gray-800 mb-1">Agregar Nuevo Producto</h2>
        <p class="text-gray-600 mb-6">Completa la información para registrar un nuevo producto.</p>

        <!-- Formulario -->
        <form @submit.prevent="handleSubmit" class="grid grid-cols-1 md:grid-cols-2 gap-4">

          <!-- Nombre del producto -->
          <div>
            <Label for="nombre">Nombre del Producto *</Label>
            <Input id="nombre" v-model="nombre" placeholder="Ej: Paracetamol 500mg" required />
          </div>

          <!-- Categoría -->
          <div>
            <Label for="categoria">Categoría *</Label>
            <Input id="categoria" v-model="categoria" placeholder="Selecciona una categoría" required />
          </div>

          <!-- Presentación -->
          <div>
            <Label for="presentacion">Presentación *</Label>
            <Input id="presentacion" v-model="presentacion" placeholder="Selecciona la presentación" required />
          </div>

          <!-- Proveedor -->
          <div>
            <Label for="proveedor">Proveedor *</Label>
            <Input id="proveedor" v-model="proveedor" placeholder="Ej: Laboratorios ABC" required />
          </div>

          <!-- Precio de compra -->
          <div>
            <Label for="precioCompra">Precio de Compra *</Label>
            <div class="flex items-center space-x-2">
              <span class="text-gray-500">$</span>
              <Input id="precioCompra" type="number" step="0.01" v-model="precioCompra" required />
            </div>
          </div>

          <!-- Precio de venta -->
          <div>
            <Label for="precioVenta">Precio de Venta *</Label>
            <div class="flex items-center space-x-2">
              <span class="text-gray-500">$</span>
              <Input id="precioVenta" type="number" step="0.01" v-model="precioVenta" required />
            </div>
          </div>

          <!-- Existencia inicial -->
          <div>
            <Label for="existencia">Existencia Inicial *</Label>
            <Input id="existencia" type="number" v-model="existencia" required />
          </div>

          <!-- Fecha de vencimiento -->
          <div>
            <Label for="vencimiento">Fecha de Vencimiento (opcional)</Label>
            <Input id="vencimiento" type="date" v-model="vencimiento" />
          </div>

          <!-- Imagen producto -->
          <div class="md:col-span-2">
            <Label for="imagen">Imagen del Producto (opcional)</Label>
            <div class="flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded p-6 text-gray-500 text-center">
              <p class="font-medium">Click para subir <span class="font-normal">o arrastra la imagen</span></p>
              <p class="text-xs mt-1">PNG, JPG o JPEG (MAX. 5MB)</p>
              <!-- Input file (por ahora oculto, simulamos) -->
              <input type="file" class="hidden" />
            </div>
          </div>

        </form>

        <!-- Botones -->
        <div class="flex justify-end space-x-4 mt-6">
          <Button variant="outline" @click="closeModal">Cancelar</Button>
          <Button type="submit" @click="handleSubmit" class="bg-green-600 hover:bg-green-700 text-white">Guardar Producto</Button>
        </div>
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { ref, defineProps, defineEmits } from 'vue'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'

const props = defineProps({
  show: {
    type: Boolean,
    required: true
  }
})

const emit = defineEmits(['close'])

const nombre = ref('')
const categoria = ref('')
const presentacion = ref('')
const proveedor = ref('')
const precioCompra = ref('')
const precioVenta = ref('')
const existencia = ref('')
const vencimiento = ref('')

const closeModal = () => {
  emit('close')
}

const handleSubmit = () => {
  console.log('Producto guardado:', {
    nombre: nombre.value,
    categoria: categoria.value,
    presentacion: presentacion.value,
    proveedor: proveedor.value,
    precioCompra: precioCompra.value,
    precioVenta: precioVenta.value,
    existencia: existencia.value,
    vencimiento: vencimiento.value
  })

  alert('Producto guardado (simulado).')
  emit('close')
}
</script>

<style scoped>
/* Animación fade para el backdrop */
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}

/* Animación scale para el modal */
.scale-enter-active, .scale-leave-active {
  transition: all 0.3s ease;
}
.scale-enter-from {
  opacity: 0;
  transform: scale(0.95);
}
.scale-leave-to {
  opacity: 0;
  transform: scale(0.95);
}
</style>

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
        <form @submit.prevent="handleSubmit" class="grid grid-cols-1 md:grid-cols-2 gap-4" enctype="multipart/form-data">

          <!-- Nombre del producto -->
          <div>
            <Label for="nombre">Nombre del Producto *</Label>
            <Input id="nombre" v-model="form.nombre" placeholder="Ej: Paracetamol 500mg" required />
            <div v-if="form.errors.nombre" class="text-red-500 text-sm">{{ form.errors.nombre }}</div>
          </div>

          <!-- Categoría -->
          <div>
            <Label for="categoria">Categoría *</Label>
            <Input id="categoria" v-model="form.categoria" placeholder="Ej: Analgésico" required />
            <div v-if="form.errors.categoria" class="text-red-500 text-sm">{{ form.errors.categoria }}</div>
          </div>

          <!-- Presentación -->
          <div>
            <Label for="presentacion">Presentación *</Label>
            <Input id="presentacion" v-model="form.presentacion" placeholder="Ej: Caja de 20 tabletas" required />
            <div v-if="form.errors.presentacion" class="text-red-500 text-sm">{{ form.errors.presentacion }}</div>
          </div>

          <!-- Proveedor -->
          <div>
            <Label for="proveedor">Proveedor *</Label>
            <Input id="proveedor" v-model="form.proveedor" placeholder="Ej: Laboratorios ABC" required />
            <div v-if="form.errors.proveedor" class="text-red-500 text-sm">{{ form.errors.proveedor }}</div>
          </div>

          <!-- Precio de compra -->
          <div>
            <Label for="precioCompra">Precio de Compra *</Label>
            <div class="flex items-center space-x-2">
              <span class="text-gray-500">$</span>
              <Input id="precioCompra" type="number" step="0.01" v-model="form.precio_compra" required />
            </div>
            <div v-if="form.errors.precio_compra" class="text-red-500 text-sm">{{ form.errors.precio_compra }}</div>
          </div>

          <!-- Precio de venta -->
          <div>
            <Label for="precioVenta">Precio de Venta *</Label>
            <div class="flex items-center space-x-2">
              <span class="text-gray-500">$</span>
              <Input id="precioVenta" type="number" step="0.01" v-model="form.precio_venta" required />
            </div>
            <div v-if="form.errors.precio_venta" class="text-red-500 text-sm">{{ form.errors.precio_venta }}</div>
          </div>

          <!-- Existencia inicial -->
          <div>
            <Label for="existencia">Existencia Inicial *</Label>
            <Input id="existencia" type="number" v-model="form.existencia_inicial" required />
            <div v-if="form.errors.existencia_inicial" class="text-red-500 text-sm">{{ form.errors.existencia_inicial }}</div>
          </div>

          <!-- Fecha de vencimiento -->
          <div>
            <Label for="vencimiento">Fecha de Vencimiento</Label>
            <Input id="vencimiento" type="date" v-model="form.fecha_vencimiento" />
          </div>

          <!-- Imagen producto -->
          <div class="md:col-span-2">
            <Label for="imagen">Imagen del Producto</Label>
            <div
              class="flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded p-6 text-gray-500 text-center cursor-pointer"
              @click="openFileInput"
              @drop.prevent="handleDrop"
              @dragover.prevent
            >
              <p class="font-medium">Click para subir <span class="font-normal">o arrastra la imagen aquí</span></p>
              <p class="text-xs mt-1">PNG, JPG o JPEG (MAX. 5MB)</p>
              <div v-if="form.imagen" class="mt-2 text-green-600">
                Imagen seleccionada: {{ form.imagen.name }}
              </div>
              <input
                type="file"
                ref="fileInput"
                class="hidden"
                accept="image/*"
                @change="e => form.imagen = e.target.files[0]"
              />
            </div>
            <div v-if="form.errors.imagen" class="text-red-500 text-sm">{{ form.errors.imagen }}</div>
          </div>
        </form>

        <!-- Botones -->
        <div class="flex justify-end space-x-4 mt-6">
          <Button variant="outline" @click="closeModal">Cancelar</Button>
          <Button @click="handleSubmit" class="bg-green-600 hover:bg-green-700 text-white">Guardar Producto</Button>
        </div>
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { defineProps, defineEmits } from 'vue'

const emit = defineEmits(['close', 'producto-agregado'])

const props = defineProps({
  show: { type: Boolean, required: true }
})

const fileInput = ref(null)

const form = useForm({
  nombre: '',
  categoria: '',
  presentacion: '',
  proveedor: '',
  precio_compra: '',
  precio_venta: '',
  existencia_inicial: '',
  fecha_vencimiento: '',
  imagen: null,
})

const closeModal = () => {
  form.reset()
  form.clearErrors()
  emit('close')
}

const openFileInput = () => {
  fileInput.value?.click()
}

const handleDrop = (e) => {
  const files = e.dataTransfer.files
  if (files.length > 0) {
    form.imagen = files[0]
  }
}

const handleSubmit = () => {
  form.post('/productos', {
    forceFormData: true,
    onSuccess: (page) => {
  // Si tu backend redirige con back(), no se obtiene producto creado
  // Necesitamos reconsultar el producto recién creado
  fetch('/api/productos')
    .then(res => res.json())
    .then(data => {
      const ultimoProducto = data[0]; // El primero porque usas latest()
      emit('producto-agregado', ultimoProducto)
    })

  closeModal()
},
    onError: (errors) => {
      console.error('Errores:', errors)
    }
  })
}

// Cargar productos desde API
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
</script>


<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
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
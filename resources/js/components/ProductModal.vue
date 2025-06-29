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
        <h2 class="text-2xl font-bold text-gray-800 mb-1">
          {{ esEdicion ? 'Editar Producto' : 'Agregar Nuevo Producto' }}
        </h2>
        <p class="text-gray-600 mb-6">
          {{ esEdicion ? 'Modifica la información del producto.' : 'Completa la información para registrar un nuevo producto.' }}
        </p>

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
            <select v-model="form.categoria_id" id="categoria" required class="w-full border rounded h-10 px-3">
              <option value="">Seleccione una categoría</option>
              <option v-for="cat in categorias" :key="cat.id" :value="cat.id">{{ cat.nombre }}</option>
            </select>
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
          <Button @click="handleSubmit" class="bg-green-600 hover:bg-green-700 text-white">
            {{ esEdicion ? 'Actualizar Producto' : 'Guardar Producto' }}
          </Button>
        </div>
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { ref, watch, computed } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { defineProps, defineEmits } from 'vue'
import axios from 'axios'

const emit = defineEmits(['close', 'producto-agregado', 'producto-editado'])

const props = defineProps({
  show: { type: Boolean, required: true },
  categorias: { type: Array, required: true },
  productoEditar: { type: Object, default: null },
})

const fileInput = ref(null)

const form = useForm({
  nombre: '',
  categoria_id: '',
  presentacion: '',
  proveedor: '',
  precio_compra: '',
  precio_venta: '',
  existencia_inicial: '',
  fecha_vencimiento: '',
  imagen: null,
})

const esEdicion = computed(() => !!props.productoEditar)

watch(() => props.productoEditar, (producto) => {
  if (producto) {
    form.nombre = producto.nombre || ''
    form.categoria_id = producto.categoria_id || ''
    form.presentacion = producto.presentacion || ''
    form.proveedor = producto.proveedor || ''
    form.precio_compra = producto.precio_compra || ''
    form.precio_venta = producto.precio_venta || ''
    form.existencia_inicial = producto.existencia_inicial || ''
    form.fecha_vencimiento = producto.fecha_vencimiento || ''
    form.imagen = null
  } else {
    form.reset()
  }
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

const handleSubmit = async () => {
  const formData = new FormData()
  Object.entries(form.data()).forEach(([key, value]) => {
    if (value !== null && value !== undefined) {
      formData.append(key, value)
    }
  })
  if (form.imagen) {
    formData.append('imagen', form.imagen)
  }

  try {
    let res
    if (esEdicion.value) {
      res = await axios.post(`/productos/${props.productoEditar.id}`, formData, {
        headers: { 'X-HTTP-Method-Override': 'PUT' }
      })
      emit('producto-editado', res.data.producto)
    } else {
      res = await axios.post('/productos', formData)
      emit('producto-agregado', res.data.producto)
    }
    closeModal()
  } catch (error) {
    if (error.response?.data?.errors) {
      form.setError(error.response.data.errors)
    } else {
      console.error('Error inesperado:', error)
    }
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

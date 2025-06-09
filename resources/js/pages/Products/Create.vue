<template>
  <div class="min-h-screen bg-gradient-to-br from-green-50 to-green-100 flex items-center justify-center p-4">
    <Card class="w-full max-w-md shadow-xl border-0">
      <CardHeader class="space-y-4 text-center pb-6">
        <div class="flex justify-center">
          <img
            src="/logo-farmacia.png"
            alt="Farmacias La Esperanza"
            width="200"
            height="120"
            class="object-contain"
          />
        </div>
        <div class="space-y-2">
          <CardTitle class="text-2xl font-bold text-gray-800">Agregar Producto</CardTitle>
          <CardDescription class="text-gray-600">Completa los datos para registrar un nuevo producto</CardDescription>
        </div>
      </CardHeader>

      <CardContent class="space-y-6">
        <!-- Errores -->
        <div v-if="error" class="mb-4 text-red-600 font-medium text-sm text-center">
          {{ error }}
        </div>

        <!-- Formulario -->
        <form @submit.prevent="handleSubmit" class="space-y-4">
          <!-- Nombre -->
          <div class="space-y-2">
            <Label for="nombre" class="text-gray-700 font-medium">Nombre del Producto</Label>
            <Input
              id="nombre"
              type="text"
              placeholder="Ej: Paracetamol 500mg"
              v-model="nombre"
              class="pl-3 h-12 border-gray-200 focus:border-green-500 focus:ring-green-500"
              required
            />
          </div>

          <!-- Precio -->
          <div class="space-y-2">
            <Label for="precio" class="text-gray-700 font-medium">Precio</Label>
            <Input
              id="precio"
              type="number"
              step="0.01"
              placeholder="Ej: 3.50"
              v-model="precio"
              class="pl-3 h-12 border-gray-200 focus:border-green-500 focus:ring-green-500"
              required
            />
          </div>

          <!-- Categoría -->
          <div class="space-y-2">
            <Label for="categoria" class="text-gray-700 font-medium">Categoría</Label>
            <Input
              id="categoria"
              type="text"
              placeholder="Ej: Analgésico"
              v-model="categoria"
              class="pl-3 h-12 border-gray-200 focus:border-green-500 focus:ring-green-500"
            />
          </div>

          <!-- Botón Guardar -->
          <Button
            type="submit"
            :disabled="loading"
            class="w-full h-12 bg-green-600 hover:bg-green-700 text-white font-medium text-base flex justify-center items-center"
          >
            <span
              v-if="loading"
              class="animate-spin border-2 border-white border-t-transparent rounded-full w-5 h-5 mr-2"
            ></span>
            {{ loading ? 'Guardando...' : 'Guardar Producto' }}
          </Button>
        </form>
      </CardContent>
    </Card>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Button } from '@/components/ui/button'
import axios from 'axios'

const nombre = ref('')
const precio = ref('')
const categoria = ref('')

const loading = ref(false)
const error = ref('')

const handleSubmit = async () => {
  error.value = ''
  loading.value = true

  try {
    console.log('Producto a guardar:', {
      nombre: nombre.value,
      precio: precio.value,
      categoria: categoria.value
    })

    // En el futuro, cuando tengas el modelo, se usará esto:
    /*
    await axios.post('/productos', {
      nombre: nombre.value,
      precio: precio.value,
      categoria: categoria.value
    })
    */

    alert('Producto guardado (simulado).')

    // Limpiar formulario
    nombre.value = ''
    precio.value = ''
    categoria.value = ''
  } catch (err) {
    console.error('Error al guardar', err)
    error.value = 'Error al guardar el producto.'
  } finally {
    loading.value = false
  }
}
</script>

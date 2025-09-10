<template>
  <Transition name="fade">
    <div v-if="showModalProp" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
      <Card class="w-full max-w-lg p-6">
        <CardHeader class="space-y-2 text-center">
          <CardTitle class="text-xl font-bold text-gray-800">Nuevo Empleado</CardTitle>
          <CardDescription class="text-gray-600">
            Complete los datos para registrar un nuevo empleado
          </CardDescription>
        </CardHeader>

        <CardContent class="space-y-4">
          <!-- Errores -->
          <div v-if="error" class="text-red-600 font-medium text-sm text-center">{{ error }}</div>

          <!-- Formulario -->
          <form @submit.prevent="submitForm" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="flex flex-col">
                <Label>Nombre Completo</Label>
                <Input v-model="form.nombre" placeholder="Ej: Juan Pérez" required />
              </div>

              <div class="flex flex-col">
                <Label>DUI</Label>
                <Input v-model="form.dui" placeholder="Ej: 12345678-9" required />
              </div>

              <div class="flex flex-col">
                <Label>Correo Electrónico</Label>
                <Input v-model="form.email" type="email" placeholder="ejemplo@correo.com" required />
              </div>

              <div class="flex flex-col">
                <Label>Teléfono</Label>
                <Input v-model="form.telefono" placeholder="Ej: 7777-7777" required />
              </div>

              <div class="flex flex-col">
                <Label>Dirección</Label>
                <Input v-model="form.direccion" placeholder="Ej: Col. Centro" required />
              </div>

              <div class="flex flex-col">
                <Label>Cargo</Label>
                <Input v-model="form.cargo" placeholder="Ej: Vendedor" required />
              </div>

              <div class="flex flex-col">
                <Label>Usuario</Label>
                <Input v-model="form.usuario" placeholder="Nombre de usuario" required />
              </div>

              <div class="flex flex-col">
                <Label>Contraseña</Label>
                <Input v-model="form.contrasena" type="password" placeholder="********" required />
              </div>

              <div class="flex flex-col">
                <Label>Rol</Label>
                <select v-model="form.rol" class="form-input" required>
                  <option disabled value="">Seleccione un rol</option>
                  <option v-for="rol in roles" :key="rol" :value="rol">{{ rol }}</option>
                </select>
              </div>
            </div>

            <!-- Acciones -->
            <div class="flex justify-end gap-3 mt-4">
              <Button type="submit" :disabled="loading" class="bg-green-600 hover:bg-green-700 text-white">
                <span v-if="loading" class="animate-spin border-2 border-white border-t-transparent rounded-full w-5 h-5 mr-2"></span>
                {{ loading ? 'Guardando...' : 'Guardar' }}
              </Button>
              <Button type="button" @click="$emit('close')" class="bg-gray-200 hover:bg-gray-300 text-gray-800">
                Cancelar
              </Button>
            </div>
          </form>
        </CardContent>
      </Card>
    </div>
  </Transition>
</template>

<script setup>
import { ref, watch, defineProps } from 'vue'
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Button } from '@/components/ui/button'

const props = defineProps({
  showModalProp: Boolean
})

const loading = ref(false)
const error = ref('')

const roles = ['Administrador', 'Vendedor', 'Cajero']

const form = ref({
  nombre: '',
  dui: '',
  email: '',
  telefono: '',
  direccion: '',
  cargo: '',
  usuario: '',
  contrasena: '',
  rol: ''
})

function submitForm() {
  error.value = ''
  loading.value = true

  try {
    console.log('Empleado creado:', form.value)
    alert('Empleado guardado (simulado).')

    // Limpiar formulario
    Object.keys(form.value).forEach(key => form.value[key] = '')
    // Cierra el modal
    emitClose()
  } catch (err) {
    console.error(err)
    error.value = 'Error al guardar el empleado.'
  } finally {
    loading.value = false
  }
}

function emitClose() {
  form.value = {
    nombre: '',
    dui: '',
    email: '',
    telefono: '',
    direccion: '',
    cargo: '',
    usuario: '',
    contrasena: '',
    rol: ''
  }
  // Emitir evento al padre para cerrar
  emit('close')
}
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.2s;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>

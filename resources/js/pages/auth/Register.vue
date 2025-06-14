<template>
  <div class="min-h-screen bg-gradient-to-br from-green-50 to-green-100 flex items-center justify-center p-4">
    <div class="w-full max-w-md shadow-xl border-0 bg-white p-8 rounded">
      <div class="flex justify-center mb-6">
        <img src="img/logo-farmacia.png" alt="Farmacias La Esperanza" width="200" height="120" class="object-contain" />
      </div>

      <h2 class="text-2xl font-bold text-gray-800 text-center mb-2">Crear Cuenta</h2>
      <p class="text-gray-600 text-center mb-6">Únete a Farmacias La Esperanza y disfruta de beneficios exclusivos</p>

      <!-- Mostrar error -->
      <div v-if="error" class="mb-4 text-red-600 font-medium text-sm text-center">
        {{ error }}
      </div>

      <form @submit.prevent="handleSubmit" class="space-y-4">
        <!-- Nombre -->
        <div>
          <label class="block text-gray-700 font-medium mb-1">Nombre</label>
          <input
            type="text"
            v-model="name"
            placeholder="Nombre completo"
            class="pl-3 h-12 w-full border border-gray-200 focus:border-green-500 focus:ring-green-500 rounded"
            required
          />
        </div>

        <!-- Email -->
        <div>
          <label class="block text-gray-700 font-medium mb-1">Correo Electrónico</label>
          <input
            type="email"
            v-model="email"
            placeholder="tu@email.com"
            class="pl-3 h-12 w-full border border-gray-200 focus:border-green-500 focus:ring-green-500 rounded"
            required
          />
        </div>

        <!-- Password -->
        <div>
          <label class="block text-gray-700 font-medium mb-1">Contraseña</label>
          <input
            :type="showPassword ? 'text' : 'password'"
            v-model="password"
            placeholder="••••••••"
            class="pl-3 h-12 w-full border border-gray-200 focus:border-green-500 focus:ring-green-500 rounded"
            required
          />
          <button type="button" @click="showPassword = !showPassword" class="text-sm text-green-600 mt-1">
            {{ showPassword ? 'Ocultar' : 'Mostrar' }}
          </button>
        </div>

        <!-- Confirmar Password -->
        <div>
          <label class="block text-gray-700 font-medium mb-1">Confirmar Contraseña</label>
          <input
            :type="showConfirmPassword ? 'text' : 'password'"
            v-model="confirmPassword"
            placeholder="••••••••"
            class="pl-3 h-12 w-full border border-gray-200 focus:border-green-500 focus:ring-green-500 rounded"
            required
          />
          <button type="button" @click="showConfirmPassword = !showConfirmPassword" class="text-sm text-green-600 mt-1">
            {{ showConfirmPassword ? 'Ocultar' : 'Mostrar' }}
          </button>
        </div>

        <!-- Submit -->
        <button
          type="submit"
          :disabled="loading"
          class="w-full h-12 bg-green-600 hover:bg-green-700 text-white font-medium text-base rounded flex justify-center items-center"
        >
          <span v-if="loading" class="animate-spin border-2 border-white border-t-transparent rounded-full w-5 h-5 mr-2"></span>
          {{ loading ? 'Creando cuenta...' : 'Crear Cuenta' }}
        </button>
      </form>

      <!-- Enlace a login -->
      <div class="text-center text-sm text-gray-600 mt-6">
        ¿Ya tienes una cuenta?
        <a href="/login" class="text-green-600 hover:text-green-700 font-medium">Inicia sesión aquí</a>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

const name = ref('')
const email = ref('')
const password = ref('')
const confirmPassword = ref('')

const showPassword = ref(false)
const showConfirmPassword = ref(false)
const loading = ref(false)
const error = ref('')

const handleSubmit = async () => {
  error.value = ''
  loading.value = true

  // Validación simple
  if (password.value !== confirmPassword.value) {
    error.value = 'Las contraseñas no coinciden.'
    loading.value = false
    return
  }

  try {
    const response = await axios.post('/register', {
      name: name.value,
      email: email.value,
      password: password.value,
      password_confirmation: confirmPassword.value
    })

    console.log('Register OK', response)
    window.location.href = '/productos'
  } catch (err) {
    console.error('Register ERROR', err)
    if (err.response && err.response.status === 422) {
      // Laravel validation error
      error.value = 'Datos inválidos o email ya en uso.'
    } else {
      error.value = 'Error en el servidor. Intenta nuevamente.'
    }
  } finally {
    loading.value = false
  }
}
</script>
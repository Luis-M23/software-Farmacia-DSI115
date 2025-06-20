<template>
  <div class="min-h-screen bg-gradient-to-br from-green-50 to-green-100 flex items-center justify-center p-4">
    <div class="w-full max-w-md shadow-xl border-0 bg-white p-8 rounded">
      <div class="flex justify-center mb-6">
        <img src="img/logo-farmacia.png" alt="Farmacias La Esperanza" width="200" height="120" class="object-contain" />
      </div>

      <h2 class="text-2xl font-bold text-gray-800 text-center mb-2">Iniciar Sesión</h2>
      <p class="text-gray-600 text-center mb-6">Accede a tu cuenta de Farmacias La Esperanza</p>

      <!-- Errores de Laravel -->
      <div v-if="error" class="mb-4 text-red-600 font-medium text-sm text-center">
        {{ error }}
      </div>

      <form @submit.prevent="handleSubmit" class="space-y-4">
        <!-- Email -->
        <div>
          <label for="email" class="block text-gray-700 font-medium mb-1">Correo Electrónico</label>
          <div class="relative">
            <input
              id="email"
              type="email"
              v-model="email"
              placeholder="tu@email.com"
              class="pl-10 h-12 w-full border border-gray-200 focus:border-green-500 focus:ring-green-500 rounded"
              required
            />
          </div>
        </div>

        <!-- Password -->
        <div>
          <label for="password" class="block text-gray-700 font-medium mb-1">Contraseña</label>
          <div class="relative">
            <input
              :type="showPassword ? 'text' : 'password'"
              id="password"
              v-model="password"
              placeholder="••••••••"
              class="pl-10 pr-10 h-12 w-full border border-gray-200 focus:border-green-500 focus:ring-green-500 rounded"
              required
            />
            <button
              type="button"
              @click="showPassword = !showPassword"
              class="absolute right-3 top-3 text-gray-400 hover:text-gray-600"
            >
              {{ showPassword ? 'Ocultar' : 'Mostrar' }}
            </button>
          </div>
        </div>

        <!-- Remember me -->
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-2">
          </div>
        </div>

        <!-- Submit -->
        <button
          type="submit"
          :disabled="loading"
          class="w-full h-12 bg-green-600 hover:bg-green-700 text-white font-medium text-base rounded flex justify-center items-center"
        >
          <span v-if="loading" class="animate-spin border-2 border-white border-t-transparent rounded-full w-5 h-5 mr-2"></span>
          {{ loading ? 'Iniciando...' : 'Iniciar Sesión' }}
        </button>
      </form>

      <!-- Footer -->
      <div class="text-center text-sm text-gray-600 mt-6">
      ¿No tienes una cuenta?
      <a href="/register" class="text-green-600 hover:text-green-700 font-medium">Regístrate aquí</a>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

const email = ref('')
const password = ref('')
const rememberMe = ref(false)
const showPassword = ref(false)
const loading = ref(false)
const error = ref('')

const handleSubmit = async () => {
  loading.value = true
  error.value = ''

  try {
    const response = await axios.post('/login', {
      email: email.value,
      password: password.value,
      remember: rememberMe.value
    })

    console.log('Login OK', response)
    window.location.href = '/dashboard'
  } catch (err) {
    console.error('Login ERROR', err)
    if (err.response && err.response.status === 422) {
      // Error de validación Laravel
      error.value = 'Email o contraseña incorrectos.'
    } else {
      error.value = 'Error en el servidor. Intenta nuevamente.'
    }
  } finally {
    loading.value = false
  }
}
</script>

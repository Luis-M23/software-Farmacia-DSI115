<template>
  <div class="min-h-screen flex flex-col bg-gradient-to-b from-green-50 to-green-100">

    <!-- Header -->
    <header class="flex items-center justify-between p-6 bg-white shadow">
      <div class="flex items-center space-x-2">
        <img src="img/logo-farmacia.png" alt="Farmacias La Esperanza" class="h-12 w-auto" />
        <span class="font-bold text-xl text-green-700">Farmacias La Esperanza</span>
      </div>
      <div class="space-x-4">
        <a href="/login" class="text-green-600 hover:text-green-700 font-medium">Iniciar Sesión</a>
        <a href="/register" class="text-green-600 hover:text-green-700 font-medium">Registrarse</a>
      </div>
    </header>

    <!-- Hero Section -->
    <main class="flex flex-col items-center justify-center flex-grow text-center px-6 py-12">
      <img src="img/logo-farmacia.png" alt="Farmacias La Esperanza" class="h-32 mb-6" />
      <h1 class="text-4xl font-bold text-gray-800 mb-4">Bienvenido a Farmacias La Esperanza</h1>
      <p class="text-lg text-gray-600 max-w-xl mb-6">
        Trabajamos cada día para cuidar tu salud con calidad, calidez y compromiso.
      </p>
      <a
        href="/login"
        class="inline-block px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded text-lg"
      >
        Iniciar Sesión
      </a>
    </main>

    <!-- Valores / Features -->
    <section class="bg-white py-8">
      <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
        <div>
          <div class="text-green-600 text-4xl mb-2">💊</div>
          <h3 class="font-bold text-lg mb-1">Productos de Calidad</h3>
          <p class="text-gray-600 text-sm">Medicamentos certificados y garantizados.</p>
        </div>
        <div>
          <div class="text-green-600 text-4xl mb-2">⏱️</div>
          <h3 class="font-bold text-lg mb-1">Atención 24/7</h3>
          <p class="text-gray-600 text-sm">Siempre disponibles para tu salud.</p>
        </div>
        <div>
          <div class="text-green-600 text-4xl mb-2">❤️</div>
          <h3 class="font-bold text-lg mb-1">Confianza y Compromiso</h3>
          <p class="text-gray-600 text-sm">Más de 10 años cuidando a las familias.</p>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-100 text-center text-sm text-gray-500 py-4">
      Farmacias La Esperanza © 2025. Todos los derechos reservados.
    </footer>

  </div>
</template>

<template>
  <Card class="flex flex-col md:flex-row items-center md:items-start p-4 space-y-4 md:space-y-0 md:space-x-6 bg-white shadow">
    <!-- Imagen producto -->
    <div class="flex-shrink-0">
      <div class="h-16 w-16 bg-gray-100 rounded flex items-center justify-center text-gray-400 text-3xl">
        📦
      </div>
    </div>

    <!-- Info producto -->
    <div class="flex-grow w-full space-y-1">
      <h3 class="text-lg font-bold text-gray-800">Vendas</h3>
      <p class="text-gray-500 text-sm">Insican</p>

      <div class="grid grid-cols-2 md:grid-cols-4 gap-2 mt-2 text-sm">
        <div>
          <div class="text-gray-500">Precio Compra:</div>
          <div class="font-bold text-green-700">$12.00</div>
        </div>
        <div>
          <div class="text-gray-500">Precio Venta:</div>
          <div class="font-bold text-green-700">$15.00</div>
        </div>
        <div>
          <div class="text-gray-500">Existencia:</div>
          <div class="font-bold">400 unidades</div>
        </div>
        <div>
          <div class="text-gray-500">Vencimiento:</div>
          <div class="font-bold text-red-600">⚠️ 8/6/2025</div>
        </div>
      </div>

      <!-- Chips de categorías -->
      <div class="flex flex-wrap gap-2 mt-3">
        <span class="bg-gray-100 text-gray-700 text-xs font-medium px-2 py-1 rounded">Cuidado Personal</span>
        <span class="bg-gray-100 text-gray-700 text-xs font-medium px-2 py-1 rounded">Otros</span>
      </div>
    </div>

    <!-- Botones acciones -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-end gap-2 mt-4 md:mt-0">
      <Button variant="outline" class="flex items-center space-x-1">
        ✏️ <span>Editar</span>
      </Button>
      <Button variant="destructive" class="flex items-center space-x-1">
        🗑️ <span>Eliminar</span>
      </Button>
    </div>
  </Card>
</template>

<script setup>
import { Card } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
</script>

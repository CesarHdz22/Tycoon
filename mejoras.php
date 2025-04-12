<?php include_once('conexion.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Detalles del Módulo</title>
  <script src="js/tailwindcss.js"></script>
</head>
<body class="bg-gray-900 text-white min-h-screen flex">

  <!-- Header fijo izquierda (Dinero) -->
  <div class="fixed top-4 left-4 bg-black bg-opacity-70 px-4 py-2 rounded-xl shadow-lg z-50">
    <p class="text-lg font-semibold">💰 Dinero: <span id="money">1,250</span></p>
  </div>

  <!-- Header fijo derecha (XP y Nivel) -->
  <div class="fixed top-4 right-[400px] bg-black bg-opacity-70 px-4 py-2 rounded-xl shadow-lg z-50">
    <p class="text-lg font-semibold">🧠 XP: <span id="xp">320</span></p>
    <p class="text-lg font-semibold">📈 Nivel: <span id="level">5</span></p>
  </div>

  <!-- Botón Regresar -->
  <div class="fixed top-4 left-[calc(50%-235px)] z-50">
    <a href="pagina_anterior.php" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-xl shadow-lg">
      🔙 Regresar
    </a>
  </div>

  <!-- Panel Izquierdo -->
  <div class="flex-grow bg-white text-black flex items-center justify-center">
    <p class="text-3xl font-bold">IMAGEN EN GRANDE</p>
    <!-- <img src="modulo_actual.jpg" alt="Imagen Módulo" class="max-w-full max-h-full" /> -->
  </div>

  <!-- Panel Derecho -->
  <div class="w-96 bg-gray-800 border-l-4 border-black flex flex-col">

    <!-- Tabs con selección visual -->
    <div class="flex border-b-2 border-black p-4">
      <label for="tab-mejoras"
        class="cursor-pointer font-bold text-white px-4 hover:text-green-400 hover:border-b-2 hover:border-green-400 transition-all duration-200">
        Mejoras
      </label>

      <div class="w-px bg-gray-600 mx-2"></div>

      <label for="tab-objetivos"
        class="cursor-pointer font-bold text-white px-4 hover:text-blue-400 hover:border-b-2 hover:border-blue-400 transition-all duration-200">
        Objetivos
      </label>
    </div>

    <!-- Contenido -->
    <div class="flex-1 overflow-y-auto divide-y divide-black">

      <!-- Panel Mejoras -->
      <div class="p-6 min-h-[120px] bg-gray-700 rounded-xl m-4 shadow-md hover:bg-gray-600 transition-all duration-300">
        <h3 class="font-bold text-lg mb-1">Mejora 1</h3>
        <p class="text-sm text-gray-300">Mejora inicial del sistema base.</p>
        <div class="mt-4 flex justify-end">
          <button class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-full text-sm">Comprar $150</button>
        </div>
      </div>
      <div class="p-6 min-h-[120px] bg-gray-700 rounded-xl m-4 shadow-md hover:bg-gray-600 transition-all duration-300">
        <h3 class="font-bold text-lg mb-1">Mejora 2</h3>
        <p class="text-sm text-gray-300">Optimización de recursos de red.</p>
        <div class="mt-4 flex justify-end">
          <button class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-full text-sm">Comprar $200</button>
        </div>
      </div>
      <div class="p-6 min-h-[120px] bg-gray-700 rounded-xl m-4 shadow-md hover:bg-gray-600 transition-all duration-300">
        <h3 class="font-bold text-lg mb-1">Mejora 3</h3>
        <p class="text-sm text-gray-300">Aumento en la velocidad de ejecución.</p>
        <div class="mt-4 flex justify-end">
          <button class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-full text-sm">Comprar $250</button>
        </div>
      </div>
      <div class="p-6 min-h-[120px] bg-gray-700 rounded-xl m-4 shadow-md hover:bg-gray-600 transition-all duration-300">
        <h3 class="font-bold text-lg mb-1">Mejora 4</h3>
        <p class="text-sm text-gray-300">Interfaz gráfica avanzada.</p>
        <div class="mt-4 flex justify-end">
          <button class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-full text-sm">Comprar $300</button>
        </div>
      </div>
      <div class="p-6 min-h-[120px] bg-gray-700 rounded-xl m-4 shadow-md hover:bg-gray-600 transition-all duration-300">
        <h3 class="font-bold text-lg mb-1">Mejora 5</h3>
        <p class="text-sm text-gray-300">Soporte de nuevas tecnologías.</p>
        <div class="mt-4 flex justify-end">
          <button class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-full text-sm">Comprar $350</button>
        </div>
      </div>

      <!-- Panel Objetivos -->
      <div class="p-6 min-h-[120px] bg-gray-700 rounded-xl m-4 shadow-md hover:bg-gray-600 transition-all duration-300">
        <h3 class="font-bold text-lg mb-1">Objetivo 1</h3>
        <p class="text-sm text-gray-300">Completa el tutorial básico.</p>
        <div class="mt-4 text-right text-green-400 text-sm font-medium">
          Recompensas: +50 XP, +$100
        </div>
      </div>
      <div class="p-6 min-h-[120px] bg-gray-700 rounded-xl m-4 shadow-md hover:bg-gray-600 transition-all duration-300">
        <h3 class="font-bold text-lg mb-1">Objetivo 2</h3>
        <p class="text-sm text-gray-300">Configura tu primer módulo.</p>
        <div class="mt-4 text-right text-green-400 text-sm font-medium">
          Recompensas: +100 XP, +$200
        </div>
      </div>
      <div class="p-6 min-h-[120px] bg-gray-700 rounded-xl m-4 shadow-md hover:bg-gray-600 transition-all duration-300">
        <h3 class="font-bold text-lg mb-1">Objetivo 3</h3>
        <p class="text-sm text-gray-300">Integra un nuevo componente.</p>
        <div class="mt-4 text-right text-green-400 text-sm font-medium">
          Recompensas: +150 XP, +$300
        </div>
      </div>
      <div class="p-6 min-h-[120px] bg-gray-700 rounded-xl m-4 shadow-md hover:bg-gray-600 transition-all duration-300">
        <h3 class="font-bold text-lg mb-1">Objetivo 4</h3>
        <p class="text-sm text-gray-300">Realiza una simulación completa.</p>
        <div class="mt-4 text-right text-green-400 text-sm font-medium">
          Recompensas: +200 XP, +$400
        </div>
      </div>
      <div class="p-6 min-h-[120px] bg-gray-700 rounded-xl m-4 shadow-md hover:bg-gray-600 transition-all duration-300">
        <h3 class="font-bold text-lg mb-1">Objetivo 5</h3>
        <p class="text-sm text-gray-300">Alcanza nivel experto.</p>
        <div class="mt-4 text-right text-green-400 text-sm font-medium">
          Recompensas: +250 XP, +$500
        </div>
      </div>

    </div>

  </div>

</body>
</html>

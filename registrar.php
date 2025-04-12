<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registro</title>
  <script src="js/tailwindcss.js"></script>
</head>
<body class="h-screen w-screen bg-cover bg-center" style="background-image: url('ruta/a/tu-imagen.jpg');">
  <div class="flex items-center justify-center h-full backdrop-brightness-50">
    <div class="bg-black bg-opacity-70 p-8 rounded-2xl shadow-lg w-full max-w-md text-white">
      <h2 class="text-3xl font-semibold text-center mb-6">Crear Cuenta</h2>
      <form>
        <div class="mb-4">
          <label for="username" class="block text-sm mb-2">Usuario</label>
          <input type="text" id="username" class="w-full px-4 py-2 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>
        <div class="mb-4">
          <label for="email" class="block text-sm mb-2">Correo electrónico</label>
          <input type="email" id="email" class="w-full px-4 py-2 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>
        <div class="mb-4">
          <label for="password" class="block text-sm mb-2">Contraseña</label>
          <input type="password" id="password" class="w-full px-4 py-2 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>
        <div class="mb-6">
          <label for="confirm-password" class="block text-sm mb-2">Confirmar contraseña</label>
          <input type="password" id="confirm-password" class="w-full px-4 py-2 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>
        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">Registrarse</button>
      </form>
      <p class="text-center text-sm text-gray-400 mt-6">
        ¿Ya tienes una cuenta?
        <a href="index.php" class="text-blue-400 hover:underline">Inicia sesión</a>
      </p>
    </div>
  </div>
</body>
</html>

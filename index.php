<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <script src="js/tailwindcss.js"></script>
</head>
<body class="h-screen w-screen bg-cover bg-center" style="background-image: url('ruta/a/tu-imagen.jpg');">
  <div class="flex items-center justify-center h-full backdrop-brightness-50">
    <div class="bg-black bg-opacity-70 p-8 rounded-2xl shadow-lg w-full max-w-md text-white">
      <h2 class="text-3xl font-semibold text-center mb-6">Iniciar Sesión</h2>
      <form action="index.php" method="post">
        <div class="mb-4">
          <label for="username" class="block text-sm mb-2">Usuario</label>
          <input type="text" name="username" id="username" class="w-full px-4 py-2 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>
        <div class="mb-6">
          <label for="password" class="block text-sm mb-2">Contraseña</label>
          <input type="password" name="password" id="password" class="w-full px-4 py-2 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">Entrar</button>
      </form>
      <p class="text-center text-sm text-gray-400 mt-6">
        ¿No tienes cuenta?
        <a href="registrar.php" class="text-blue-400 hover:underline">Regístrate aquí</a>
      </p>
    </div>
  </div>
</body>
</html>


<?php
session_start();
include_once("conexion.php");
if(!empty($_POST['username']) && !empty($_POST['password'])){
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $select = "SELECT * FROM usuarios WHERE Username = '$user' AND Pass = '$pass'";

    $resultado=mysqli_query($conexion,$select);
    $filas=mysqli_num_rows($resultado);

    while($row=mysqli_fetch_assoc($resultado)) {

    $_SESSION['Id_Usuario']=$row["Id_Usuario"];
    
    }

    if($filas > 0 ){
        
    header('location: inicio.php');
    }


}
    
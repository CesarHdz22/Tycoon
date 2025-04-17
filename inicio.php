<?php 
session_start();
include_once('conexion.php');

if (!isset($_SESSION['Id_Usuario'])) {
    header("Location: login.php");
    exit();
}
$Id_Usuario=$_SESSION['Id_Usuario'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cuadros con Links</title>
  <script src="js/tailwindcss.js"></script>
</head>
<body class="bg-gray-900 text-white min-h-screen p-6">

  <!-- Header superior con botón de cerrar sesión -->
  <header class="w-full fixed top-0 left-0 z-50 bg-gray-800 bg-opacity-90 flex justify-between items-center px-6 py-3 shadow-lg">
    <h2 class="text-xl font-bold">Panel de Usuario</h2>
    <a href="logout.php" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl transition duration-300 font-semibold">
      Cerrar Sesión
    </a>
  </header>

  <!-- Header flotante izquierda (Dinero REAL) -->
  <div class="fixed top-20 left-4 bg-black bg-opacity-70 px-4 py-2 rounded-xl shadow-lg z-40">
    <p class="text-lg font-semibold">💰 Dinero: $<span id="dinero">0</span></p>
  </div>

  <!-- Header flotante derecha (XP y Nivel REALES) -->
  <div class="fixed top-20 right-4 bg-black bg-opacity-70 px-4 py-2 rounded-xl shadow-lg z-40">
    <p class="text-lg font-semibold">🧠 XP: <span id="xp">0</span></p>
    <p class="text-lg font-semibold">📈 Nivel: <span id="level">0</span></p>
  </div>

  <h1 class="text-3xl font-bold text-center mt-28 mb-8">Módulos</h1>

  <!-- Contenedor de modulos-->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    
     <?php
      $sql="SELECT * FROM datos_jugador WHERE Id_Usuario = '$Id_Usuario' ";  
      $result=mysqli_query($conexion,$sql);
      while($mostrar=mysqli_fetch_array($result)){

     ?>
    <div class="relative border-2 border-gray-700 rounded-xl overflow-hidden group">
      <img src="ruta/a/tu-imagen1.jpg" alt="Opción 1" class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-300" />
      <a href="mejoras.php?Id_modulo=1" class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center text-xl font-semibold hover:bg-opacity-70 transition duration-300">
        Opción 1
      </a>
    </div>
    <?php } ?>
    
    
  </div>
</body>
</html>
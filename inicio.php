<?php 
session_start();
include_once('conexion.php');

if (!isset($_SESSION['Id_Usuario'])) {
    header("Location: login.php");
    exit();
}
$Id_Usuario=$_SESSION['Id_Usuario'];

$query = "SELECT u.Dinero, u.xp, n.id_nivel 
          FROM usuarios u
          JOIN niveles n ON u.Id_Nivel = n.id_nivel
          WHERE u.Id_Usuario = ".$_SESSION['Id_Usuario'];
$result = mysqli_query($conexion, $query);
$user_data = mysqli_fetch_assoc($result); 

//modulos bloq
$sql = "SELECT dj.*, m.Nombre as NombreModulo, m.Ganancia_Venta as GananciaBase
        FROM datos_jugador dj
        JOIN modulos m ON dj.Id_Modulo = m.Id_Modulo
        JOIN usuarios u ON dj.Id_Usuario = u.Id_Usuario
        WHERE dj.Id_Usuario = '$Id_Usuario' 
        AND m.NivelDesbloqueo <= u.Id_Nivel
        ORDER BY m.Id_Modulo";

$result = mysqli_query($conexion, $sql);



// Formatear dinero con separadores de miles
$dinero_formateado = number_format($user_data['Dinero'], 0, ',', '.');

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
  <p class="text-lg font-semibold">💰 Dinero: <span id="dinero"><?= $dinero_formateado ?></span></p>  </div>

  <!-- Header flotante derecha (XP y Nivel REALES) -->
  <div class="fixed top-20 right-4 bg-black bg-opacity-70 px-4 py-2 rounded-xl shadow-lg z-40">
  <p class="text-lg font-semibold">🧠 XP: <span id="xp"><?= $user_data['xp'] ?></span></p>
  <p class="text-lg font-semibold">📈 Nivel: <span id="nivel"><?= $user_data['id_nivel'] ?></span></p>
  </div>

  <h1 class="text-3xl font-bold text-center mt-28 mb-8">Módulos</h1>
<!-- Contenedor de modulos-->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

<?php
$sql = "SELECT dj.*, u.Id_Nivel as NivelUsuario FROM datos_jugador dj 
        JOIN usuarios u ON dj.Id_Usuario = u.Id_Usuario 
        WHERE dj.Id_Usuario = '$Id_Usuario'";
$result = mysqli_query($conexion, $sql);
$contador = 1;

while (($mostrar = mysqli_fetch_array($result)) && $contador <= 12) {
  $nivelDesbloqueo = $mostrar['NivelDesbloqueo'];
  $nivelJugador = $mostrar['NivelUsuario'];
  $nivelModulo = $mostrar['Nivel'];


  if ($nivelJugador < $nivelDesbloqueo) {
    $rutaImagen = "img/default.png";
    $textoModulo = "Bloqueado";
    $enlace = "javascript:void(0)";
  } elseif ($nivelModulo == 0) {
    $rutaImagen = "img/default2.png";
    $textoModulo = "Desbloquear";
    $enlace = "mejoras.php?Id_modulo=$contador&ruta=$rutaImagen"; 
  } else {
    $rutaImagen = "img/N1/Modulo$contador.png";
    $textoModulo = "Módulo $contador";
    $enlace = "mejoras.php?Id_modulo=$contador&ruta=$rutaImagen"; 
  }
?>
  <div class="relative border-2 border-gray-700 rounded-xl overflow-hidden group">
  <img src="<?= $rutaImagen ?>" alt="<?= $textoModulo ?>" class="w-3/4 h- object-cover group-hover:scale-105 transition-transform duration-300 mx-auto" />
  <?php if ($textoModulo === "Desbloquear") : ?>
    <a href="#" onclick="confirmarDesbloqueo(<?= $mostrar['Id_Modulo'] ?>, <?= $mostrar['Precio'] ?>)" class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center text-xl font-semibold hover:bg-opacity-70 transition duration-300">
      <?= $textoModulo ?>
    </a>
  <?php else : ?>
    <a href="<?= $enlace ?>" class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center text-xl font-semibold hover:bg-opacity-70 transition duration-300">
      <?= $textoModulo ?>
    </a>
  <?php endif; ?>
</div>
<?php
  $contador++;
}
?>




</div>
  </div>
  <script>
// Función mejorada para actualizar datos
setInterval(() => {
  fetch("obtenerdatoss.php")
    .then(response => response.json())
    .then(data => {
      if (!data.error) {
        document.getElementById("dinero").innerText = `$${data.dinero}`;
        document.getElementById("xp").innerText = `${data.xp} XP`;
      }
    });
}, 500); // Actualiza cada medio segundo

function confirmarDesbloqueo(idModulo, precio) {
    if (confirm(`¿Deseas desbloquear este módulo por $${precio}?`)) {
      window.location.href = `desbloquear_modulo.php?Id_Modulo=${idModulo}`;
    }
  }
</script>


  
</body>
</html>

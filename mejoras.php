<?php 
session_start();
include_once('conexion.php');

if (!isset($_SESSION['Id_Usuario'])) {
    header("Location: login.php");
    exit();
}

// Obtener datos REALES del jugador
$query = "SELECT u.Dinero, u.xp, u.Id_Nivel, 
  (SELECT MAX(id_nivel) FROM niveles WHERE xp <= u.xp) as nivel_calculado,
  (SELECT xp FROM niveles WHERE id_nivel = (SELECT MAX(id_nivel) FROM niveles WHERE xp <= u.xp)) as xp_actual,
  (SELECT xp FROM niveles WHERE id_nivel = (SELECT MAX(id_nivel) FROM niveles WHERE xp <= u.xp) + 1) as xp_proximo_nivel
          FROM usuarios u
          WHERE u.Id_Usuario = ".$_SESSION['Id_Usuario'];
$result = mysqli_query($conexion, $query);
$user_data = mysqli_fetch_assoc($result);

// Obtener ID del módulo
$modulo_id = isset($_GET['Id_modulo']) ? intval($_GET['Id_modulo']) : 0;
$ruta = $_GET['ruta'];

// Formatear dinero con separadores de miles
$dinero_formateado = number_format($user_data['Dinero'], 0, ',', '.');
function calcularPorcentajeNivel($user_data) {
  $xp_actual = $user_data['xp'] - ($user_data['xp_actual'] ?? 0);
  $xp_necesario = ($user_data['xp_proximo_nivel'] ?? 1) - ($user_data['xp_actual'] ?? 0);
  
  if ($xp_necesario <= 0) return 100; // Nivel máximo
  
  return min(100, round(($xp_actual / $xp_necesario) * 100));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Detalles del Módulo</title>
  <script src="js/tailwindcss.js"></script>
  <style>
    .completed-objective {
      border-left: 4px solid #10B981;
      background-color: rgba(16, 185, 129, 0.1);
    }
    .tab-active {
      color: #34D399;
      border-bottom: 2px solid #34D399;
    }
    .tab-inactive {
      color: white;
      border-bottom: none;
    }
  </style>
</head>
<body class="bg-gray-900 text-white min-h-screen flex">

  <!-- Header fijo izquierda (Dinero) -->
  <div class="fixed top-4 left-4 bg-black bg-opacity-70 px-4 py-2 rounded-xl shadow-lg z-50">
    <p class="text-lg font-semibold">💰 Dinero: <span id="dinero"><?= $dinero_formateado ?></span></p>
  </div>

  <!-- Header fijo derecha (XP y Nivel) -->
  <div class="fixed top-4 right-[400px] bg-black bg-opacity-70 px-4 py-2 rounded-xl shadow-lg z-50">
    <p class="text-lg font-semibold">🧠 XP: <span id="xp"><?= $user_data['xp'] ?></span></p>
    <p class="text-lg font-semibold">📈 Nivel: <span id="level"><?= $user_data['nivel_calculado'] ?? 1 ?></span></p>
    <div class="w-full bg-gray-600 rounded-full h-2.5 mt-1">
        <div class="bg-blue-600 h-2.5 rounded-full" 
             style="width: <?= calcularPorcentajeNivel($user_data) ?>%"></div>
    </div>
    <p class="text-xs mt-1">
        <?= ($user_data['xp'] - ($user_data['xp_actual'] ?? 0)) ?> / 
        <?= (($user_data['xp_proximo_nivel'] ?? 0) - ($user_data['xp_actual'] ?? 0)) ?> XP
    </p>
</div>

  <!-- Botón Regresar -->
  <div class="fixed top-4 left-[calc(50%-235px)] z-50">
    <a href="inicio.php" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-xl shadow-lg">
      🔙 Regresar
    </a>
  </div>

  <!-- Panel Izquierdo -->
  <div class="flex-grow bg-white text-black flex items-center justify-center">
    <img src="<?= $ruta ?>" alt="Imagen Módulo" class="max-w-full max-h-full" />
  </div>

  <!-- Panel Derecho -->
  <div class="w-96 bg-gray-800 border-l-4 border-black flex flex-col">

    <!-- Tabs con selección visual -->
    <div class="flex border-b-2 border-black p-4">
      <button onclick="mostrarPanel('mejoras')"
        class="tab-btn font-bold px-4 tab-active"
        id="tab-mejoras">
        Mejoras
      </button>
      <div class="w-px bg-gray-600 mx-2"></div>
      <button onclick="mostrarPanel('objetivos')"
        class="tab-btn font-bold px-4 tab-inactive"
        id="tab-objetivos">
        Objetivos 
      </button>
    </div>

    <!-- Contenido -->
    <div class="flex-1 overflow-y-auto divide-y divide-black">
      <!-- Panel Mejoras -->
      <div id="panel-mejoras">
        <?php
        $query_mejoras = "SELECT m.* 
                  FROM mejoras m
                  LEFT JOIN mejoras_usuarios mu ON m.Id_Mejora = mu.Id_Mejora AND mu.Id_Usuario = {$_SESSION['Id_Usuario']}
                  WHERE m.Id_Modulo = $modulo_id 
                  AND mu.Id_MejoraUsuario IS NULL";
        $result_mejoras = mysqli_query($conexion, $query_mejoras);
        
        if (mysqli_num_rows($result_mejoras) > 0) {
            while ($mejora = mysqli_fetch_assoc($result_mejoras)) {
                $puede_comprar = $user_data['Dinero'] >= $mejora['Precio'];
        ?>
                <div class="p-6 bg-gray-700 rounded-xl m-4 shadow-md hover:bg-gray-600 transition-all">
                    <h3 class="font-bold text-lg mb-1"><?= htmlspecialchars($mejora['Nombre']) ?></h3>
                    <p class="text-sm text-gray-300"><?= htmlspecialchars($mejora['Descripcion']) ?></p>
                    <div class="mt-2 text-yellow-400 text-sm">
                        <?php if($mejora['reduccion_tiempo'] > 0): ?>
                            ⏱ -<?= $mejora['reduccion_tiempo'] ?> ciclos<br>
                        <?php endif; ?>
                        <?php if($mejora['cantidad_ventas'] > 0): ?>
                            🛒 +<?= $mejora['cantidad_ventas'] ?> ventas/lote<br>
                        <?php endif; ?>
                        <?php if($mejora['precio_venta'] > 0): ?>
                            💰 +$<?= number_format($mejora['precio_venta']) ?> ganancia/venta
                        <?php endif; ?>
                    </div>
                    <div class="mt-4 flex justify-between items-center">
                        <span class="text-lg font-bold <?= !$puede_comprar ? 'text-red-400' : 'text-green-400' ?>">
                            $<?= number_format($mejora['Precio']) ?>
                        </span>
                        <button onclick="<?= $puede_comprar ? "comprarMejora({$mejora['Id_Mejora']}, $modulo_id)" : "alert('Fondos insuficientes')" ?>" 
                                class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-full text-sm disabled:opacity-50"
                                <?= !$puede_comprar ? 'disabled' : '' ?>>
                            <?= $puede_comprar ? 'Comprar' : 'Fondos insuficientes' ?>
                        </button>
                    </div>
                </div>
        <?php
            }
        } else {
            echo '<p class="text-center text-gray-400 p-4">No hay mejoras disponibles para este módulo.</p>';
        }
        ?>
      </div>
      
      <!-- Panel Objetivos -->
      <div id="panel-objetivos" class="hidden p-4">
        <?php
        $query_objetivos = "SELECT o.*, ou.estado as completado 
                            FROM objetivos o
                            LEFT JOIN objetivos_usuarios ou ON o.Id_objetivos = ou.Id_objetivos 
                                AND ou.Id_Usuario = {$_SESSION['Id_Usuario']}
                            WHERE o.Id_Modulo = $modulo_id
                            ORDER BY o.Id_objetivos";
        $result_objetivos = mysqli_query($conexion, $query_objetivos);
        
        if (mysqli_num_rows($result_objetivos) > 0) {
            while ($objetivo = mysqli_fetch_assoc($result_objetivos)) {
                $completado = $objetivo['completado'] == 1;
        ?>
                <div class="p-6 bg-gray-700 rounded-xl m-4 shadow-md <?= $completado ? 'completed-objective' : '' ?>">
                    <h3 class="font-bold text-lg mb-1"><?= htmlspecialchars($objetivo['nombre']) ?></h3>
                    <p class="text-sm text-gray-300"><?= htmlspecialchars($objetivo['descripcion']) ?></p>
                    <div class="mt-4 flex justify-between items-center">
                        <div class="text-yellow-400">
                            <?php if(!$completado): ?>
                                <span>🛒 Ventas requeridas: <?= $objetivo['ventas'] ?></span>
                            <?php else: ?>
                                <span class="text-green-500">✅ Completado</span>
                            <?php endif; ?>
                        </div>
                        <div class="text-right">
                            <div class="text-sm">💰 $<?= number_format($objetivo['dinero']) ?></div>
                            <div class="text-sm">⭐ <?= $objetivo['xp'] ?> XP</div>
                        </div>
                    </div>
                </div>
        <?php
            }
        } else {
            echo '<p class="text-center text-gray-400 p-4">No hay objetivos disponibles para este módulo.</p>';
        }
        ?>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script>
    // Función para cambiar entre pestañas
    function mostrarPanel(panel) {
      const mejoras = document.getElementById('panel-mejoras');
      const objetivos = document.getElementById('panel-objetivos');
      const tabMejoras = document.getElementById('tab-mejoras');
      const tabObjetivos = document.getElementById('tab-objetivos');

      if (panel === 'mejoras') {
        mejoras.classList.remove('hidden');
        objetivos.classList.add('hidden');
        tabMejoras.classList.remove('tab-inactive');
        tabMejoras.classList.add('tab-active');
        tabObjetivos.classList.remove('tab-active');
        tabObjetivos.classList.add('tab-inactive');
      } else {
        mejoras.classList.add('hidden');
        objetivos.classList.remove('hidden');
        tabObjetivos.classList.remove('tab-inactive');
        tabObjetivos.classList.add('tab-active');
        tabMejoras.classList.remove('tab-active');
        tabMejoras.classList.add('tab-inactive');
      }
    }

    // Función para comprar mejoras
    async function comprarMejora(mejoraId, moduloId) {
      try {
        const response = await fetch('comprar_mejora.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            mejora_id: mejoraId,
            modulo_id: moduloId
          })
        });
        
        const result = await response.json();
        
        if (result.success) {
          alert('¡Mejora comprada con éxito!');
          location.reload(); // Recargar para ver cambios
        } else {
          alert(result.error || 'Error al comprar la mejora');
        }
      } catch (error) {
        console.error('Error:', error);
        alert('compra realizada con exito');
      }
    }

    // Función para verificar objetivos completados
    function verificarObjetivos() {
      fetch('verificar_objetivos.php')
        .then(response => response.json())
        .then(data => {
          if (data.success && data.completados > 0) {
            alert(`🎉 ¡Completaste ${data.completados} objetivo(s)! Recompensa: $${data.dinero} y ${data.xp} XP`);
            // Actualizar UI
            document.getElementById('dinero').textContent = data.nuevoDinero;
            document.getElementById('xp').textContent = data.nuevoXP;
          }
        })
        .catch(error => console.error('Error:', error));
    }

    // Actualizar dinero/XP cada 2 segundos
    setInterval(() => {
      fetch("obtenerdatoss.php")
        .then(response => response.json())
        .then(data => {
          if (!data.error) {
            document.getElementById("dinero").textContent = data.dinero;
            document.getElementById("xp").textContent = data.xp;
          }
        });
    }, 2000);

    // Verificar objetivos cada 5 segundos
    setInterval(verificarObjetivos, 5000);
    window.addEventListener('load', verificarObjetivos);
  </script>
</body>
</html>
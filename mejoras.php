<?php 
session_start();
include_once('conexion.php');

if (!isset($_SESSION['Id_Usuario'])) {
    header("Location: login.php");
    exit();
}

// Obtener datos REALES del jugador
$query = "SELECT u.Dinero, u.xp, n.id_nivel 
          FROM usuarios u
          JOIN niveles n ON u.Id_Nivel = n.id_nivel
          WHERE u.Id_Usuario = ".$_SESSION['Id_Usuario'];
$result = mysqli_query($conexion, $query);
$user_data = mysqli_fetch_assoc($result);

// Obtener ID del módulo
$modulo_id = isset($_GET['Id_modulo']) ? intval($_GET['Id_modulo']) : 0;

// Formatear dinero con separadores de miles
$dinero_formateado = number_format($user_data['Dinero'], 0, ',', '.');
?>

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
    <p class="text-lg font-semibold">💰 Dinero: <span id="money"><?= $dinero_formateado ?></span></p>
  </div>

  <!-- Header fijo derecha (XP y Nivel) -->
  <div class="fixed top-4 right-[400px] bg-black bg-opacity-70 px-4 py-2 rounded-xl shadow-lg z-50">
    <p class="text-lg font-semibold">🧠 XP: <span id="xp"><?= $user_data['xp'] ?></span></p>
    <p class="text-lg font-semibold">📈 Nivel: <span id="level"><?= $user_data['id_nivel'] ?></span></p>
  </div>

  <!-- Botón Regresar -->
  <div class="fixed top-4 left-[calc(50%-235px)] z-50">
    <a href="inicio.php" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-xl shadow-lg">
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
      <button onclick="mostrarPanel('mejoras')"
        class="tab-btn font-bold px-4 text-green-400 border-b-2 border-green-400"
        id="tab-mejoras">
        Mejoras
      </button>
      <div class="w-px bg-gray-600 mx-2"></div>
      <button onclick="mostrarPanel('objetivos')"
        class="tab-btn font-bold px-4 text-white hover:text-blue-400 hover:border-b-2 hover:border-blue-400"
        id="tab-objetivos">
        Objetivos 
      </button>
    </div>

    <!-- Contenido -->
    <div class="flex-1 overflow-y-auto divide-y divide-black">
      <!-- Panel Mejoras -->
      <div id="panel-mejoras">
        <?php
        // Obtener mejoras del módulo actual
        $query_mejoras = "SELECT * FROM mejoras WHERE Id_Modulo = $modulo_id";
        $result_mejoras = mysqli_query($conexion, $query_mejoras);
        
        if (mysqli_num_rows($result_mejoras) > 0) {
            while ($mejora = mysqli_fetch_assoc($result_mejoras)) {
        ?>
                <div class="p-6 bg-gray-700 rounded-xl m-4 shadow-md hover:bg-gray-600">
                    <h3 class="font-bold text-lg mb-1"><?= htmlspecialchars($mejora['Nombre']) ?></h3>
                    <p class="text-sm text-gray-300"><?= htmlspecialchars($mejora['Descripcion']) ?></p>
                    <div class="mt-2 text-yellow-400 text-sm">
                        <?php if($mejora['reduccion_tiempo'] > 0): ?>
                            ⏱ -<?= $mejora['reduccion_tiempo'] ?> segundos<br>
                        <?php endif; ?>
                        <?php if($mejora['ventas_por_lote'] > 0): ?>
                            🛒 +<?= $mejora['ventas_por_lote'] ?> ventas/lote<br>
                        <?php endif; ?>
                        <?php if($mejora['multiplicador_ganancia'] > 1): ?>
                            💰 x<?= $mejora['multiplicador_ganancia'] ?> ganancia
                        <?php endif; ?>
                    </div>
                    <div class="mt-4 flex justify-between items-center">
                        <span class="text-lg font-bold">$<?= number_format($mejora['Precio']) ?></span>
                        <button onclick="comprarMejora(<?= $mejora['Id_Mejora'] ?>, <?= $modulo_id ?>)" 
                                class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-full text-sm">
                            Comprar
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
      <div id="panel-objetivos" class="hidden">
        <div class="p-6 bg-gray-700 rounded-xl m-4 shadow-md hover:bg-gray-600">
          <h3 class="font-bold text-lg mb-1">Objetivo 1</h3>
          <p class="text-sm text-gray-300">Completa el tutorial básico.</p>
          <div class="mt-4 text-right text-green-400 text-sm font-medium">
            Recompensas: +50 XP, +$100
          </div>
        </div>
        <!-- Agrega más objetivos aquí -->
      </div>
    </div>
  </div>

  <!-- Script para cambiar paneles -->
  <script>
    function mostrarPanel(panel) {
      const mejoras = document.getElementById('panel-mejoras');
      const objetivos = document.getElementById('panel-objetivos');
      const tabMejoras = document.getElementById('tab-mejoras');
      const tabObjetivos = document.getElementById('tab-objetivos');

      if (panel === 'mejoras') {
        mejoras.classList.remove('hidden');
        objetivos.classList.add('hidden');
        tabMejoras.classList.add('text-green-400', 'border-b-2', 'border-green-400');
        tabObjetivos.classList.remove('text-blue-400', 'border-b-2', 'border-blue-400');
        tabObjetivos.classList.add('text-white');
      } else {
        mejoras.classList.add('hidden');
        objetivos.classList.remove('hidden');
        tabObjetivos.classList.add('text-blue-400', 'border-b-2', 'border-blue-400');
        tabMejoras.classList.remove('text-green-400', 'border-b-2', 'border-green-400');
        tabMejoras.classList.add('text-white');
      }
    }

    // Función para formatear números con separadores de miles
    function formatNumber(num) {
        return new Intl.NumberFormat('es-ES').format(num);
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
            
            if (result.error) {
                alert(result.error);
                return;
            }
            
            // Actualizar dinero en tiempo real
            document.getElementById('money').textContent = 
                formatNumber(result.nuevoDinero);
            
            alert('¡Mejora aplicada con éxito!');
            
        } catch (error) {
            console.error('Error:', error);
        }
    }

    // Función para actualizar los datos del jugador
    async function actualizarDatos() {
      try {
        const response = await fetch('obtenerdatoss.php');
        
        if (!response.ok) {
          throw new Error('Error en la respuesta del servidor');
        }
        
        const data = await response.json();
        
        // Actualizar los elementos en la página
        if (data.Dinero !== undefined) {
          document.getElementById('money').textContent = formatNumber(data.Dinero);
        }
        if (data.xp !== undefined) {
          document.getElementById('xp').textContent = data.xp;
        }
        if (data.id_nivel !== undefined) {
          document.getElementById('level').textContent = data.id_nivel;
        }
        
      } catch (error) {
        console.error('Error al actualizar datos:', error);
      }
    }

    // Actualizar inmediatamente al cargar
    document.addEventListener('DOMContentLoaded', actualizarDatos);
    
    // Configurar intervalo de actualización cada 1 segundo
    const intervalo = setInterval(actualizarDatos, 1000);
    
    // Limpiar intervalo cuando la página se cierre o navegue
    window.addEventListener('beforeunload', () => {
        clearInterval(intervalo);
    });
  </script>
</body>
</html>
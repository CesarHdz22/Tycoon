<?php
session_start();
include('conexion.php');

if (!isset($_SESSION['Id_Usuario'])) {
    echo json_encode(['success' => false, 'error' => 'No autenticado']);
    exit;
}

$usuario_id = $_SESSION['Id_Usuario'];

// 1. Obtener ventas actuales por módulo
$ventas_por_modulo = [];
$query_ventas = mysqli_query($conexion, 
    "SELECT Id_Modulo, ventas FROM datos_jugador WHERE Id_Usuario = $usuario_id"
);
while ($row = mysqli_fetch_assoc($query_ventas)) {
    $ventas_por_modulo[$row['Id_Modulo']] = $row['ventas'];
}

// 2. Buscar objetivos no completados
$query_objetivos = mysqli_query($conexion,
    "SELECT o.* FROM objetivos o
     LEFT JOIN objetivos_usuarios ou ON o.Id_objetivos = ou.Id_objetivos AND ou.Id_Usuario = $usuario_id
     WHERE ou.Id_objetivos_usuarios IS NULL
     AND o.Id_Modulo IN (" . implode(',', array_keys($ventas_por_modulo)) . ")"
);

$completados = 0;
$total_xp = 0;
$total_dinero = 0;

while ($objetivo = mysqli_fetch_assoc($query_objetivos)) {
    // 3. Verificar si se cumplió el objetivo
    if ($ventas_por_modulo[$objetivo['Id_Modulo']] >= $objetivo['ventas']) {
        // Registrar como completado
        mysqli_query($conexion,
            "INSERT INTO objetivos_usuarios (Id_Usuario, Id_objetivos, estado) 
             VALUES ($usuario_id, {$objetivo['Id_objetivos']}, 1)");
        
        // Sumar recompensas
        $total_xp += $objetivo['xp'];
        $total_dinero += $objetivo['dinero'];
        $completados++;
    }
}

// 4. Actualizar usuario si hay objetivos completados
if ($completados > 0) {
    mysqli_query($conexion,
        "UPDATE usuarios SET 
         Dinero = Dinero + $total_dinero,
         xp = xp + $total_xp
         WHERE Id_Usuario = $usuario_id");
}

echo json_encode([
    'success' => true,
    'completados' => $completados,
    'dinero' => $total_dinero,
    'xp' => $total_xp
]);

$query_nivel = mysqli_query($conexion,
    "SELECT id_nivel FROM niveles 
     WHERE xp <= (SELECT xp FROM usuarios WHERE Id_Usuario = $usuario_id)
     ORDER BY id_nivel DESC LIMIT 1"
);
$nuevo_nivel = mysqli_fetch_assoc($query_nivel)['id_nivel'] ?? 1;

// Actualizar nivel si cambió
mysqli_query($conexion,
    "UPDATE usuarios SET 
     Id_Nivel = $nuevo_nivel
     WHERE Id_Usuario = $usuario_id");

     
?>
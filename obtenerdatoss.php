<?php
session_start();
require_once 'conexion.php';

$id_usuario = $_SESSION['Id_Usuario'] ?? null;

if (!$id_usuario) {
    echo json_encode(['error' => 'No hay sesión activa']);
    exit;
}

// Obtener datos del usuario: dinero, xp y ciclos
$queryUsuario = "SELECT Dinero, xp, ciclos FROM usuarios WHERE Id_Usuario = ?";
$stmt = $conexion->prepare($queryUsuario);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$resultadoUsuario = $stmt->get_result();

if ($resultadoUsuario->num_rows === 0) {
    echo json_encode(['error' => 'Usuario no encontrado']);
    exit;
}

$usuario = $resultadoUsuario->fetch_assoc();
$dinero = $usuario['Dinero'];
$xp = $usuario['xp'];
$ciclos = $usuario['ciclos'] + 1; // Incrementar ciclos globales

// Obtener módulos activos del jugador
$queryModulos = "SELECT * FROM datos_jugador WHERE Id_Usuario = ? AND estado = 1";
$stmt = $conexion->prepare($queryModulos);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$modulos = $stmt->get_result();

while ($modulo = $modulos->fetch_assoc()) {
    $id_dato = $modulo['Id'];
    $ventas = $modulo['ventas'];
    $ganancia_venta = $modulo['ganancia_venta'];
    $ciclos_requeridos = $modulo['CiclosVenta'];
    $cantidad_ventas = $modulo['cantidad_ventas'] ?? 1;

    // Verificar si este ciclo corresponde a una producción
    if ($ciclos_requeridos > 0 && $ciclos % $ciclos_requeridos === 0) {
        $ganancia_total = $ganancia_venta * $cantidad_ventas;
        $dinero += $ganancia_total;
        $ventas += $cantidad_ventas;

        // Actualizar las ventas del módulo
        $updateModulo = "UPDATE datos_jugador SET ventas = ? WHERE Id = ?";
        $stmtUpdate = $conexion->prepare($updateModulo);
        $stmtUpdate->bind_param("ii", $ventas, $id_dato);
        $stmtUpdate->execute();
    }
}

// Actualizar dinero y ciclos del jugador
$queryUpdateUsuario = "UPDATE usuarios SET Dinero = ?, ciclos = ? WHERE Id_Usuario = ?";
$stmt = $conexion->prepare($queryUpdateUsuario);
$stmt->bind_param("dii", $dinero, $ciclos, $id_usuario);
$stmt->execute();

// Devolver datos actualizados al frontend
echo json_encode([
    'dinero' => round($dinero, 2),
    'xp' => $xp,
    'ciclos' => $ciclos
]);
?>

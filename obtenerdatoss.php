<?php
session_start();
include_once('conexion.php');

// Configurar cabeceras para JSON
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

try {
    if (!isset($_SESSION['Id_Usuario'])) {
        throw new Exception('No autenticado');
    }

    $userId = $_SESSION['Id_Usuario'];

    // Obtener datos del usuario
    $query = "SELECT u.Dinero, u.xp, n.id_nivel 
              FROM usuarios u
              JOIN niveles n ON u.Id_Nivel = n.id_nivel
              WHERE u.Id_Usuario = ?";
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);

    if (!$data) {
        throw new Exception('Datos no encontrados para el usuario');
    }

    // Obtener módulos activos
    $sql = "SELECT * FROM datos_jugador 
            WHERE Id_Usuario = ? AND estado = 1";
    $stmtModulos = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmtModulos, "i", $userId);
    mysqli_stmt_execute($stmtModulos);
    $resultModulos = mysqli_stmt_get_result($stmtModulos);

    $dineroGanado = 0;

    while ($modulo = mysqli_fetch_assoc($resultModulos)) {
        $moduloId = $modulo['Id_Modulo'];
        $tiempoVenta = $modulo['TiempoVenta'];
        $ultimaVenta = strtotime($modulo['ultima_actualizacion'] ?? '2000-01-01'); // Campo tipo DATETIME en tu tabla
        $ahora = time();

        if (($ahora - $ultimaVenta) >= $tiempoVenta) {
            $cantidad = $modulo['cantidad_ventas'];
            $gananciaUnidad = $modulo['ganancia_venta'];
            $ganancia = $gananciaUnidad * $cantidad;

            // Actualizar datos_jugador
            $updateModulo = "UPDATE datos_jugador 
                             SET ventas = ventas + ?,
                                 GananciaTotal = GananciaTotal + ?, 
                                 ultima_actualizacion = NOW()
                             WHERE Id_Usuario = ? AND Id_Modulo = ?";
            $stmtUpdateModulo = mysqli_prepare($conexion, $updateModulo);
            mysqli_stmt_bind_param($stmtUpdateModulo, "idii", $cantidad, $ganancia, $userId, $moduloId);
            mysqli_stmt_execute($stmtUpdateModulo);

            // Acumular ganancia total
            $dineroGanado += $ganancia;
        }
    }

    if ($dineroGanado > 0) {
        $stmtUpdateDinero = mysqli_prepare($conexion, "UPDATE usuarios SET Dinero = Dinero + ? WHERE Id_Usuario = ?");
        mysqli_stmt_bind_param($stmtUpdateDinero, "di", $dineroGanado, $userId);
        mysqli_stmt_execute($stmtUpdateDinero);
        $data['Dinero'] += $dineroGanado;
    }

    echo json_encode([
        'success' => true,
        'Dinero' => $data['Dinero'],
        'xp' => $data['xp'],
        'id_nivel' => $data['id_nivel']
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
} finally {
    if (isset($stmt)) mysqli_stmt_close($stmt);
    if (isset($stmtModulos)) mysqli_stmt_close($stmtModulos);
    mysqli_close($conexion);
}
?>
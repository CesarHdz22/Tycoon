<?php
session_start();
include('conexion.php');

header('Content-Type: application/json');

if (!isset($_SESSION['Id_Usuario'])) {
    echo json_encode(['error' => 'No autenticado']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$mejora_id = intval($data['mejora_id']);
$modulo_id = intval($data['modulo_id']);

try {
    // Obtener datos de la mejora
    $stmt = $conexion->prepare("SELECT * FROM mejoras WHERE Id_Mejora = ?");
    $stmt->bind_param("i", $mejora_id);
    $stmt->execute();
    $mejora = $stmt->get_result()->fetch_assoc();

    // Verificar si el usuario puede comprarla
    $stmt = $conexion->prepare("SELECT Dinero FROM usuarios WHERE Id_Usuario = ?");
    $stmt->bind_param("i", $_SESSION['Id_Usuario']);
    $stmt->execute();
    $dinero = $stmt->get_result()->fetch_row()[0];

    if ($dinero < $mejora['Precio']) {
        throw new Exception("Fondos insuficientes");
    }

    // Aplicar mejora
    $conexion->begin_transaction();

    // Actualizar módulo
    $update = "UPDATE datos_jugador SET 
                ganancia_venta = ganancia_venta * ?,
                tiempo_venta = ADDTIME(tiempo_venta, ?),
                cantidad_ventas = cantidad_ventas + ?
               WHERE Id_Usuario = ? AND Id_Modulo = ?";
    
    $stmt = $conexion->prepare($update);
    $stmt->bind_param("dssii", 
        $mejora['multiplicador_ganancia'],
        '-' . $mejora['reduccion_tiempo'] . ' SECONDS',
        $mejora['ventas_por_lote'],
        $_SESSION['Id_Usuario'],
        $modulo_id
    );
    $stmt->execute();

    // Descontar dinero
    $stmt = $conexion->prepare("UPDATE usuarios SET Dinero = Dinero - ? WHERE Id_Usuario = ?");
    $stmt->bind_param("di", $mejora['Precio'], $_SESSION['Id_Usuario']);
    $stmt->execute();

    $conexion->commit();

    echo json_encode(['success' => true, 'nuevoDinero' => $dinero - $mejora['Precio']]);

} catch (Exception $e) {
    $conexion->rollback();
    echo json_encode(['error' => $e->getMessage()]);
}
?>
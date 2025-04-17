<?php
// Conexión PDO
try {
    $pdo = new PDO("mysql:host=localhost;dbname=tycoon", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => "Conexión fallida: " . $e->getMessage()]);
    exit;
}

$usuario_id = isset($_GET['usuario_id']) ? intval($_GET['usuario_id']) : 0;
$modulo_id = isset($_GET['modulo_id']) ? intval($_GET['modulo_id']) : 0;

if ($usuario_id === 0 || $modulo_id === 0) {
    echo json_encode(['error' => 'Datos inválidos']);
    exit;
}

// Obtener info del módulo activo
$stmt = $pdo->prepare("SELECT * FROM datos_jugador WHERE Id_Usuario = ? AND Id_Modulo = ? AND estado = 1");
$stmt->execute([$usuario_id, $modulo_id]);
$modulo = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$modulo) {
    echo json_encode(['error' => 'Módulo inactivo o no encontrado']);
    exit;
}

$ganancia = $modulo['ganancia_venta'];
$nuevas_ventas = $modulo['ventas'] + 1;
$nueva_cantidad = $modulo['cantidad_ventas'] + 1;
$nueva_ganancia_total = $modulo['GananciaTotal'] + $ganancia;

// Actualizar datos del módulo
$stmt = $pdo->prepare("UPDATE datos_jugador SET ventas = ?, cantidad_ventas = ?, GananciaTotal = ? 
                       WHERE Id_Usuario = ? AND Id_Modulo = ?");
$stmt->execute([$nuevas_ventas, $nueva_cantidad, $nueva_ganancia_total, $usuario_id, $modulo_id]);

// Actualizar dinero del usuario
$stmt = $pdo->prepare("UPDATE usuarios SET Dinero = Dinero + ? WHERE Id_Usuario = ?");
$stmt->execute([$ganancia, $usuario_id]);

echo json_encode([
    'ok' => true,
    'modulo_id' => $modulo_id,
    'ganancia' => $ganancia,
    'ventas_totales' => $nuevas_ventas
]);
?>

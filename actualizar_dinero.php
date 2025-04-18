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

$stmt = $pdo->prepare("SELECT * FROM objetivos WHERE Id_Modulo = ?");
$stmt->execute([$modulo_id]);
$objetivos = $stmt->fetchAll();

foreach ($objetivos as $objetivo) {
    $condicion = match($objetivo['tipo']) {
        'ventas' => $nuevas_ventas >= $objetivo['valor_requerido'],
        'tiempo' => $modulo['tiempo_venta'] <= $objetivo['valor_requerido'],
        'lote' => $modulo['cantidad_ventas'] >= $objetivo['valor_requerido']
    };
    
    if ($condicion && !$objetivo['completado']) {
        // Otorgar recompensa
        $pdo->prepare("UPDATE usuarios SET 
                      Dinero = Dinero + ?,
                      xp = xp + ?
                      WHERE Id_Usuario = ?")
             ->execute([$objetivo['dinero'], $objetivo['xp'], $usuario_id]);
        
        // Marcar objetivo como completado
        $pdo->prepare("INSERT INTO objetivos_usuarios 
                      (Id_Usuario, Id_objetivos, estado)
                      VALUES (?, ?, 1)")
             ->execute([$usuario_id, $objetivo['Id_objetivos']]);
    }
}
?>
<?php
session_start();
include('conexion.php');

// Obtener todos los módulos activos del usuario
$stmt = $pdo->prepare("SELECT * FROM datos_jugador 
                      WHERE Id_Usuario = ? AND estado = 1");
$stmt->execute([$_SESSION['Id_Usuario']]);
$modulos_activos = $stmt->fetchAll();

foreach ($modulos_activos as $modulo) {
    // Calcular ganancia por lote
    $ganancia = $modulo['ganancia_venta'] * $modulo['cantidad_ventas'];
    
    // Actualizar dinero del usuario
    $stmt = $pdo->prepare("UPDATE usuarios 
                          SET Dinero = Dinero + ? 
                          WHERE Id_Usuario = ?");
    $stmt->execute([$ganancia, $_SESSION['Id_Usuario']]);
    
    // Registrar ventas
    $stmt = $pdo->prepare("UPDATE datos_jugador 
                          SET ventas = ventas + ?,
                              GananciaTotal = GananciaTotal + ?
                          WHERE Id_Usuario = ? AND Id_Modulo = ?");
    $stmt->execute([
        $modulo['cantidad_ventas'],
        $ganancia,
        $_SESSION['Id_Usuario'],
        $modulo['Id_Modulo']
    ]);
}

echo json_encode(['success' => true]);
?>
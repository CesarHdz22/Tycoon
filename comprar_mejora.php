
<?php
session_start();
include('conexion.php');

header('Content-Type: application/json');

if (!isset($_SESSION['Id_Usuario'])) {
    echo json_encode(['success' => false, 'error' => 'No autenticado']);
    exit;
}

$id_usuario = $_SESSION['Id_Usuario'];


$data = json_decode(file_get_contents('php://input'), true);
$mejora_id = intval($data['mejora_id']);
$modulo_id = intval($data['modulo_id']);

// 1. Verificar si el usuario ya tiene esta mejora
$check = mysqli_query($conexion, 
    "SELECT * FROM mejoras_usuarios 
     WHERE Id_Usuario = $id_usuario AND Id_Mejora = $mejora_id");
     
if (mysqli_num_rows($check) > 0) {
    echo json_encode(['success' => false, 'error' => 'Ya posees esta mejora']);
    exit;
}

// 2. Obtener datos de la mejora
$mejora = mysqli_fetch_assoc(mysqli_query($conexion,
    "SELECT * FROM mejoras WHERE Id_Mejora = $mejora_id"));
$datos_jugador = mysqli_fetch_assoc(mysqli_query($conexion,
    "SELECT * FROM datos_jugador WHERE Id_Usuario = $mejora_id"));
// 3. Verificar si tiene dinero suficiente
$usuario = mysqli_fetch_assoc(mysqli_query($conexion,
    "SELECT Dinero FROM usuarios WHERE Id_Usuario = $id_usuario"));

if ($usuario['Dinero'] < $mejora['Precio']) {
    echo json_encode(['success' => false, 'error' => 'Fondos insuficientes']);
    exit;
}



// 5. Actualizar módulo del usuario
mysqli_query($conexion,
    "UPDATE datos_jugador SET 
    ganancia_venta = ganancia_venta+{$mejora['precio_venta']}, CiclosVenta = CiclosVenta-{$mejora['reduccion_tiempo']}, cantidad_ventas = cantidad_ventas+{$mejora['cantidad_ventas']},Nivel = Nivel+1
     WHERE Id_Usuario = $id_usuario AND Id_Modulo = $modulo_id");

// 6. Descontar dinero
mysqli_query($conexion,
    "UPDATE usuarios SET 
     Dinero = Dinero - {$mejora['Precio']}
     WHERE Id_Usuario = $id_usuario");

// 7. Registrar la mejora comprada

if (mysqli_query($conexion,"INSERT INTO mejoras_usuarios (Id_Usuario, Id_Mejora, estado) VALUES ($id_usuario, $mejora_id, 1)")) {

    header("location: mejoras.php?Id_modulo=$moduloId&ruta=img/N1/Modulo$moduloId.png");
}
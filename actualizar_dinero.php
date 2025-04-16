<?php
session_start();
$idJugador = $_SESSION['Id_Usuario']; // O algo así

$db = new PDO('mysql:host=localhost;dbname=tycoon', 'root', '');

// 1. Obtener datos
$query = $db->query("SELECT Dinero, produccion_por_segundo, ultima_actualizacion FROM usuarios WHERE id = $idJugador");
$datos = $query->fetch();

$ahora = time();
$pasado = strtotime($datos['ultima_actualizacion']);
$generado = $datos['produccion_por_segundo'] * ($ahora - $pasado);
$nuevoDinero = $datos['dinero'] + $generado;

// 2. Guardar nuevos datos
$db->query("UPDATE usuarios SET Dinero = $nuevoDinero, ultima_actualizacion = NOW() WHERE id = $idJugador");

// 3. Responder con JSON
header('Content-Type: application/json');
echo json_encode([
  'dinero' => round($nuevoDinero)
]);
?>

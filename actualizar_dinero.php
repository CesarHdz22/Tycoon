<?php
session_start();
include_once("conexion.php");

if (!isset($_SESSION['Id_Usuario'])) {
    die(json_encode(['error' => 'No autenticado']));
}

$idJugador = $_SESSION['Id_Usuario'];

// Obtener datos
$query = mysqli_query($conexion, 
    "SELECT Dinero, produccion_por_segundo, ultima_actualizacion 
    FROM usuarios 
    WHERE Id_Usuario = $idJugador");
$datos = mysqli_fetch_assoc($query);

// Cálculos
$ahora = time();
$pasado = strtotime($datos['ultima_actualizacion']);
$generado = $datos['produccion_por_segundo'] * ($ahora - $pasado);
$nuevoDinero = $datos['Dinero'] + $generado;

// Actualizar
mysqli_query($conexion, 
    "UPDATE usuarios 
    SET Dinero = $nuevoDinero, ultima_actualizacion = NOW() 
    WHERE Id_Usuario = $idJugador");

// Respuesta
header('Content-Type: application/json');
echo json_encode(['dinero' => round($nuevoDinero)]);
?>
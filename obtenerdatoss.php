<?php
session_start();
include_once("conexion.php");

if (!isset($_SESSION['Id_Usuario'])) {
    die(json_encode(['error' => 'No autenticado']));
}

$query = "SELECT u.Dinero, u.xp, n.id_nivel 
          FROM usuarios u
          JOIN niveles n ON u.Id_Nivel = n.id_nivel
          WHERE u.Id_Usuario = ".$_SESSION['Id_Usuario'];
$result = mysqli_query($conexion, $query);

header('Content-Type: application/json');
echo json_encode(mysqli_fetch_assoc($result));
?>
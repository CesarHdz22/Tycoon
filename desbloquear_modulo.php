<?php
session_start();
include("conexion.php");

$Id_Usuario = $_SESSION['Id_Usuario'];
$Id_Modulo = $_GET['Id_Modulo'];

$sql = "SELECT Dinero FROM usuarios WHERE Id_Usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $Id_Usuario);
$stmt->execute();
$stmt->bind_result($dinero);
$stmt->fetch();
$stmt->close();

$sql = "SELECT Precio FROM datos_jugador WHERE Id_Usuario = ? AND Id_Modulo = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ii", $Id_Usuario, $Id_Modulo);
$stmt->execute();
$stmt->bind_result($precio);
$stmt->fetch();
$stmt->close();

if ($dinero >= $precio) {
  
  $conexion->query("UPDATE usuarios SET Dinero = Dinero - $precio WHERE Id_Usuario = $Id_Usuario");
  $conexion->query("UPDATE datos_jugador SET cantidad_ventas = 1, Nivel = 1 WHERE Id_Usuario = $Id_Usuario AND Id_Modulo = $Id_Modulo");

  header("Location: inicio.php"); 
} else {
  header("Location: inicio.php"); 
}
?>

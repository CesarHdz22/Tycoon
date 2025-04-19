<?php
$host = 'localhost';    // Dirección del servidor de base de datos
$dbname = 'tycoon';  // Nombre de la base de datos
$username = 'root';  // Nombre de usuario de la base de datos
$password = '';  // Contraseña del usuario

try {
    // Crear la conexión PDO
    $conexion = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Establecer el modo de error de PDO a excepción
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Establecer el conjunto de caracteres a UTF-8
    $conexion->exec("SET NAMES 'utf8'");

} catch (PDOException $e) {
    // Manejo de errores en caso de fallo en la conexión
    echo "Error de conexión: " . $e->getMessage();
    exit();
}
?>

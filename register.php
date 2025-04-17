<?php
session_start();
include_once('conexion.php');

// Obtener datos del formulario
$username = trim(mysqli_real_escape_string($conexion, $_POST['username'] ?? ''));
$email = trim(mysqli_real_escape_string($conexion, $_POST['email'] ?? ''));
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm-password'] ?? '';

// Validaciones
$errors = [];

if (empty($username)) {
    $errors[] = "El nombre de usuario es obligatorio.";
} elseif (strlen($username) > 15) {
    $errors[] = "El nombre de usuario no puede exceder 15 caracteres.";
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Ingrese un correo electrónico válido.";
}

if (empty($password) || strlen($password) < 4) {
    $errors[] = "La contraseña debe tener al menos 4 caracteres.";
} elseif ($password !== $confirm_password) {
    $errors[] = "Las contraseñas no coinciden.";
}

// Verificar si usuario/email ya existen
if (empty($errors)) {
    $check = mysqli_query($conexion, 
        "SELECT Id_Usuario FROM usuarios 
         WHERE Username = '$username' OR correo = '$email'");
    
    if (mysqli_num_rows($check) > 0) {
        $errors[] = "El nombre de usuario o correo electrónico ya está registrado.";
    }
}

if (!empty($errors)) {
    echo "<script>alert('" . implode("\\n", $errors) . "'); window.history.go(-1);</script>";
    exit;
}

// Iniciar transacción
mysqli_autocommit($conexion, false);

try {
    // 1. Insertar usuario
    $insert_user = mysqli_query($conexion,
        "INSERT INTO usuarios (Username, Pass, correo, Dinero, xp, Id_Nivel) 
         VALUES ('$username', '$password', '$email', 0, 0, 1)");
    
    if (!$insert_user) {
        throw new Exception("Error al registrar usuario: " . mysqli_error($conexion));
    }
    
    $user_id = mysqli_insert_id($conexion);
    
    // 2. Insertar los 3 primeros módulos
    $insert_modules = mysqli_query($conexion,
        "INSERT INTO datos_jugador 
         (Id_Usuario, Id_Modulo, ventas, ganancia_venta, TiempoVenta, Nombre, GananciaTotal, NivelDesbloqueo, estado, cantidad_ventas)
         SELECT $user_id, Id_Modulo, 0, Ganancia_Venta, TiempoVenta, Nombre, 0.0, NivelDesbloqueo, TRUE, 0
         FROM modulos
         WHERE Id_Modulo IN (1, 2, 3)");
    
    if (!$insert_modules) {
        throw new Exception("Error al asignar módulos: " . mysqli_error($conexion));
    }
    
    // Confirmar transacción
    mysqli_commit($conexion);
    
    echo "<script>alert('¡Registro exitoso! Inicia sesión para comenzar.'); window.location.href = 'login.php';</script>";

} catch (Exception $e) {
    mysqli_rollback($conexion);
    echo "<script>alert('{$e->getMessage()}'); window.history.go(-1);</script>";
} finally {
    mysqli_close($conexion);
}
?>

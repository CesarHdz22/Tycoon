<?php
session_start();
include_once('conexion.php');

// Obtener datos del formulario
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm-password'] ?? '';

$errors = [];

// Validaciones
if (empty($username)) $errors[] = "El nombre de usuario es obligatorio.";
elseif (strlen($username) > 15) $errors[] = "El nombre de usuario no puede exceder 15 caracteres.";

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Ingrese un correo electrónico válido.";

if (empty($password) || strlen($password) < 4) $errors[] = "La contraseña debe tener al menos 4 caracteres.";
elseif ($password !== $confirm_password) $errors[] = "Las contraseñas no coinciden.";

// Verificar si el usuario o email ya existen
if (empty($errors)) {
    $stmt = mysqli_prepare($conexion, "SELECT Id_Usuario FROM usuarios WHERE Username = ? OR correo = ?");
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        $errors[] = "El nombre de usuario o correo electrónico ya está registrado.";
    }
    mysqli_stmt_close($stmt);
}

if (!empty($errors)) {
    echo "<script>alert('" . implode("\\n", $errors) . "'); window.history.go(-1);</script>";
    exit;
}

// Iniciar transacción
mysqli_autocommit($conexion, false);

try {
    // Insertar usuario
    $stmt = mysqli_prepare($conexion,
        "INSERT INTO usuarios (Username, Pass, correo, Dinero, xp, Id_Nivel, ciclos) 
         VALUES (?, ?, ?, 0, 0, 1, 0)");
    mysqli_stmt_bind_param($stmt, "sss", $username, $password, $email);
    mysqli_stmt_execute($stmt);
    $user_id = mysqli_insert_id($conexion);
    mysqli_stmt_close($stmt);

    // Copiar módulos desde la tabla 'modulos' a 'datos_jugador'
    $insert_modules = mysqli_query($conexion,
        "INSERT INTO datos_jugador 
         (Id_Usuario, Id_Modulo, estado, ventas, ganancia_venta, CiclosVenta, GananciaTotal, NivelDesbloqueo, cantidad_ventas, Precio)
         SELECT 
            $user_id, Id_Modulo,CASE WHEN NivelDesbloqueo = 1 THEN 1 ELSE 0 END, 0, Ganancia_Venta, CiclosVenta, 0, NivelDesbloqueo, 0, Precio
         FROM modulos");

    if (!$insert_modules) {
        throw new Exception("Error al copiar módulos: " . mysqli_error($conexion));
    }

    // Confirmar todo
    mysqli_commit($conexion);
    echo "<script>alert('¡Registro exitoso! Inicia sesión para comenzar.'); window.location.href = 'index.php';</script>";

} catch (Exception $e) {
    mysqli_rollback($conexion);
    echo "<script>alert('{$e->getMessage()}'); window.history.go(-1);</script>";
} finally {
    mysqli_close($conexion);
}
?>

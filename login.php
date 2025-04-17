
<?php
session_start();
include_once("conexion.php");
if(!empty($_POST['username']) && !empty($_POST['password'])){
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $select = "SELECT * FROM usuarios WHERE Username = '$user' AND Pass = '$pass'";

    $resultado=mysqli_query($conexion,$select);
    $filas=mysqli_num_rows($resultado);

    while($row=mysqli_fetch_assoc($resultado)) {

    $_SESSION['Id_Usuario']=$row["Id_Usuario"];
    
    }

    if($filas > 0 ){
        
    header('location: inicio.php');
    }

    echo "<script>alert('Usuario Inexistente'); window.history.go(-1);</script>";
}else{
    echo "<script>alert('Favor de llenar todos los datos'); window.history.go(-1);</script>";
}
    
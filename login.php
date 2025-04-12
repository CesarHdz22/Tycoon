<?php
include_once("conexion.php");
if(!empty($_POST['username']) && !empty($_POST['password'])){
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $select = "SELECT * FROM usuarios WHERE Username = '$user' AND Pass = '$pass'";

    $resultado=mysqli_query($conexion,$select);
    $filas=mysqli_num_rows($resultado);

    while($row=mysqli_fetch_assoc($resultado)) {

    $id=$row["Id_Usuario"];

    $_SESSION['Id_Usuario']=$id;
    

    }

    if($filas > 0 ){
        
    header('location: inicio.php');
    }


}
    
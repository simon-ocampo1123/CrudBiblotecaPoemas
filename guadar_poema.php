<?php
include("db/conexion.php");
if(isset($_POST["guardar_poema"])){
    $titulo = $_POST["poem-title"];
    $autor = $_POST["poem-author"];
    $poema = $_POST["poem-text"];
    //Consulta para insertar 
    $query = "INSERT INTO poemas(titulo,autor,poema) VALUES ('$titulo','$autor','$poema')";
    $resultado = mysqli_query($conn,$query);
    if(!$resultado){
        die("query fallo");
    }
    $_SESSION['massage']= 'poema guardado correctamente';
    $_SESSION['massage_type']= 'success';
    header("location: index.php");
}
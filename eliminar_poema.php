<?php
include("db/conexion.php");

if (isset($_GET["id"])) { 
    $id = $_GET["id"]; 
    $query = "DELETE FROM poemas WHERE id_poema = $id";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("error de eliminacion: " . mysqli_error($conn)); 
    }
    $_SESSION['massage'] = 'Poema eliminado'; 
    $_SESSION['massage_type'] = 'danger';
    header("Location: index.php"); 
}
?>

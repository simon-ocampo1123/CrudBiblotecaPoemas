<?php
include("db/conexion.php");

if (isset($_POST['editar_poema'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $titulo = mysqli_real_escape_string($conn, $_POST['modal-poem-title']);
    $autor = mysqli_real_escape_string($conn, $_POST['modal-poem-author']);
    $poema = mysqli_real_escape_string($conn, $_POST['modal-poem-text']);

    // Actualizar el poema en la base de datos
    $query = "UPDATE poemas SET titulo='$titulo', autor='$autor', poema='$poema' WHERE id_poema='$id'";
    $resultado = mysqli_query($conn, $query);

    if (!$resultado) {
        die("Query falló: " . mysqli_error($conn));
    }

    $_SESSION['massage'] = 'Poema editado satisfactoriamente';
    $_SESSION['massage_type'] = 'warning';
    header("Location: admin/index.php");
}
?>

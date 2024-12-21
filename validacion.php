<?php
session_start();
include "db/conexion.php";

if (isset($_POST['usuario']) && isset($_POST['contraseña'])) {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    if (!$conn) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    $usuario = mysqli_real_escape_string($conn, $usuario);
    $contraseña = mysqli_real_escape_string($conn, $contraseña);

    $consulta = "SELECT * FROM usuario WHERE usuario='$usuario' AND contraseña='$contraseña'";
    $resultado = mysqli_query($conn, $consulta);

    if ($resultado) {
        $row = $resultado->fetch_assoc();

        if ($row) {
            $_SESSION['usuario'] = $usuario; // Establecer la variable de sesión
            if ($row['id_cargo'] == 1) {
                header("Location: index.php");
                exit();
            } else if ($row['id_cargo'] == 2) {
                header("Location: cliente.php");
                exit();
            } else {
                include("login.html");
                echo '<h1 class="bad">ERROR EN LA AUTENTIFICACIÓN</h1>';
            }
        } else {
            include("login.html");
            echo '<h1 class="bad">ERROR: Usuario o contraseña incorrectos</h1>';
        }
        mysqli_free_result($resultado);
    } else {
        echo "Error en la consulta: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    include("login.html");
    echo '<h1 class="bad">Ingrese usuario y contraseña</h1>';
}
?>

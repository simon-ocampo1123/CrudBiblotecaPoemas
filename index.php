<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    // Redirigir al login si no hay sesión activa
    header('Location: login.html');
    exit();
} else {
    //echo "Usuario: " . $_SESSION['usuario'];
}

include ("db/conexion.php");
include ("vistas/header.php");


?>
<!-- Sección de imágenes y explicación -->
<div class="container">
    <div class="row ">
    <?php if (isset($_SESSION['massage'])) { ?>
            <div class="alert alert-<?= $_SESSION['massage_type']; ?>" role="alert">
                <?= $_SESSION['massage']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php session_unset();
        } ?>
        <div class="col-sm-12 col-md-4">
            <img src="https://facartes.uniandes.edu.co/wp-content/uploads/2020/06/Literatura-en-occidente.jpg" alt="" width="310%" height="300" ">
        </div>
        <div class="col-md-12 py-5">
            <h2 class="text-center my-4">Bienvenidos a Aurora Poética: Donde las Palabras Son Estrellas</h2>
            <p class="lead">
                En las páginas de "Aurora Poética", te sumergirás en un mundo de sensaciones y sentimientos plasmados en cada verso. Este santuario de la palabra escrita ofrece un refugio para el alma inquieta, donde la poesía es más que un arte, es un camino hacia la comprensión y la belleza. <br><br>
                Cada poema es un destello de luz en la oscuridad, una invitación a explorar los misterios del corazón humano. Desde la melancolía de la noche hasta el brillo radiante del amanecer, cada página de "Aurora Poética" es una celebración de la vida y el poder transformador de la palabra. <br><br>
                Bienvenidos a un lugar donde los versos son estrellas y las emociones se tejen con palabras. Bienvenidos a "Aurora Poética".
            </p>
        </div>
    </div>
</div>
<!-- Fin de la sección de imágenes y explicación -->

<!-- Botón para agregar poema -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modal">Agregar Poema</button>
        </div>
    </div>
</div>
<!-- Modal para agregar poema -->
<div class="modal" id="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Nuevo Poema</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="guadar_poema.php" method="POST"> 
                    <div class="form-group">
                        <label for="poem-title">Título del Poema:</label>
                        <input type="text" class="form-control" id="poem-title" name="poem-title"> 
                    </div>
                    <div class="form-group">
                        <label for="poem-author">Autor del poema:</label>
                        <input type="text" class="form-control" id="poem-author" name="poem-author">
                    </div>
                    <div class="form-group">
                        <label for="poem-text">Texto del Poema:</label>
                        <textarea class="form-control" id="poem-text" name="poem-text" rows="4"></textarea> 
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-outline-warning" id="save-poem-btn" name="guardar_poema">Guardar cambios</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Tarjetas de productos -->
<div class="container">
    <div class="row">
        <?php
            $query = "SELECT * FROM poemas";
            $resultado_poema = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($resultado_poema)) {
                $titulo = $row['titulo'];
                $autor = $row['autor'];
                $poema = $row['poema'];
        ?>
        <div class="col-md-4 py-2">
            <div class="card" id="poema-<?php echo str_replace(' ', '-', $titulo); ?>" style="width: 18rem;">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS9urCvmHiNoeuLoTnjZiqHxJCPGXhw7v6PMg6N8fshoFZi-v-JxlJZRSU5sipkY1j0IkE&usqp=CAU" class="card-img-top" alt="" >
                <div class="card-body">
                    <h5 class="card-title"><?php echo $titulo; ?></h5>
                    <p class="card-text">Por: <?php echo $autor; ?></p>
                    <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#poemModal-<?php echo str_replace(' ', '-', $titulo); ?>" data-poem-title="<?php echo $titulo; ?>" data-poem-author="<?php echo $autor; ?>" data-poem-text="<?php echo $poema; ?>">Ver</button>
                </div>
            </div>
        </div>

<!-- Modal para mostrar el poema completo -->
<div class="modal fade" id="poemModal-<?php echo str_replace(' ', '-', $titulo); ?>" tabindex="-1" role="dialog" aria-labelledby="poemModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="poemModalLabel">Poema: <?php echo $titulo; ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="editar_poema.php" method="POST">
                    <div class="form-group">
                        <label for="modal-poem-title-<?php echo str_replace(' ', '-', $titulo); ?>">Título:</label>
                        <input type="text" class="form-control" id="modal-poem-title-<?php echo str_replace(' ', '-', $titulo); ?>" name="modal-poem-title" value="<?php echo $titulo; ?>">
                    </div>
                    <div class="form-group">
                        <label for="modal-poem-author-<?php echo str_replace(' ', '-', $titulo); ?>">Autor:</label>
                        <input type="text" class="form-control" id="modal-poem-author-<?php echo str_replace(' ', '-', $titulo); ?>" name="modal-poem-author" value="<?php echo $autor; ?>">
                    </div>
                    <div class="form-group">
                        <label for="modal-poem-text-<?php echo str_replace(' ', '-', $titulo); ?>">Poema:</label>
                        <textarea class="form-control" id="modal-poem-text-<?php echo str_replace(' ', '-', $titulo); ?>" name="modal-poem-text" rows="6"><?php echo $poema; ?></textarea>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $row['id_poema']; ?>">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-outline-warning" name="editar_poema">Guardar cambios</button>
                        <a href="eliminar_poema.php?id=<?php echo $row['id_poema']; ?>" title="Eliminar" class="btn btn-outline-warning">Eliminar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
        <?php
            }
        ?>
    </div>
</div>



<!-- Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Evento clic para abrir el modal del poema completo
        $(document).on("click", ".view-poem-btn", function () {
            var poemTitle = $(this).data("poem-title");
            var poemAuthor = $(this).data("poem-author");
            var poemText = $(this).data("poem-text");

            $("#modal-poem-author").text(poemAuthor);
            $("#modal-poem-text").text(poemText);
        });

        // Evento clic para guardar los cambios en el poema
        $(".save-changes-btn").click(function () {
            var poemTitle = $(this).data("poem-title");
            var modalPoemAuthor = $("#modal-poem-author-" + poemTitle).val();
            var modalPoemText = $("#modal-poem-text-" + poemTitle).val();

            // Enviar los datos al servidor para guardarlos
            $.post("Editar.php?archivo=<?php echo urlencode($archivo); ?>", {
                "modal-poem-author": modalPoemAuthor,
                "modal-poem-text": modalPoemText
            }, function(response) {
                // Manejar la respuesta del servidor si es necesario
                // Por ejemplo, redirigir al usuario a otra página
                window.location.href = "admin/index.php";
            });
        });
    });
</script>

</body>
</html>

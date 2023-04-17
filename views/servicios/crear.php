<h1 class="nombre-pagina">Crear</h1>
<p class="descripcion-pagina">Crear Nuevo Servicio</p>
<?php
    include_once __DIR__ . '/../templates/barra.php';
?>
<form action="/servicios/crear" method="POST" class="fomulario">
    <?php 
        include_once __DIR__ . '/formulario.php';
    ?>
    <input type="submit" class="boton" value="Guardar Servicio">
</form>
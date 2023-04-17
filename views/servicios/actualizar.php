<h1 class="nombre-pagina">Actualizar</h1>
<p class="descripcion-pagina">Actualizar Servicio</p>
<?php
    include_once __DIR__ . '/../templates/barra.php';
?>
<form method="POST" class="fomulario">
    <?php 
        include_once __DIR__ . '/formulario.php';
    ?>
    <input type="submit" class="boton" value="Actualizar Servicio">
</form>
<h1 class="nombre-pagina">Reestablecer Contraseña</h1>
<p class="descripcion-pagina">Coloca la nueva Contraseña</p>
<?php include_once __DIR__ . "/../templates/alertas.php"; ?>
if($error){
    return;
}
?>
<form class="formulario" method="POST">
    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" placeholder="Tu Contraseña">
    </div>
    <input type="submit" class="boton" value="Reestablecer Contraseña">
</form>
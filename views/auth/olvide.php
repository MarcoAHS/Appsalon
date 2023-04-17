<h1 class="nombre-pagina">Recuperar Password</h1>
<p class="descripcion-pagina">Llena el Formulario para Recuperar tu Password</p>
<?php include_once __DIR__ . "/../templates/alertas.php"; ?>
<form class="formulario" action="/olvide" method="POST">
    <div class="campo">
        <label for="email">Email</label>
        <input type="emali" id="email" name="email" placeholder="Tu Email">
    </div>
    <input type="submit" class="boton" value="Enviar Instrucciones">
</form>
<div class="acciones">
    <a href="/">Iniciar Sesion</a>
    <a href="/crear">Crear Cuenta</a>
</div>
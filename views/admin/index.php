<h1 class="nombre-pagina">Administracion</h1>
<?php include_once __DIR__ . '/../templates/barra.php'; ?>
<h2>Buscar Citas</h2>
<div class="busqueda">
    <form class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="fecha" value="<?php echo $fecha; ?>">
        </div>
    </form>
</div>
<?php if(count($citas) === 0){?>
    <h2>No hay Citas en esta fecha</h2>
<?php }?>
<div id="citas-admin">
    <ul class="citas">
        <?php
        $idCita = 0;
        $total = 0;
        foreach($citas as $key => $cita){
            $total += intval($cita->precio);
            if($idCita !== $cita->id){
                $idCita = $cita->id;?>
                <li>
                <p>ID: <span><?php echo $cita->id;?></span></p>
                <p>Hora: <span><?php echo $cita->hora . ' ' . $cita->fecha;?></span></p>
                <p>Cliente: <span><?php echo $cita->cliente;?></span></p>
                <p>Email: <span><?php echo $cita->email;?></span></p>
                <p>Telefono: <span><?php echo $cita->telefono;?></span></p>
                <h3>Servicios</h3>
                <?php }?>
                <p class="servicio">Servicio: <?php echo $cita->servicio . ' $' . $cita->precio;?></p>
        <?php
        $actual = $cita->id;
        $proximo = $citas[$key + 1]->id ?? 0;
        if(esUltimo($actual, $proximo)){
            ?>
            <p>Total: <span>$<?php echo $total;?></span></p>
            </li>
            <form action="/api/eliminar" method="POST">
                <input type="hidden" name="id" value="<?php echo $cita->id; ?>">
                <input type="submit" class="boton-eliminar" value="Eliminar">
            </form>
        <?php
            $total = 0;
        }
        }?>
    </ul>
</div>
<?php 
$script = "<script src='build/js/buscador.js'></script>";;
?>
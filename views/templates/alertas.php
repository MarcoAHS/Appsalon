<?php foreach($alertas as $key => $mensajes){ 
        foreach($mensajes as $alerta){
?>
    <div class="alerta <?php echo $key ?>"><?php echo $alerta; ?></div>
<?php
        }
} ?>
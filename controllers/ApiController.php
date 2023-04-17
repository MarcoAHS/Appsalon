<?php
namespace Controllers;

use Model\Cita;
use Model\CitasServicios;
use Model\Servicio;

class APIController{
    public static function index()
    {
        $servicios = Servicio::all();
        echo json_encode($servicios);
    }
    public static function guardar()
    {
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();
        $servicios = explode(',', $_POST['servicios']);
        foreach($servicios as $servicio){
            $args['citaId'] = $resultado['id'];
            $args['servicioId'] = $servicio;
            $citaServicio = new CitasServicios($args);
            $citaServicio->guardar();
        }
        $respuesta = [
            'resultado' => $resultado
        ];
        echo json_encode($respuesta);
    }
    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $cita = Cita::find($_POST['id']);
            CitasServicios::eliminarPorCita($_POST['id']);
            $cita->eliminar();
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
}
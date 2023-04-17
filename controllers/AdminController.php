<?php
namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController{
    public static function index(Router $router){
        session_start();
        isAdmin();
        $fecha = $_GET['fecha'] ?? date('Y-m-d');
        $fechaS = explode('-', $fecha);
        if(!checkdate($fechaS[1], $fechaS[2], $fechaS[0])){
            header('Location: /404');
        }
        $consulta = "SELECT citas.id, citas.hora, citas.fecha, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuarioId=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citas_servicios ";
        $consulta .= " ON citas_servicios.citaId=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citas_servicios.servicioId ";
        $consulta .= " WHERE fecha =  '${fecha}' ";
        $citas = AdminCita::SQL($consulta);
        $router->render('admin/index', [
            'nombre' => $_SESSION['nombre'],
            'id' => $_SESSION['id'],
            'citas' => $citas,
            'fecha' => $fecha
        ]);
    }
    public static function pillado(Router $router){
        $router->render('admin/404',[]);
    }
}
<?php
namespace Model;
class CitasServicios extends ActiveRecord{
    protected static $tabla = 'citas_servicios';
    protected static $columnasDB = ['id', 'citaId', 'servicioId'];
    public $id;
    public $citaId;
    public $servicioId;
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->citaId = $args['citaId'] ?? '';
        $this->servicioId = $args['servicioId'] ?? '';
    }
    public static function eliminarPorCita($citaId){
        $query = "DELETE FROM "  . self::$tabla . " WHERE citaId = " . self::$db->escape_string($citaId);
        $resultado = self::$db->query($query);
        return $resultado;
    }
    public static function eliminarPorServicio($servicioId){
        $query = "DELETE FROM "  . self::$tabla . " WHERE servicioId = " . self::$db->escape_string($servicioId);
        $resultado = self::$db->query($query);
        return $resultado;
    }
}
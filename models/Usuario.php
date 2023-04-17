<?php
namespace Model;

class Usuario extends ActiveRecord{
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? 0;
        $this->confirmado = $args['confirmado'] ?? 0;
        $this->token = $args['token'] ?? '';
    }
    public function validarNuevaCuenta(){
        if(!$this->nombre){
            self::$alertas['error'][] = 'Es necesario llenar el nombre';
        }
        if(!$this->apellido){
            self::$alertas['error'][] = 'Es necesario llenar el apellido';
        }        
        if(!$this->telefono){
            self::$alertas['error'][] = 'Es necesario llenar el telefono';
        }
        if(!$this->email){
            self::$alertas['error'][] = 'Es necesario llenar el email';
        }
        if(!$this->password){
            self::$alertas['error'][] = 'Es necesario llenar el password';
        }
        if(strlen($this->password) < 6){
            self::$alertas['error'][] = 'El password debe contener almenos 6 caracteres';
        }
    }
    public function existeUsuario(){
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";
        $resultado = self::$db->query($query);
        if($resultado->num_rows){
            self::$alertas['error'][] = 'El usuario ya esta registrado';
        }
        return $resultado;
    }
    public function hashPassword(){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }
    public function crearToken(){
        $this->token = uniqid();
    }
    public function validarLogin(){
        if(!$this->email){
            self::$alertas['error'][] = "EL email es obligatorio";
        }
        if(!$this->password){
            self::$alertas['error'][] = "EL password es obligatorio";
        }
    }
    public function validarEmail(){
        if(!$this->email){
            self::$alertas['error'][] = "EL email es obligatorio";
        }
    }
    public function validarPassword(){
        if(!$this->password){
            self::$alertas['error'][] = 'Es necesario llenar el password';
        }
        if(strlen($this->password) < 6){
            self::$alertas['error'][] = 'El password debe contener almenos 6 caracteres';
        }
    }
    public function comprobarPasswordAndVerificado($password){
        $resultado = password_verify($password, $this->password);
        if($resultado){
            if($this->confirmado){
                return true;
            } else {
                self::$alertas['error'][] = "El Usuario no esta Confirmado";
            }
        } else {
            self::$alertas['error'][] = "El password es incorrecto";
        }
    }
}
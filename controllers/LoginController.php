<?php
namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {
    public static function login(Router $router){
        $alertas = [];
        $auth = new Usuario;
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            $auth->validarLogin();
            $alertas = $auth->getAlertas();
            if(empty($alertas)){
                $usuario = Usuario::where('email', $auth->email);
                if($usuario){
                    $resultado = $usuario->comprobarPasswordAndVerificado($auth->password);
                    $alertas = Usuario::getAlertas();
                    if($resultado){
                        session_start();
                        $_SESSION['login'] = true;
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['apellido'] = $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        if($usuario->admin === "1"){
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                        } else {
                            header('Location: /cita');
                        }
                    }
                } else{
                    $alertas['error'][] = "Correo no valido";
                }
            }
        }
        $router->render('auth/login', [
            'alertas' => $alertas,
            'usuario' => $auth
        ]);
    }
    public static function logout(){
        session_start();
        $_SESSION = [];
        header('Location: /');
    }
    public static function olvide(Router $router){
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            $auth->validarEmail();
            $alertas = Usuario::getAlertas();
            if(empty($alertas)){
                $usuario = Usuario::where('email', $auth->email);
                if($usuario && $usuario->confirmado === '1'){
                    $usuario->crearToken();
                    $usuario->guardar();
                    //Enviar Email
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $resultado = $email->recuperar();
                    if($resultado){
                        $alertas['exito'][] = "Sigue las instrucciones que se mandaron a tu email";
                    } else{
                        $alertas['error'][] = "No se pudo mandar correo de confirmacion";
                    }
                } else {
                    $alertas['error'][] = "El usuario no existe o no esta confirmado";
                }
            }
        }        
        $router->render('auth/olvide', [
            'alertas' => $alertas
        ]);
    }
    public static function recuperar(Router $router){
        $alertas = [];
        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token);
        if(empty($usuario)){
            $alertas['error'][] = "Token no valido o Expiro";
            $error = true;
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario->password = $_POST['password'];
            $usuario->validarPassword();
            $alertas = Usuario::getAlertas();
            if(empty($alertas)){
                $usuario->hashPassword();
                $usuario->token = null;
                $resultado = $usuario->guardar();
                if($resultado){
                    $alertas['exito'][] = "Se Reestablecio la Contraseña";
                }
            }
        }
        $router->render('auth/recuperar', [
            'alertas' => $alertas,
            'error' => $error
        ]);
    }
    public static function crear(Router $router){
        $usuario = new Usuario;
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario->sincronizar($_POST);
            $usuario->validarNuevaCuenta();
            $alertas = Usuario::getAlertas();
            if(empty($alertas)){
                $resultado = $usuario->existeUsuario();
                if($resultado->num_rows){
                    $alertas = Usuario::getAlertas();
                } else{
                    $usuario->hashPassword();
                    $usuario->crearToken();
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $resultado = $usuario->guardar();
                    if($resultado){
                        $resultado = $email->enviar();
                        if($resultado){
                            header('Location: /mensaje');
                        } else{
                            $alertas['error'][] = "No se pudo mandar correo de confirmacion";
                        }
                        } else{
                            $alertas['error'][] = "No se pudo crear la cuenta";
                        }
                    }
                }
            }
        $router->render('auth/crear', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }
    public static function mensaje(Router $router){
        $router->render('auth/mensaje', []);
    }
    public static function confirmar(Router $router){
        $alertas = [];
        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token);
        if(empty($usuario)){
            $alertas['error'][] = "El Token no coincide";
        } else {
            $usuario->confirmado = "1";
            $usuario->token = null;
            $usuario->guardar();
            $alertas['exito'][] = "Se confirmo la cuenta";
        }
        $router->render('auth/confirmar', [
            'alertas' => $alertas
        ]);
    }
}
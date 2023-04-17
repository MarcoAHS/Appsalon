<?php
namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

 class Email{
    public $email;
    public $nombre;
    public $token;
    public function __construct($nombre, $email, $token){
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }
    public function enviar(){
        $phpmailer = new PHPMailer();
        $phpmailer->isSMTP();
        $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = 2525;
        $phpmailer->Username = '87d7eb3026b9c0';
        $phpmailer->Password = 'a8add32094a644';
        //Cuenta Que envia el correo
        $phpmailer->setFrom('AppSalon@correo.com', 'AppSalon.com');
        //Cuenta a la que se envia
        $phpmailer->addAddress($this->email, $this->nombre);      
        //Asunto
        $phpmailer->Subject = 'Confirma Tu cuenta';
        
        $phpmailer->isHTML(TRUE);
        $phpmailer->CharSet = "UTF-8";

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has creado tu cuenta con nosotros(AppSalon.com), solo debes confirmarla presionando el siguiente enlace: </p>";
        $contenido .= "<a href='http://127.0.0.1:3000/confirmar?token=". $this->token . "' >Confirmar Cuenta</a>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar este Correo</p>";
        $contenido .= "</html>";
        $phpmailer->Body = $contenido;
        $phpmailer->AltBody = 'Texto Alternativo';
        $resultado = $phpmailer->send();
        return $resultado;
    }
    public function recuperar(){
        $phpmailer = new PHPMailer();
        $phpmailer->isSMTP();
        $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = 2525;
        $phpmailer->Username = '87d7eb3026b9c0';
        $phpmailer->Password = 'a8add32094a644';
        //Cuenta Que envia el correo
        $phpmailer->setFrom('AppSalon@correo.com', 'AppSalon.com');
        //Cuenta a la que se envia
        $phpmailer->addAddress($this->email, $this->nombre);      
        //Asunto
        $phpmailer->Subject = 'Reestablecer Contraseña';
        
        $phpmailer->isHTML(TRUE);
        $phpmailer->CharSet = "UTF-8";

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has solicitado reestablecer tu Constraseña con nosotros(AppSalon.com), solo debes seguir el siguiente enlace para completar el proceso: </p>";
        $contenido .= "<a href='http://127.0.0.1:3000/recuperar?token=". $this->token . "' >Reestablecer Contraseña</a>";
        $contenido .= "<p>Si tu no solicitaste esta Reestablecimiento, puedes ignorar este Correo</p>";
        $contenido .= "</html>";
        $phpmailer->Body = $contenido;
        $phpmailer->AltBody = 'Texto Alternativo';
        $resultado = $phpmailer->send();
        return $resultado;
    }
 }
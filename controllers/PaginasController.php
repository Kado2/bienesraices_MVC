<?php
namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController {
    public static function index (Router $router) {
        $propiedades = Propiedad::all();
        $inicio = true;

        $router->render('paginas/homepage', [
            'propiedades' => $propiedades,
            'inicio' => $inicio
        ]);
    }
    public static function nosotros (Router $router) {
        $router->render('paginas/nosotros');
    }

    public static function anuncios (Router $router) {
        $propiedades = Propiedad::all();

        $router->render('paginas/anuncios', [
            'propiedades' => $propiedades,
        ]);
    }
    public static function anuncio (Router $router) {
        $id = validarORedireccionar('/');
        $propiedad = Propiedad::find($id);

        $router->render('paginas/anuncio', [
            'propiedad' => $propiedad,
        ]);
    }

    public static function blog (Router $router) {
        $router->render('paginas/blog');
    }

    public static function contacto (Router $router) {
        $mensaje = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = $_POST["contacto"];
            //Crear nueva instancia de PHPMailer
            $mail = new PHPMailer();
            //Configurar SMTP
            $mail->isSMTP();
            //Host del inbox
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = ********; // 
            $mail->Port = **********;
            $mail->Username = '***********';
            $mail->Password = '************'; 
            $mail->SMTPSecure = 'tls'; //transport layer security (previamente se usaba ssl, ahora se usa para certificados)
            //Configuracion del contenido del email
            $mail->setFrom('admin@bienesraices.com');
            $mail->addAddress('admin@bienesraices.com', 'BienesRaices.com');
            $mail->Subject = 'Tienes un nuevo mensaje';

            //habilitar html
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            //Contenido
            $contenido = '<html><p>Tienes un nuevo mensaje</p></br>';
            $contenido .= '<p>Nombre: ' . $datos["nombre"] . '</p>';
            $contenido .= '<p>mensaje: ' . $datos["mensaje"] .'</p>';
            $contenido .= '<p>opciones: ' . $datos["opciones"] . '</p>';
            $contenido .= '<p>precio: '. $datos["precio"] . '</p>';
            if ($datos["contactar"] === 'telefono') {
                $contenido .= '<p>telefono: ' . $datos["tel"] .'</p>';
                $contenido .= '<p>fecha: ' . $datos["fecha"] . '</p>';
                $contenido .= '<p>hora: ' . $datos["hora"] . '</p></html>';
            } else {
                $contenido .= '<p>email: '. $datos["email"] . '</p>';
            }

            $mail->Body=$contenido;
            $mail->AltBody='Esto es texto alternativo sin html';
            //Enviar email
            if($mail->send()) {
                $mensaje = "Mensaje enviado Correctamente";
            } else {
                $mensaje = "El mensaje no se pudo enviar";
            }
        }
        $router->render('paginas/contacto', [
            'mensaje' => $mensaje
        ]);
    }

    public static function entrada (Router $router) {
        $router->render('paginas/entrada');
    }
}

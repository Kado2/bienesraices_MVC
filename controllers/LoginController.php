<?php

namespace Controllers;
use MVC\Router;
use Model\Admin;

class LoginController {
    public static function login(Router $router) {
        $errores = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Admin($_POST['credenciales']);
            $errores = $auth->validar();

            if (empty($errores)) {
                // Verificar la existencia del usuario
                $resultado = $auth->verify_user();

                if (!$resultado) {
                    $errores = Admin::getErrores();
                } else {
                // Verificar el password
                    $autenticado = $auth->comprobarPassword($resultado);
                    if ($autenticado) {
                    // Autenticar al usuario
                    $auth->autenticar();

                    } else {
                        $errores = Admin::getErrores();
                    }

                }


            }
        }

        $router->render('auth/login',[
            'errores' => $errores,
        ]);
    }

    public static function logout() {
        session_start();

        $_SESSION = [];

        header('Location: /');
    }
}

?>
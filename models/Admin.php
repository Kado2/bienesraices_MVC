<?php

namespace Model;

class Admin extends ActiveRecord {
    //Base de datos
    protected static $tabla = 'usuarios';
    protected static $columnsDB = ['id' ,'email', 'password'];

    public $id;
    public $email;
    public $password;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? NULL;
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
    }

    public function validar(){
        if (!$this->email) {
            Self::$errores[] = "Debes ingresar un email";
        }
        if (!$this->password) {
            Self::$errores[] = "Debes ingresar la contraseña";
        }
        return Self::$errores;
    }

    public function verify_user() {
        $query = "SELECT * FROM " . static::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";
        $result = Self::consultarSQL($query);
        //Array shift retorna el valor de la primera posicion del array
        //$finded_object = n
        if (empty($result)) {
            Self::$errores[]= "El usuario no existe bobo";
            return;
        }
        return array_shift($result);
    }

    public function comprobarPassword($usuario) {
        $autenticado = password_verify($this->password, $usuario->password);
        if (!$autenticado) {
            Self::$errores[]= "Contraseña incorrecta bobo";
        }
        return $autenticado;
    }

    public function autenticar() {
        session_start();
                
        //Llenar el array de la sesion
        $_SESSION['usuario'] = $this->email;
        $_SESSION['login'] = true;
        
        header('Location: /admin');
    }
}
?>
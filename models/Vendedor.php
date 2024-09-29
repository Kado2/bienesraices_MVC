<?php

namespace Model;

class Vendedor extends ActiveRecord {
    protected static $tabla = 'vendedores';
    protected static $columnsDB = ['nombre', 'apellido', 'telefono'];

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? NULL;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
    }
    public function validar(){
        if (!$this->nombre) {
            Self::$errores[] = "Debes añadir un nombre";
        }
        if (!$this->apellido) {
            Self::$errores[] = "Debes añadir un apellido";
        }
        if (!$this->telefono) {
            Self::$errores[] = "El telefono es obligatorio";
        }
        return Self::$errores;
    }
}

?>
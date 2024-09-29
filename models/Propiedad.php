<?php

namespace Model;

class Propiedad extends ActiveRecord {
    protected static $tabla = 'propiedades';
    protected static $columnsDB = ['titulo' ,'precio','imagen','descripcion', 'habitaciones', 
    'wc', 'estacionamiento', 'creado', 'vendedores_id'];

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $vendedores_id;
    public $creado;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? NULL;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->vendedores_id = $args['vendedor'] ?? '';
        $this->creado = date('Y/m/d');
    }

    public function validar(){
        if (!$this->titulo) {
            Self::$errores[] = "Debes añadir un título";
        }
        if (!$this->precio) {
            Self::$errores[] = "Debes añadir un precio";
        }
        if ( strlen($this->descripcion) < 50) {
            Self::$errores[] = "La descripción es obligatoria y debe tener al menos 50 caracteres";
        }
        if (!$this->habitaciones) {
            Self::$errores[] = "El número de habitaciones es obligatorio";
        }
        if (!$this->wc) {
            Self::$errores[] = "El número de baños es obligatorio";
        }
        if (!$this->estacionamiento) {
            Self::$errores[] = "El número de estacionamientos es obligatorio";
        }
        if (!$this->vendedores_id) {
            Self::$errores[] = "La selección del vendedor es obligatoria";
        }
        if (!$this->imagen) {
            Self::$errores[] = "La imagen es obligatoria";
        }
        return Self::$errores;
    }
    // Subida de archivos
    public function setImagen($imagen) {
        //Eliminar imagen previa
        if(isset($this->id)) { 
            //Comprobar si existe el archivo
            $archive_existence = file_exists(CARPETA_IMAGENES . $this -> imagen);
            if ($archive_existence) {
                unlink(CARPETA_IMAGENES . $this->imagen);
            }
        }

        //Asignar al atributo de imagen el nombre
        if ($imagen){
            $this->imagen = $imagen;
        }
    }

    
}

?>
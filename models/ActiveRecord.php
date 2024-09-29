<?php
namespace Model;

class ActiveRecord {
    // Base de Datos
    protected static $db;
    protected static $columnsDB = ['titulo' ,'precio','imagen','descripcion', 'habitaciones', 
    'wc', 'estacionamiento', 'creado', 'vendedores_id'];
    protected static $tabla = '';

    // Errores
    protected static $errores = [];


    //Definir conexion a DB
    public static function setDB($database){
        Self::$db = $database;
    }  

     //Validacion
     public static function getErrores() {
        return static::$errores;
    }
    public function validar() {


        static::$errores = [];
        return static::$errores;
    }   

    public function atributos() {
        $atributos = [];
        foreach(static::$columnsDB as $column) {
            $atributos[$column] = $this->$column;
        }
        return $atributos;
    }

    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = Self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    public function guardar() {
        if (isset($this->id)){
            //update
            $result =$this->update();
        } else {
            //create
            $result = $this->create();
        }
        return $result;

    }
    public function delete() {
        //Eliminar el archivo
        $query = "DELETE FROM ". static::$tabla . " WHERE id = $this->id";
        $stmt = Self::$db->prepare($query);
        $resultado = $stmt->execute();
        if ($resultado) {
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
        return $resultado;
    }
    public function update() {
        //Sanitizar datos de entrada
        $atributos = $this->sanitizarAtributos();
        $healthy_values = [];
        foreach($atributos as $key=>$value){
            $healthy_values[] = "{$key}='{$value}'";
        }
        //Insertar en la base de datos
        $updated_row_sentence = join(", ",array_values($healthy_values));
        $query = "UPDATE ". static::$tabla . " SET $updated_row_sentence WHERE id = $this->id LIMIT 1";
        $stmt = Self::$db->prepare($query);
        $resultado = $stmt->execute();
        return $resultado;
        
    }

    public function create() {
        //Sanitizar datos de entrada
        $atributos = $this->sanitizarAtributos();

        //Insertar en la base de datos
        $columnas = join(', ',array_keys($atributos));
        $filas = join("', '",array_values($atributos));

        //*  Consulta para insertar datos
        $query = "INSERT INTO ". static::$tabla . "($columnas) VALUES ('$filas')";
        $stmt = Self::$db->prepare($query);
        $resultado = $stmt->execute();
        return $resultado;
    }

    // Listar propiedades
    public static function all() {
        $query = "SELECT * FROM " . static::$tabla; //busca el atributo en la clase en la cual se esta heredando
        return Self::consultarSQL($query);
    }
    public static function get_limited($cantidad) {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad;
        return Self::consultarSQL($query);
    }
    //Buscar registro por id
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = $id";
        $result = Self::consultarSQL($query);
        //Array shift retorna el valor de la primera posicion del array
        //$finded_object = n
        return array_shift($result);
    }

    public static function consultarSQL($query) {
        // Consultar DB
        $stmt = Self::$db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        //Iterar resultados
        $array = [];
        while($registro = $result -> fetch_assoc()){
            $array[] = static::crearObjeto($registro);
        }
        //Liberar la memoria
        $result->free();

        //Retornar los resultados
        return $array;
    }
    protected static function crearObjeto($registro){
        $objeto = new static;
        foreach ($registro as $key => $value) {
            if ( property_exists($objeto, $key) ) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }
    // Sincronizar el objeto en memoria con los cambios realizados por el usuario
    public function sincronizar( $args = [] ){
        foreach($args as $key => $value) {
            if(property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}


?>
<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

class PropiedadController {
    public static function index(Router $router) {
        $propiedades = Propiedad::all();
        $vendedores = Vendedor::all();
        $resultado = $_GET['resultado'] ?? null;

        $router->render('propiedades/admin', [
            'propiedades' => $propiedades,
            'vendedores' => $vendedores,
            'resultado' => $resultado
        ]);
    }
    
    public static function crear(Router $router) {
        $propiedad = new Propiedad;
        $vendedores = Vendedor::all();
        //Arreglo con mensajes de errores
        $errores = Propiedad::getErrores();

        if ($_SERVER["REQUEST_METHOD"] === 'POST'){

            $propiedad = new Propiedad($_POST['propiedad']);
            
            //Generar un nombre unico
            $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";  
    
            //Resize a la imagen con intervention
            if ($_FILES['propiedad']['tmp_name']['imagen']){
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                $propiedad->setImagen($nombreImagen);
            }
    
            $errores = $propiedad -> validar();
    
        //Revisar que el array de errores esta vacío 
    
            if (empty($errores)) {  
                //**SUBIDA DE ARCHIVOS**/

                //Crear carpeta imagenes
                if (!is_dir(CARPETA_IMAGENES)) {
                    mkdir(CARPETA_IMAGENES);
                }
    
                //Save image in server
                $image->save(CARPETA_IMAGENES . $nombreImagen);
    
                //Guardar en la base de datos
                $resultado = $propiedad->guardar();
    
                if ($resultado) {
                    //Redireccionar al usuario.
                    header('Location: /admin?resultado=1');
                } 
            }
        }

        $router->render('propiedades/crear', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }
    
    public static function actualizar(Router $router) {
        $id = validarORedireccionar('/admin');

        $propiedad = Propiedad::find($id);
        $vendedores = Vendedor::all();
        $errores = Propiedad::getErrores();

        if ($_SERVER["REQUEST_METHOD"] === 'POST'){

            //Asignar los atributos
            $args = $_POST['propiedad'];
            $propiedad->sincronizar($args);
    
            //Validar entradas
            $errores = $propiedad->validar();
            
            //**SUBIDA DE ARCHIVOS**/
    
            //Generar un nombre unico
            $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg"; 
    
            //Resize a la imagen con intervention
            if ($_FILES['propiedad']['tmp_name']['imagen']){
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                $propiedad->setImagen($nombreImagen);
            }
            if (empty($errores)) {  

                //Save image in server
                if ($image) {
                    $image->save(CARPETA_IMAGENES . $nombreImagen);
                }
                
                //Actualizar la base de datos
                $resultado = $propiedad->guardar();
    
                if ($resultado) {
                    //Redireccionar al usuario.
                    header('Location: /admin?resultado=2');
                } 
            }
        }

        $router->render('propiedades/actualizar', [
            'propiedad' => $propiedad,
            'errores' => $errores,
            'vendedores' => $vendedores
        ]);
    }

    public static function eliminar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $p_id = $_POST['id'];
            $p_id = filter_var($p_id, FILTER_VALIDATE_INT);
            if ($p_id) { 
                if (validarTipoContenido($_POST['tipo'])) {
                    $property_to_delete = Propiedad::find($p_id);
                    //Eliminar la propiedad
                    $resultado = $property_to_delete->delete();
                    }
                } 
    
                if($resultado) {
                    header('Location: /admin?resultado=3');
            }
        }
    }
}

<?php
namespace Controllers;
use MVC\Router;
use Model\Vendedor;

class VendedorController {
    public static function crear (Router $router) {
        $vendedor = new Vendedor;
        //Arreglo con mensajes de errores
        $errores = Vendedor::getErrores();
    
        if ($_SERVER["REQUEST_METHOD"] === 'POST'){
    
            $vendedor = new Vendedor($_POST['vendedor']);
        
            $errores = $vendedor -> validar();
        
        //Revisar que el array de errores esta vacío 
        
            if (empty($errores)) {  
                //**SUBIDA DE ARCHIVOS**/
        
                //Guardar en la base de datos
                $resultado = $vendedor->guardar();
        
                if ($resultado) {
                    //Redireccionar al usuario.
                    header('Location: /admin?resultado=1');
                } 
            }
        }
    
        $router->render('vendedores/crear', [
            'vendedor' => $vendedor,
            'errores' => $errores
        ]);
    }
    public static function actualizar(Router $router) {
        $id = validarORedireccionar('/admin');

        $vendedor = Vendedor::find($id);
        $errores = Vendedor::getErrores();

        if ($_SERVER["REQUEST_METHOD"] === 'POST'){

            //Asignar los atributos
            $args = $_POST['vendedor'];
            $vendedor->sincronizar($args);
    
            //Validar entradas
            $errores = $vendedor->validar();
            
            //**SUBIDA DE ARCHIVOS**/
            if (empty($errores)) {  
                
                //Actualizar la base de datos
                $resultado = $vendedor->guardar();
    
                if ($resultado) {
                    //Redireccionar al usuario.
                    header('Location: /admin?resultado=2');
                } 
            }
        }

        $router->render('vendedores/actualizar', [
            'vendedor' => $vendedor,
            'errores' => $errores,
        ]);
    }

    public static function eliminar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $v_id = $_POST['id'];
            $v_id = filter_var($v_id, FILTER_VALIDATE_INT);
            if ($v_id) { 
                if (validarTipoContenido($_POST['tipo'])) {
                    $vendor_to_delete = Vendedor::find($v_id);
                    //Eliminar la propiedad
                    $resultado = $vendor_to_delete->delete();
                    }
                } 
    
                if($resultado) {
                    header('Location: /admin?resultado=3');
            }
        }
    }
    

}

?>
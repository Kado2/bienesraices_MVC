<?php
define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
define('CARPETA_IMAGENES', $_SERVER['DOCUMENT_ROOT'] .'/imagenes/');

function incluirTemplate( string $nombre , bool $inicio = false ){
    include TEMPLATES_URL ."/{$nombre}.php";
}
function estaAutenticado(){
    session_start();
    if (!$_SESSION['login'] ) {    
        header('Location: / '); 
    }
}

function debug($variable) {
    echo"<pre>";
    var_dump($variable);
    echo"</pre>";
    exit;
}

// Escape / Sanitizar
function s($html) {
    $s = htmlspecialchars($html);
    return $s;
}

// Validar tipo de contenido
function validarTipoContenido($tipo) {
    $tipos = ['vendedor', 'propiedad'];

    return in_array($tipo, $tipos);
}

// Mostrar mensajes
function mostrarNotificacion($codigo) {
    $mensaje = '';
    switch($codigo){
        case 1:
            $mensaje = 'Creado Correctamente';
            break;
        case 2:
            $mensaje = 'Actualizado Correctamente';
            break;      
        case 3:
            $mensaje = 'Eliminado Correctamente';
            break; 
        default:
            $mensaje = false;
            break;
    }
    return $mensaje;
}

function validarORedireccionar (string $url) {
    //Validar el id
    $p_id = $_GET['id'];
    $p_id = filter_var($p_id, FILTER_VALIDATE_INT);

    if(!$p_id) {
        header('Location: ${url}');
    } else {
        return $p_id;
    }
}

?>
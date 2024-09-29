<?php

function conectDB() : mysqli {
    $db = new mysqli('localhost', 'root', 'root', 'bienesraices_crud');

    if (!$db) {
        echo "No se conectó";
        exit;
    }
    return $db; 
}

?>
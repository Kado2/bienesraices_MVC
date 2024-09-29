<?php

require 'funciones.php';
require 'config/databases.php';
require __DIR__ . '/../vendor/autoload.php';

//Conectar DB
$db = conectDB();

use Model\ActiveRecord;

ActiveRecord::setDB($db);


?>
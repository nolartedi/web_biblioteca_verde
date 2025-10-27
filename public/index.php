<?php
// Definir constantes
define('URLROOT', 'http://localhost:8080/web_biblioteca_verde/public/');
define('APPROOT', dirname(dirname(__FILE__)));

// Iniciar sesión
session_start();

// Cargar archivos core
require_once '../config/Helpers.php';
require_once '../core/App.php';
require_once '../core/Controller.php';
require_once '../core/Model.php';

// Inicializar la aplicación
$app = new App();